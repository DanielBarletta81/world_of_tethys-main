/* eslint-disable no-console */
require('dotenv').config();
const express = require('express');
const Stripe = require('stripe');
const { auth } = require('express-openid-connect');
const { MongoClient, ServerApiVersion } = require('mongodb');

const app = express();

const STRIPE_SECRET_KEY = process.env.STRIPE_SECRET_KEY || 'sk_test_REPLACE_WITH_YOUR_KEY';
const STRIPE_WEBHOOK_SECRET = process.env.STRIPE_WEBHOOK_SECRET || 'whsec_REPLACE_ME';
const stripe = new Stripe(STRIPE_SECRET_KEY, {
  apiVersion: '2023-10-16'
});

const PRODUCTS = {
  signals_ep01: {
    amount: parseInt(process.env.SIGNALS_EP01_AMOUNT || '99', 10),
    description: 'Signals from Tethys · Episode 01'
  },
  signals_bundle: {
    amount: parseInt(process.env.SIGNALS_BUNDLE_AMOUNT || '249', 10),
    description: 'Signals from Tethys · Bundle'
  }
};

const jsonParser = express.json();
const MAX_MESSAGES = parseInt(process.env.READING_ROOM_MAX_MESSAGES || '100', 10);

// Auth0 configuration
const AUTH0_DOMAIN = process.env.AUTH0_DOMAIN;
const AUTH0_BASE_URL = process.env.AUTH0_BASE_URL || process.env.APP_BASE_URL || 'http://localhost:3000';
const AUTH0_CLIENT_ID = process.env.AUTH0_CLIENT_ID;
const AUTH0_CLIENT_SECRET = process.env.AUTH0_CLIENT_SECRET;
const AUTH0_SECRET = process.env.AUTH0_SECRET || 'replace_this_with_env_secret';

if (!AUTH0_DOMAIN || !AUTH0_CLIENT_ID || !AUTH0_CLIENT_SECRET) {
  console.warn('Auth0 environment variables are not fully configured. OAuth login will be disabled.');
} else {
  app.set('trust proxy', 1);
  app.use(
    auth({
      authRequired: false,
      auth0Logout: true,
      issuerBaseURL: `https://${AUTH0_DOMAIN}`,
      baseURL: AUTH0_BASE_URL,
      clientID: AUTH0_CLIENT_ID,
      clientSecret: AUTH0_CLIENT_SECRET,
      secret: AUTH0_SECRET,
      authorizationParams: {
        response_type: 'code',
        scope: 'openid profile email'
      }
    })
  );
}

// MongoDB client for Reading Room
const mongoUri = process.env.MONGODB_URI;
const mongoDbName = process.env.MONGODB_DB || 'tethys';
const mongoCollectionName = process.env.READING_ROOM_COLLECTION || 'reading-room';
const transactionsCollectionName = process.env.TRANSACTIONS_COLLECTION || 'transactions';
let mongoClient;
let readingRoomCollection;
let transactionsCollection;

async function getReadingRoomCollection() {
  if (!mongoUri) {
    throw new Error('MONGODB_URI is not set. Reading Room storage unavailable.');
  }
  if (!mongoClient) {
    mongoClient = new MongoClient(mongoUri, { serverApi: ServerApiVersion.v1 });
    await mongoClient.connect();
  }
  if (!readingRoomCollection) {
    readingRoomCollection = mongoClient.db(mongoDbName).collection(mongoCollectionName);
    await readingRoomCollection.createIndex({ createdAt: -1 });
  }
  return readingRoomCollection;
}

async function getTransactionsCollection() {
  if (!mongoUri) {
    throw new Error('MONGODB_URI is not set. Transaction logging unavailable.');
  }
  if (!mongoClient) {
    mongoClient = new MongoClient(mongoUri, { serverApi: ServerApiVersion.v1 });
    await mongoClient.connect();
  }
  if (!transactionsCollection) {
    transactionsCollection = mongoClient.db(mongoDbName).collection(transactionsCollectionName);
    await transactionsCollection.createIndex({ occurredAt: -1 });
  }
  return transactionsCollection;
}

async function recordTransaction(doc) {
  try {
    const collection = await getTransactionsCollection();
    await collection.insertOne(doc);
  } catch (error) {
    console.error('Transaction log failed:', error.message);
  }
}

function sanitizeContent(content = '') {
  return content.replace(/[<>]/g, '');
}

