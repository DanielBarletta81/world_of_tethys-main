#!/usr/bin/env node
/*
 * Uploads a media file to S3 for previews/download delivery.
 * Usage:
 *   node scripts/upload-media.js ./audio/ep01-preview.mp3 --key=signals/ep01/preview.mp3 --public
 */
const fs = require('fs/promises');
const path = require('path');
const { S3Client, PutObjectCommand, GetObjectCommand } = require('@aws-sdk/client-s3');
const { getSignedUrl } = require('@aws-sdk/s3-request-presigner');
const mime = require('mime');
require('dotenv').config();

const REGION = process.env.AWS_REGION;
const BUCKET = process.env.MEDIA_BUCKET;
const CDN_DOMAIN = process.env.MEDIA_CDN_DOMAIN;

if (!REGION || !BUCKET) {
  console.error('Missing AWS_REGION or MEDIA_BUCKET env vars.');
  process.exit(1);
}

const args = process.argv.slice(2);
if (!args[0]) {
  console.error('Usage: node scripts/upload-media.js <filePath> [--key=key/in/bucket] [--public]');
  process.exit(1);
}

const filePath = path.resolve(args[0]);
const keyArg = args.find((arg) => arg.startsWith('--key='));
const objectKey = keyArg ? keyArg.split('=')[1] : path.basename(filePath);
const makePublic = args.includes('--public');

async function main() {
  const fileBuffer = await fs.readFile(filePath);
  const contentType = mime.getType(filePath) || 'application/octet-stream';

  const client = new S3Client({ region: REGION });
  const putCommand = new PutObjectCommand({
    Bucket: BUCKET,
    Key: objectKey,
    Body: fileBuffer,
    ContentType: contentType,
    ACL: makePublic ? 'public-read' : undefined
  });

  await client.send(putCommand);
  console.log(`Uploaded ${filePath} -> s3://${BUCKET}/${objectKey}`);

  if (makePublic) {
    const base = CDN_DOMAIN ? `https://${CDN_DOMAIN}` : `https://${BUCKET}.s3.${REGION}.amazonaws.com`;
    console.log('Public URL:', `${base}/${objectKey}`);
    return;
  }

  const signedUrl = await getSignedUrl(
    client,
    new GetObjectCommand({
      Bucket: BUCKET,
      Key: objectKey
    }),
    { expiresIn: 3600 }
  );
  console.log('Temporary signed URL (1h):', signedUrl);
}

main().catch((err) => {
  console.error('Upload failed:', err.message);
  process.exit(1);
});
