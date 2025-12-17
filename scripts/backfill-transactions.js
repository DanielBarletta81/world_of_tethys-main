#!/usr/bin/env node
/**
 * Backfills historical Stripe payments into the MongoDB transactions collection.
 *
 * Usage:
 *   node scripts/backfill-transactions.js [--limit=50] [--status=succeeded]
 *
 * Requires STRIPE_SECRET_KEY, MONGODB_URI, MONGODB_DB, TRANSACTIONS_COLLECTION in env.
 */
const Stripe = require('stripe');
const { MongoClient, ServerApiVersion } = require('mongodb');
const path = require('path');
const dotenv = require('dotenv');

dotenv.config({ path: path.join(__dirname, '..', '.env') });

const STRIPE_SECRET_KEY = process.env.STRIPE_SECRET_KEY;
const MONGODB_URI = process.env.MONGODB_URI;
const MONGODB_DB = process.env.MONGODB_DB || 'tethys';
const TRANSACTIONS_COLLECTION = process.env.TRANSACTIONS_COLLECTION || 'transactions';

if (!STRIPE_SECRET_KEY) {
  console.error('Missing STRIPE_SECRET_KEY in environment.');
  process.exit(1);
}

if (!MONGODB_URI) {
  console.error('Missing MONGODB_URI in environment.');
  process.exit(1);
}

const stripe = new Stripe(STRIPE_SECRET_KEY, { apiVersion: '2023-10-16' });

const args = process.argv.slice(2);
const limitArg = args.find((arg) => arg.startsWith('--limit='));
const statusArg = args.find((arg) => arg.startsWith('--status='));
const limit = limitArg ? parseInt(limitArg.split('=')[1], 10) : 50;
const statusFilter = statusArg ? statusArg.split('=')[1] : 'succeeded';

async function fetchPaymentIntents() {
  const intents = [];
  const iterator = stripe.paymentIntents.list({
    limit,
    status: statusFilter
  }).autoPagingIterator();

  for await (const intent of iterator) {
    intents.push(intent);
    if (intents.length >= limit) break;
  }
  return intents;
}

function normalizeRecord(intent) {
  const amount = intent.amount_received ?? intent.amount ?? null;
  const occurredAt = intent.created ? new Date(intent.created * 1000) : new Date();
  const category = intent.metadata?.category || intent.metadata?.productId || null;

  return {
    eventId: `manual_backfill_${intent.id}`,
    eventType: 'manual_backfill',
    transactionId: intent.id,
    amount,
    currency: intent.currency,
    category,
    metadata: intent.metadata || {},
    occurredAt
  };
}

async function upsertTransactions(records) {
  const client = new MongoClient(MONGODB_URI, { serverApi: ServerApiVersion.v1 });
  await client.connect();
  const collection = client.db(MONGODB_DB).collection(TRANSACTIONS_COLLECTION);

  for (const record of records) {
    await collection.updateOne(
      { transactionId: record.transactionId },
      { $set: record },
      { upsert: true }
    );
  }

  await client.close();
}

async function main() {
  console.log(`Fetching up to ${limit} payment intents with status "${statusFilter}"...`);
  const intents = await fetchPaymentIntents();
  console.log(`Fetched ${intents.length} intents. Writing to Mongo...`);
  const records = intents.map(normalizeRecord);
  await upsertTransactions(records);
  console.log('Backfill complete. Records written:', records.length);
}

main().catch((err) => {
  console.error('Backfill failed:', err.message);
  process.exit(1);
});
