# World of Tethys · Tailwind prototype

This folder holds the design prototype for the World of Tethys pages (books, characters, single character file) and a minimal Tailwind toolchain so you can keep iterating locally before wiring everything into WordPress.

## Prerequisites


- Node.js 18+
- npm (bundled with Node)

Install once:

```bash
npm install
```

## Available scripts

```bash
npm run dev          # watches src/styles.css and rebuilds on save
npm run build        # outputs a production-ready ./public/tethys.css
npm run render:pages # renders templates/pages/*.njk into *.html at the repo root
npm run media:upload # helper for pushing previews/downloads to S3
npm run sync:theme   # copies the compiled CSS/assets into the WP theme folder
npm start            # launches the Express API (Stripe intents + Reading Room)
```

The HTML files already point to `./public/tethys.css`. When you run `npm run dev`, keep the process running while you edit the HTML (or when you port the markup into WordPress templates or blocks).

## Page template workflow

- Each top-level page now lives in `templates/pages/*.njk`. These Nunjucks files can include shared partials such as the nav (`templates/partials/nav.njk`).
- Whenever you change a template, run `npm run render:pages` to regenerate the static `.html` files in the project root.
- Commit both the template and rendered HTML when you make changes so teammates (or WordPress) can keep using the flat files without running the build.

## WordPress usage

1. Copy the compiled CSS file into your theme (for example `wp-content/themes/tethys/public/tethys.css`).
2. Enqueue it in `functions.php`:

```php
function tethys_enqueue_assets() {
    $css_path = get_template_directory() . '/public/tethys.css';
    wp_enqueue_style(
        'tethys-tailwind',
        get_template_directory_uri() . '/public/tethys.css',
        [],
        file_exists( $css_path ) ? filemtime( $css_path ) : null
    );
}
add_action( 'wp_enqueue_scripts', 'tethys_enqueue_assets' );
```

3. Drop the HTML from `characters.html`, `books.html`, or `index.html` into the appropriate template (page, block pattern, or ACF flexible block). The Tailwind classes and custom tokens (like `bg-abyss`, `text-lava-400`, `font-display`) are now defined in `tailwind.config.js`, so any markup that uses those classes will render correctly once the stylesheet is enqueued.

## Customizing the design tokens

- `tailwind.config.js` is where the bespoke colors (`abyss`, `lava`), radial background, and font stacks live. Adjust or add to `theme.extend` as needed.
- `src/styles.css` pulls in the Google Fonts (`Cinzel` and `Space Grotesk`) and defines any reusable utility/ component classes such as `.card-shell` and `.eyebrow`.

Whenever you change tokens or the CSS, re-run `npm run build` before deploying to WordPress.

## Stripe checkout preview

- `signals-checkout.html` is a standalone prototype of a Stripe Payment Element page for Signals from Tethys.
- Drop it into WordPress (or host it statically) and update the inline script with your publishable key.
- Implement a corresponding backend endpoint at `/create-payment-intent` (Node/Express, Netlify function, etc.) that:
  1. Accepts `productId` (e.g., `signals_ep01`, `signals_bundle`).
  2. Looks up the right Stripe Price ID for that product.
  3. Calls `stripe.paymentIntents.create({ amount, currency, metadata, automatic_payment_methods: { enabled: true } })`.
  4. Returns `{ clientSecret }` to the browser.
- The front-end script initializes the Payment Element, confirms the payment, and redirects back to `signals-from-thethys.html` when complete. Use the success webhook or `paymentIntent.status` to email download links or grant access.

### Local Express server

- `server.js` is a minimal Express API that exposes `/create-payment-intent` and `/stripe-webhook`.
- Env vars:
  - `STRIPE_SECRET_KEY` – your secret key.
  - `STRIPE_WEBHOOK_SECRET` – signing secret for the webhook endpoint.
  - `SIGNALS_EP01_AMOUNT` / `SIGNALS_BUNDLE_AMOUNT` – optional overrides (cents, defaults 99 and 249).
  - `TRANSACTIONS_COLLECTION` – Mongo collection used to log payment events (defaults to `transactions`).
- Run `npm install` (to pull `express` + `stripe`) and start it via `npm start`.
- Deploy the same handler to your host of choice (Render, Railway, Netlify functions) and update `CREATE_INTENT_ENDPOINT` in `signals-checkout.html` if you move it off the root domain.
- Successful Stripe webhooks (`payment_intent.succeeded`, `checkout.session.completed`, `charge.succeeded`) are automatically recorded in MongoDB (`TRANSACTIONS_COLLECTION`) with the event date, amount, currency, category (from metadata), and transaction ID so you have a clean ledger.

