const fs = require('fs/promises');
const path = require('path');

const rootDir = path.join(__dirname, '..');
const publicDir = path.join(rootDir, 'public');
const themeDir = path.join(rootDir, 'tethys-theme', 'Tethys-theme_3');
const assetsDir = path.join(themeDir, 'assets');

const fileCopies = [
  { from: 'tethys.css', to: path.join('css', 'tethys.css') },
  { from: 'tethys-effects.css', to: path.join('css', 'tethys-effects.css') },
  { from: 'tethys-links.js', to: path.join('js', 'tethys-links.js') },
  { from: 'tethys-effects.js', to: path.join('js', 'tethys-effects.js') },
  { from: 'comments.js', to: path.join('js', 'comments.js') }
];

const dirCopies = ['audio', 'images', 'video'];

async function ensureDir(dir) {
  await fs.mkdir(dir, { recursive: true });
}

async function copyFile(srcName, destName) {
  const src = path.join(publicDir, srcName);
  const dest = path.join(assetsDir, destName);
  await ensureDir(path.dirname(dest));
  await fs.copyFile(src, dest);
  console.log(`Copied ${srcName} -> ${destName}`);
}

async function copyDir(srcName) {
  const src = path.join(publicDir, srcName);
  try {
    const stat = await fs.stat(src);
    if (!stat.isDirectory()) {
      return;
    }
  } catch {
    return;
  }
  const dest = path.join(assetsDir, srcName);
  await fs.rm(dest, { recursive: true, force: true });
  await fs.cp(src, dest, { recursive: true });
  console.log(`Synced directory ${srcName}`);
}

async function main() {
  await ensureDir(assetsDir);

  for (const file of fileCopies) {
    try {
      await copyFile(file.from, file.to);
    } catch (err) {
      if (err.code === 'ENOENT') {
        console.warn(`Skipping missing file ${file.from}`);
      } else {
        throw err;
      }
    }
  }

  for (const dir of dirCopies) {
    await copyDir(dir);
  }

  console.log('Theme assets synced.');
}

main().catch((err) => {
  console.error(err);
  process.exit(1);
});
