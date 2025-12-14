const TETHYS_LINKS = {
  patreon: 'https://www.patreon.com/c/WorldofTethysDCBarletta',
  substack: 'https://dcbarletta.substack.com',
  stripeMembership: 'https://buy.stripe.com/fZu9AU4Xo2Yu1610z0',
  stripeSignals: 'signals-checkout.html',
  stripeSignalsEp01: 'https://buy.stripe.com/dRm8wQgG6fLg2a50z0gMw01',
  watchersCrescentStripe: 'https://buy.stripe.com/cNi7sM75w56C6ql2H8gMw02',
  strykersSquadStripe: 'https://buy.stripe.com/fZu9AU4Xo2Yu1610z0gMw00',
  tethysianGodsStripe: 'https://buy.stripe.com/00wcN69dEcz4aGBgxYgMw03',
  // Replace with your live SureCart storefront URL when ready.
  surecartSignals: 'https://your-surecart-store.example/signals-dispatch',
  amazonAuthor: 'https://www.amazon.com/author/dcbarletta',
  amazonSignals01: 'https://www.amazon.com/dp/B0G5TWV2GH',
  amazonSkyCity: 'https://www.amazon.com/dp/B0G572X42L',
  amazonLore: 'https://www.amazon.com/dp/REPLACE_LORE_ASIN',
  amazonWindow: 'https://www.amazon.com/dp/REPLACE_WINDOW_KINDLE',
  amazonFirst: 'https://www.amazon.com/dp/REPLACE_FIRST_KINDLE',
  audibleAuthor: 'https://www.audible.com/author/dcbarletta',
  audibleSignals01: 'https://www.audible.com/pd/B0G5TWV2GH',
  audibleWindow: 'https://www.audible.com/pd/REPLACE_WINDOW_AUDIO',
  audibleFirst: 'https://www.audible.com/pd/REPLACE_FIRST_AUDIO',
  youtube: 'https://www.youtube.com/@worldoftethysauthor',
  tiktok: 'https://www.tiktok.com/@worldoftethys_writer',
  instagram: 'https://www.instagram.com/worldoftethys'
};

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-link]').forEach((element) => {
    const key = element.dataset.link;
    const url = TETHYS_LINKS[key];
    if (!url) return;

    element.setAttribute('href', url);

    const newTabPreference = element.dataset.newTab;
    const openInNewTab = newTabPreference === 'true' || (newTabPreference !== 'false' && /^https?:/i.test(url));
    if (openInNewTab) {
      element.setAttribute('target', '_blank');
      element.setAttribute('rel', 'noopener noreferrer');
    }
  });
});
