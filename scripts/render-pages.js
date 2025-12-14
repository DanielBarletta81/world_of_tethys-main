const fs = require('fs');
const path = require('path');
const nunjucks = require('nunjucks');

const templatesDir = path.join(__dirname, '..', 'templates');
const pagesDir = path.join(templatesDir, 'pages');
const outputDir = path.join(__dirname, '..');

nunjucks.configure(templatesDir, {
  autoescape: false,
  noCache: true,
  trimBlocks: true,
  lstripBlocks: true
});

function renderPages() {
  if (!fs.existsSync(pagesDir)) {
    console.error('No templates/pages directory found. Nothing to render.');
    process.exit(1);
  }

  const pageFiles = fs
    .readdirSync(pagesDir, { withFileTypes: true })
    .filter((entry) => entry.isFile() && entry.name.endsWith('.njk'))
    .map((entry) => entry.name);

  if (pageFiles.length === 0) {
    console.warn('No .njk page templates found to render.');
    return;
  }

  pageFiles.forEach((file) => {
    const templatePath = path.join('pages', file);
    const outputFile = file.replace(/\.njk$/, '.html');
    const outputPath = path.join(outputDir, outputFile);

    const html = nunjucks.render(templatePath, {});
    fs.writeFileSync(outputPath, html);
    console.log(`Rendered ${outputFile}`);
  });
}

renderPages();
