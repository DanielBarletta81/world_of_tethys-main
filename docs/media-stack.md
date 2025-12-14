# World of Tethys Media Stack

This note captures how the site now handles media delivery, previews, downloads, and the authenticated Reading Room experience. Use it as an internal reference and as a cheat sheet when you speak with infrastructure partners (CoreWeave, AWS SA, etc.).

## 1. High-level architecture

- **Static experience** — All marketing pages (index, Signals, Reading Room shell) are static HTML + Tailwind and deploy to an AWS S3 bucket (`PUBLIC_ASSET_BUCKET`). CloudFront/CDN can be layered on later without touching the build.
- **Media delivery** — Episode previews and paid downloads live in a dedicated media bucket (`MEDIA_BUCKET`). Preview audio streams directly from S3 (or optional CDN) while full .zip deliverables stay behind Stripe/SureCart flows.
- **Application services** — A small Express server (`server.js`) powers Stripe intents/webhooks, Auth0 login/logout, and Reading Room APIs. MongoDB stores chat messages for moderation.
- **Automation** — Node + Python scripts automate uploads (`scripts/upload-media.js`) and caption generation (`scripts/generate_captions.py`). These run locally on macOS (no cloud GPU bill required).

## 2. Media delivery + streaming flow

1. **Source material** — Master WAV/FLAC stored locally. Short MP3 preview exported for marketing; full episode compressed into a .zip (audio + liner notes).
2. **Captioning** — `scripts/generate_captions.py` can hit the OpenAI Whisper API or local whisper.cpp binaries. Output `.srt`/`.vtt` goes into `./captions`.
3. **Upload** — Run `npm run media:upload ./audio/ep01-preview.mp3 -- --key=signals/ep01/preview.mp3 --public`. The helper:
   - Detects content type.
   - Pushes to `MEDIA_BUCKET`.
   - Prints either a public URL (if `--public`) or a temporary signed URL you can hand to Stripe automations.
4. **Link hydration** — Update `public/tethys-links.js` with the preview/download URLs. The Signals page wires buttons + `<audio>` elements via the `[data-link]` and `[data-audio-link]` attributes, so the UI updates automatically.
5. **Delivery** — Visitors stream the preview straight from the bucket. Buyers receive the full download link via Stripe/SureCart (or by gating behind authenticated Reading Room posts).

Because there is no CDN domain yet, URLs resolve to `https://<bucket>.s3.<region>.amazonaws.com/...`. Once a CDN is ready, set `MEDIA_CDN_DOMAIN` and all helper scripts will emit the branded domain instead.

## 3. Reading Room (Auth0 + MongoDB)

- **OAuth2** — Auth0’s `@auth0/express-openid-connect` middleware adds `/login` and `/logout`. Sessions use secure cookies; `app.set('trust proxy', 1)` is enabled for future CDN/Load balancer support.
- **API surface**:
  - `GET /api/me` → session state for the front-end (used to toggle CTA buttons, copy).
  - `GET /api/reading-room/messages` → latest messages. Anonymous users receive `401`.
  - `POST /api/reading-room/messages` → authenticated posts only; payload sanitized and truncated to 500 chars before storage.
- **Data** — MongoDB collection (`READING_ROOM_COLLECTION`, defaults to `reading-room`) keeps the chat log. A TTL/index strategy can be added later for auto-pruning.
- **Front-end** — `reading-room.html` + `public/reading-room.js` poll every 15 seconds, offer optimistic UI feedback, and grey out the form until a user logs in.

## 4. CI/CD + deployments

- GitHub Actions workflow (`.github/workflows/deploy.yml`) runs on pushes to `main`.
- Steps: checkout → install → build Tailwind → sync theme assets → stage HTML into `build/static/` → `aws s3 sync` both `/public` and the staged HTML into the `PUBLIC_ASSET_BUCKET`.
- Optional `CLOUDFRONT_DISTRIBUTION_ID` invalidates caches when set.
- Nothing is taken offline during deploys because S3 swaps objects atomically.

## 5. CoreWeave talking points

Use the bullets below when explaining the project to CoreWeave or similar infra teams:

- **Media orchestration** — Previews stream from object storage while full-resolution downloads stay in the same bucket, ready to be signed and distributed post-purchase. The upload script plus metadata file keep everything consistent.
- **Rendering & streaming alignment** — Mention that every dispatch ships with captions (via Whisper automation) and that you plan to offload heavier render jobs (video teasers, animated shorts) to GPU-backed workers—perfect for CoreWeave’s media/rendering workloads.
- **Training/inference readiness** — Highlight the existing Whisper pipeline plus future plans to fine-tune narration classifiers or moderate Reading Room chats with lightweight models. Shows you understand inference pipelines, not just static hosting.
- **Operational discipline** — CI/CD, Auth0, MongoDB, and Stripe webhooks already run in concert. Adding CoreWeave nodes for burst rendering or CDN-style caching is the next logical layer, not a ground-up rebuild.

## 6. Next enhancements (optional roadmap)

- Feed the S3 upload script into a manifest JSON so marketing pages auto-ingest new episodes without manual edits.
- Add rate limiting + content moderation hooks (Perspective API or custom classifiers) for Reading Room safety.
- Wire GitHub Actions to also deploy `server.js` to Render/Railway, keeping API + static site deploys in sync.
- Layer CloudFront or a CoreWeave-powered CDN in front of `MEDIA_BUCKET` once traffic grows.

Keep this document updated whenever the stack evolves so you always have a concise systems story ready for partners or interviewers.