### Getting your Stripe credentials

1. Log into the [Stripe Dashboard](https://dashboard.stripe.com) → Developers → API keys. Copy the **Secret key** (starts with `sk_test_...` in test mode) and drop it into `STRIPE_SECRET_KEY`.
2. For local webhooks, install the Stripe CLI and run `stripe listen --forward-to localhost:3000/stripe-webhook`. The CLI prints a `whsec_...` token—set that as `STRIPE_WEBHOOK_SECRET`.
3. If you also render the front-end checkout, grab the **Publishable key** (`pk_test_...`) for client-side scripts.
4. When you’re ready for production, switch to the live mode dashboard and rotate both keys plus the webhook secret.

### Membership tiers (consistent naming)

- **Ember Access ($2/mo)** – entry tier for early Signals access + AMAs. Map to Stripe recurring product, Substack paid tier, and Patreon tier of same name.
- **Ashwing Vault ($8/mo)** – core tier with merch discounts and loyalty drops. Keep pricing aligned across platforms (Stripe, Substack, Patreon at `https://www.patreon.com/c/WorldofTethysDCBarletta`).
- **Watcher Council ($20+/mo)** – elite/supporter tier with limited seats, quarterly briefings, and lore votes.

Use these names when creating Stripe Products, Substack tiers, and Patreon memberships so your perks stay synchronized no matter where supporters subscribe.

## Media delivery + streaming previews (AWS S3)

- Configure the following env vars (see `.env.example`): `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_REGION`, `MEDIA_BUCKET`, and optional `MEDIA_CDN_DOMAIN`. No CDN domain yet? Leave `MEDIA_CDN_DOMAIN` empty and links will default to `https://<bucket>.s3.<region>.amazonaws.com`.
- Upload previews or full downloads with `npm run media:upload ./audio/ep01-preview.mp3 -- --key=signals/ep01/preview.mp3 --public`. The helper prints the final URL (public or temporary signed URL).
- Paste the returned URLs into `public/tethys-links.js` keys such as `previewSignalsEp01` or `downloadSignalsEp01`. The Signals page and CTA buttons automatically hydrate any `[data-link]` or `[data-audio-link]` elements with those endpoints.
- Keep raw WAV/FLAC masters locally and only push ACX-ready MP3/Zip deliverables to S3. That keeps bandwidth costs down while still letting you stream a 60–90 second preview and host the paid download in the bucket.
- Track canon URLs in `data/media-manifest.json` and regenerate the link maps by running `node scripts/sync-media-links.js`. This updates both the site (`public/tethys-links.js`) and the WordPress theme copy without manual edits.

## Reading Room authentication (Auth0 + MongoDB)

- The secure chat lives in `reading-room.html` + `public/reading-room.js`. It expects `/api/me` for session status and `/api/reading-room/messages` for CRUD, both handled by `server.js`.
- Set up an Auth0 Regular Web App, add `AUTH0_DOMAIN`, `AUTH0_CLIENT_ID`, `AUTH0_CLIENT_SECRET`, `AUTH0_SECRET`, and `AUTH0_BASE_URL` to your `.env`. The Express app wires `@auth0/express-openid-connect` with `authRequired: false` so only Reading Room posts are gated.
- Point `MONGODB_URI` (Atlas or local), `MONGODB_DB`, and `READING_ROOM_COLLECTION` at your database. Messages are sanitized, capped (`READING_ROOM_MAX_MESSAGES`), and stored with timestamps + user metadata for light moderation.
- Unauthenticated visitors see the CTA/login links but cannot fetch or post messages. Authenticated users post via JSON fetches and get auto-refreshed threads every 15 seconds.

## Whisper caption automation (OpenAI API or local whisper.cpp)

- `scripts/generate_captions.py` accepts one or many audio/video files. By default it calls the OpenAI Whisper API (requires `OPENAI_API_KEY` and incurs usage costs).
- To avoid API spend, download `whisper.cpp`, a GGUF model (e.g., `ggml-base.en.bin`), and run:

  ```bash
  python scripts/generate_captions.py ./audio/ep01.mp3 \
    --format srt \
    --whisper-bin ~/Tools/whisper.cpp/main \
    --whisper-model ~/Models/ggml-base.en.bin
  ```

  This runs entirely on your Mac CPU/GPU and writes `.srt`/`.vtt` files into `./captions`.
- Feed those caption files into TikTok/YouTube uploads or mux them into the preview video renders to keep accessibility tight without hand-typing transcripts.

## Media upload + download workflow

1. Bounce/export the master episode into `audio/`.
2. Run Whisper captions (`scripts/generate_captions.py`) to get `.srt` inside `captions/`.
3. Encode a short preview MP3, then push preview + full ZIP to S3 via `npm run media:upload path/to/file -- --key=signals/ep01/<preview-or-zip> --public`.
4. Paste the new URLs into `public/tethys-links.js`. The `signals-from-tethys.html` preview player (`data-audio-link="previewSignalsEp01"`) and download CTAs update immediately.

## Mini games playground

- Lightweight lore-friendly games now live in `games/`. Start with `signal_ping.py`, a CLI guessing game you can run via `python games/signal_ping.py`.
- Add new prototypes as single-file scripts and document them in `games/README.md`. Keep dependencies minimal so writers can test ideas without setup overhead.
- When you eventually publish them on the site, wire the download/link cards to these scripts or to web-based ports (Pygame, Pyodide, etc.).

### Restoring heavy media locally

All WAV/MP3 masters now live exclusively in S3 so the repo stays below GitHub's
100 MB cap. To hydrate your workstation:

```bash
pip install boto3                # first time only
export $(cat .env | xargs)       # or use direnv/foreman
python scripts/download_media.py --all
```

The script pulls:

- `public/audio` → `media/public/audio`
- `tethys-theme/audio_extended` → `media/tethys-theme/audio_extended`
- `audio/` REAPER sources → `media/audio`
- Theme ZIP exports → `archives/…`

You can limit downloads (e.g., `--groups site-audio theme-audio`) if you only
need part of the tree.

## CI/CD pipeline (GitHub Actions → S3)

- `.github/workflows/deploy.yml` installs dependencies, builds Tailwind, syncs `/public`, stages the root `.html` files into `build/static/`, and syncs that folder into the S3 bucket defined by `PUBLIC_ASSET_BUCKET`.
- Provide `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_REGION`, `PUBLIC_ASSET_BUCKET`, and optionally `CLOUDFRONT_DISTRIBUTION_ID` as repository secrets.
- Because there is no CDN custom domain yet, visitors can hit the S3 static website endpoint or you can hang a CloudFront distribution in front later without changing the workflow.

## Pitch prep (CoreWeave-friendly language)

- Media delivery + orchestration: emphasize the S3-backed preview/download system, the automation scripts (`media:upload`, Whisper captions), and how CI keeps the static site in sync without downtime.
- Rendering/streaming: highlight that previews are lightweight streaming MP3s while full, lossless downloads stay in-object storage (cheap, durable). Mention future hooks to CloudFront or CoreWeave CDN nodes for bursty launches.
- Training/inference: connect the Whisper automation (local + API) to future plans: auto-caption every dispatch, pre-compute embeddings for Reading Room moderation, etc.
- The new Reading Room shows familiarity with OAuth2, session security, and respectful community tooling—all relevant when talking to CoreWeave about secure media workflows.

### Substack – Pteroswifts from Tethys

Reference when you set up or refresh the newsletter:

- **Publication name:** `Pteroswifts from Tethys`
- **URL:** aim for `dcbarletta.substack.com` (or similar)
- **Tagline:** reuse the “flying dispatches” copy from `index.html`
- **About section (paste):**
  ```
  Welcome to Pteroswifts from Tethys — flying dispatches from a world of sky cities, prehistoric seas, and dangerous bonds between humans and their beasts.

  I’m D. C. Barletta, author and narrator of the World of Tethys saga. I blend evolution, ecology, and character-driven fantasy into a series where ecosystems fight back, roots remember where people fall, and exile is rarely the end of a story.

  Expect updates on Signals shorts/audiobooks, experimental imagery + field cards, lore + science notes, and occasional studio logs. It’s free to subscribe. For deeper access, early audio, and extra lore, join the World of Tethys Patreon (linked in most issues).
  ```
- **Pinned welcome post:** “Welcome to Pteroswifts from Tethys” — recap expectations, link to Signals stories + Patreon.
- **Issue starter plan:**
  1. *Issue #1 – The Ledge, the Fledgling, and a New Signal* (Ravel Tracks Stryker + Window & Fledgling recap, imagery, studio log).
  2. *Issue #2 – First Whisper in the Younger Wood* (tease Ravel’s story, root imagery, field notes).
  3. *Issue #3 – Between Sky and Sea* (Jairo/Kel/Herc tease, blockade imagery, flight plan).

Use those headings as Substack templates so each issue feels modular: **Opening Signal**, **Story Dispatch**, **Experimental Imagery**, **Field Notes**, **Studio Log**, **Flight Plan**.
