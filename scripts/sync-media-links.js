#!/usr/bin/env node
/**
 * Syncs media URLs from data/media-manifest.json into the link maps used by the site and WP theme.
 * Run: node scripts/sync-media-links.js
 */
const fs = require('fs');
const path = require('path');

const MANIFEST_PATH = path.join(__dirname, '..', 'data', 'media-manifest.json');
const LINK_FILES = [
  path.join(__dirname, '..', 'public', 'tethys-links.js'),
  path.join(__dirname, '..', 'tethys-theme', 'Tethys-theme_3', 'assets', 'js', 'tethys-links.js')
];

function loadManifest() {
  const raw = fs.readFileSync(MANIFEST_PATH, 'utf8');
  return JSON.parse(raw);
}

function buildReplacementMap(manifest) {
  const replacements = {};
  const signals = manifest.signals || {};

  Object.entries(signals).forEach(([episodeKey, assets]) => {
    const suffix = episodeKey.charAt(0).toUpperCase() + episodeKey.slice(1);
    if (assets.preview) {
      replacements[`previewSignals${suffix}`] = assets.preview;
    }
    if (assets.download) {
      replacements[`downloadSignals${suffix}`] = assets.download;
    }
  });

  return replacements;
}

function updateLinkFile(filePath, replacements) {
  let content = fs.readFileSync(filePath, 'utf8');
  let mutated = false;

  Object.entries(replacements).forEach(([key, value]) => {
    const pattern = new RegExp(`(${key}:\\s*')([^']*)(')`);
    if (pattern.test(content)) {
      content = content.replace(pattern, `$1${value}$3`);
      mutated = true;
    }
  });

  if (mutated) {
    fs.writeFileSync(filePath, content, 'utf8');
    console.log(`Updated ${filePath}`);
  } else {
    console.log(`No matching keys found in ${filePath}`);
  }
}

function main() {
  const manifest = loadManifest();
  const replacements = buildReplacementMap(manifest);

  if (!Object.keys(replacements).length) {
    console.log('No replacements to apply. Manifest might be empty.');
    return;
  }

  LINK_FILES.forEach((file) => updateLinkFile(file, replacements));
}

main();
