/* eslint-disable no-console */
require('dotenv').config();
const express = require('express');
const Stripe = require('stripe');
const { auth } = require('@auth0/express-openid-connect');
const { MongoClient, ServerApiVersion } = require('mongodb');

const app = express();

const STRIPE_SECRET_KEY = process.env.STRIPE_SECRET_KEY || 'sk_test_REPLACE_WITH_YOUR_KEY';
const STRIPE_WEBHOOK_SECRET = process.env.STRIPE_WEBHOOK_SECRET || 'whsec_REPLACE_ME';
const stripe = new Stripe(STRIPE_SECRET_KEY, {
  apiVersion: '2023-10-16'
});

const AIRTABLE_API_KEY = process.env.AIRTABLE_API_KEY || '';
const AIRTABLE_BASE_ID = process.env.AIRTABLE_BASE_ID || '';
const AIRTABLE_SUPPORTERS_TABLE = process.env.AIRTABLE_SUPPORTERS_TABLE || 'Supporters';

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
let mongoClient;
let readingRoomCollection;

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

function sanitizeContent(content = '') {
  return content.replace(/[<>]/g, '');
}

function ensureAuthenticated(req, res, next) {
  if (!req.oidc || !req.oidc.isAuthenticated()) {
    return res.status(401).json({ error: 'Login required' });
  }
  return next();
}

async function airtableRequest(path, options = {}) {
  if (!AIRTABLE_API_KEY || !AIRTABLE_BASE_ID) {
    throw new Error('Airtable credentials missing');
  }
  const url = `https://api.airtable.com/v0/${AIRTABLE_BASE_ID}/${path}`;
  const response = await fetch(url, {
    ...options,
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${AIRTABLE_API_KEY}`,
      ...(options.headers || {})
    }
  });
  if (!response.ok) {
    const text = await response.text();
    throw new Error(`Airtable error: ${response.status} ${text}`);
  }
  return response.json();
}

async function findSupporterByEmail(email) {
  if (!email) return null;
  const formula = encodeURIComponent(`LOWER({Email}) = LOWER("${email}")`);
  const data = await airtableRequest(`${AIRTABLE_SUPPORTERS_TABLE}?filterByFormula=${formula}&maxRecords=1`);
  return data.records?.[0] || null;
}

async function upsertSupporterRecord({ email, platform, tier, joined }) {
  if (!email) return;
  const existing = await findSupporterByEmail(email);
  const fields = {
    Email: email,
    Platform: platform,
    Tier: tier,
    Joined: joined ? new Date(joined).toISOString() : undefined
  };

  const sanitizedFields = Object.fromEntries(
    Object.entries(fields).filter(([_, value]) => Boolean(value))
  );

  if (existing) {
    await airtableRequest(`${AIRTABLE_SUPPORTERS_TABLE}/${existing.id}`, {
      method: 'PATCH',
      body: JSON.stringify({ fields: sanitizedFields })
    });
  } else {
    await airtableRequest(AIRTABLE_SUPPORTERS_TABLE, {
      method: 'POST',
      body: JSON.stringify({ fields: sanitizedFields })
    });
  }
}

async function getCustomerEmail(subscription) {
  if (subscription.customer_email) return subscription.customer_email;
  if (subscription.customer && typeof subscription.customer === 'string') {
    const customer = await stripe.customers.retrieve(subscription.customer);
    return customer.email;
  }
  return null;
}

function deriveTierFromSubscription(subscription) {
  return (
    subscription.metadata?.tier ||
    subscription.items?.data?.[0]?.price?.metadata?.tier ||
    subscription.items?.data?.[0]?.price?.nickname ||
    'ember'
  );
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

app.post('/supporter-sync', jsonParser, async (req, res) => {
  const { email, platform = 'manual', tier = 'ember', joined = Date.now() } = req.body || {};

  if (!email) {
    return res.status(400).json({ error: 'Email required' });
  }

  try {
    await upsertSupporterRecord({ email, platform, tier, joined });
    return res.json({ success: true });
  } catch (error) {
    console.error('Error syncing supporter:', error.message);
    return res.status(500).json({ error: 'Unable to sync supporter' });
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

    try {
      switch (event.type) {
        case 'customer.subscription.created':
        case 'customer.subscription.updated': {
          const subscription = event.data.object;
          const tier = deriveTierFromSubscription(subscription);
          const email = await getCustomerEmail(subscription);
          await upsertSupporterRecord({
            email,
            platform: 'stripe',
            tier,
            joined: subscription.start_date * 1000
          });
          break;
        }
        default:
          break;
      }
    } catch (error) {
      console.error('Error handling webhook:', error.message);
      return res.sendStatus(500);
    }

    return res.sendStatus(200);
  }
);

const PORT = process.env.PORT || 4242;
app.listen(PORT, () => {
  console.log(`Stripe checkout server running on http://localhost:${PORT}`);
});