function ensureAuthenticated(req, res, next) {
  if (!req.oidc || !req.oidc.isAuthenticated()) {
    return res.status(401).json({ error: 'Login required' });
  }
  return next();
}

app.post('/create-payment-intent', jsonParser, async (req, res) => {
  const { productId } = req.body || {};
  const product = PRODUCTS[productId];

  if (!product) {
    return res.status(400).json({ error: 'Invalid productId' });
  }

  try {
    const paymentIntent = await stripe.paymentIntents.create({
      amount: product.amount,
      currency: 'usd',
      automatic_payment_methods: { enabled: true },
      metadata: {
        productId,
        description: product.description
      }
    });

    return res.json({ clientSecret: paymentIntent.client_secret });
  } catch (error) {
    console.error('Error creating payment intent:', error.message);
    return res.status(500).json({ error: 'Unable to create payment intent' });
  }
});

app.get('/api/me', (req, res) => {
  const authenticated = Boolean(req.oidc && req.oidc.isAuthenticated());
  return res.json({
    authenticated,
    user: authenticated ? req.oidc.user : null
  });
});

app.get('/api/reading-room/messages', async (req, res) => {
  try {
    const collection = await getReadingRoomCollection();
    const docs = await collection
      .find({})
      .sort({ createdAt: -1 })
      .limit(MAX_MESSAGES)
      .toArray();
    const messages = docs
      .map((doc) => ({
        id: doc._id,
        content: doc.content,
        timestamp: doc.createdAt,
        user: doc.user
      }))
      .reverse();
    return res.json({ messages });
  } catch (error) {
    console.error('Reading Room fetch failed:', error.message);
    return res.status(500).json({ error: 'Unable to load messages' });
  }
});

app.post('/api/reading-room/messages', jsonParser, ensureAuthenticated, async (req, res) => {
  const { content } = req.body || {};
  const trimmed = (content || '').trim();
  if (!trimmed) {
    return res.status(400).json({ error: 'Message content required' });
  }

  const safeContent = sanitizeContent(trimmed).slice(0, 500);
  try {
    const collection = await getReadingRoomCollection();
    await collection.insertOne({
      content: safeContent,
      createdAt: new Date(),
      user: {
        name: req.oidc.user?.name || null,
        email: req.oidc.user?.email || null,
        picture: req.oidc.user?.picture || null
      },
      userId: req.oidc.user?.sub || null
    });
    return res.json({ success: true });
  } catch (error) {
    console.error('Reading Room post failed:', error.message);
    return res.status(500).json({ error: 'Unable to post message' });
  }
});

app.post(
  '/stripe-webhook',
  express.raw({ type: 'application/json' }),
  async (req, res) => {
    let event;
    try {
      event = stripe.webhooks.constructEvent(req.body, req.headers['stripe-signature'], STRIPE_WEBHOOK_SECRET);
    } catch (err) {
      console.error('Webhook signature verification failed.', err.message);
      return res.sendStatus(400);
    }

    const eventObject = event.data?.object || {};
    const occurredAt = eventObject.created ? new Date(eventObject.created * 1000) : new Date(event.created * 1000);
    const baseTransaction = {
      eventId: event.id,
      eventType: event.type,
      occurredAt
    };

    switch (event.type) {
      case 'payment_intent.succeeded': {
        const paymentIntent = eventObject;
        await recordTransaction({
          ...baseTransaction,
          transactionId: paymentIntent.id,
          amount: paymentIntent.amount_received ?? paymentIntent.amount ?? null,
          currency: paymentIntent.currency,
          category: paymentIntent.metadata?.category || paymentIntent.metadata?.productId || null
        });
        break;
      }
      case 'checkout.session.completed': {
        const session = eventObject;
        await recordTransaction({
          ...baseTransaction,
          transactionId: session.payment_intent || session.id,
          amount: session.amount_total ?? session.amount_subtotal ?? null,
          currency: session.currency,
          category: session.metadata?.category || session.metadata?.productId || null
        });
        break;
      }
      case 'charge.succeeded': {
        const charge = eventObject;
        await recordTransaction({
          ...baseTransaction,
          transactionId: charge.id,
          amount: charge.amount_captured ?? charge.amount ?? null,
          currency: charge.currency,
          category: charge.metadata?.category || charge.metadata?.productId || null
        });
        break;
      }
      default:
        break;
    }

    return res.sendStatus(200);
  }
);

const PORT = process.env.PORT || 4242;
app.listen(PORT, () => {
  console.log(`Stripe checkout server running on http://localhost:${PORT}`);
});
