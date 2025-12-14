<?php
/**
 * Front page template mirroring the static home experience.
 */

get_header();

$theme_dir  = get_template_directory();
$theme_uri  = get_template_directory_uri();
$mp4_path   = $theme_dir . '/assets/video/tethys-trailer.mp4';
$mov_path   = $theme_dir . '/assets/video/tethys_trlr.mov';
$video_src  = '';
$video_type = 'video/mp4';

if ( file_exists( $mp4_path ) ) {
    $video_src = $theme_uri . '/assets/video/tethys-trailer.mp4';
} elseif ( file_exists( $mov_path ) ) {
    $video_src  = $theme_uri . '/assets/video/tethys_trlr.mov';
    $video_type = 'video/quicktime';
}

$poster_uri = file_exists( $theme_dir . '/assets/images/volcano-bg.png' )
    ? $theme_uri . '/assets/images/volcano-bg.png'
    : '';
$audio_uri  = file_exists( $theme_dir . '/assets/audio/wot-logo.mp3' )
    ? $theme_uri . '/assets/audio/wot-logo.mp3'
    : '';
$has_video  = ! empty( $video_src );
?>

<div id="wot-intro" class="intro-overlay" aria-hidden="true">
    <div class="intro-overlay__glow">
        <div class="intro-overlay__logo">
            <span class="intro-overlay__letters">W · O · T</span>
            <p class="intro-overlay__tagline"><?php esc_html_e( 'Audio Signal Linking', 'tethys' ); ?></p>
        </div>
    </div>
    <button type="button" class="intro-overlay__skip" data-skip-intro><?php esc_html_e( 'Skip', 'tethys' ); ?></button>
    <?php if ( $audio_uri ) : ?>
        <audio id="wot-intro-audio" src="<?php echo esc_url( $audio_uri ); ?>" preload="auto"></audio>
    <?php endif; ?>
</div>

<div class="min-h-screen bg-abyss bg-tethys-radial text-slate-100">
    <div class="bg-volcano hero-video-wrapper">
        <?php if ( $has_video ) : ?>
            <div class="hero-video" aria-hidden="true">
                <video class="hero-video__media" autoplay muted loop playsinline<?php echo $poster_uri ? ' poster="' . esc_url( $poster_uri ) . '"' : ''; ?>>
                    <source src="<?php echo esc_url( $video_src ); ?>" type="<?php echo esc_attr( $video_type ); ?>">
                </video>
                <div class="hero-video__scrim"></div>
            </div>
        <?php elseif ( $poster_uri ) : ?>
            <div class="hero-video hero-video--placeholder" aria-hidden="true" style="background-image: url('<?php echo esc_url( $poster_uri ); ?>');"></div>
        <?php endif; ?>

        <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
            <header class="hero-shell">
                <div class="grid gap-8 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,1.6fr)]">
                    <aside class="backlit-panel space-y-5 border border-slate-800/70 bg-slate-950/70">
                        <p class="section-label"><?php esc_html_e( 'Field dossier', 'tethys' ); ?></p>
                        <p class="text-sm text-slate-300"><?php esc_html_e( 'World of Tethys · Story lab', 'tethys' ); ?></p>
                        <dl class="space-y-3 text-xs text-slate-400">
                            <div class="flex justify-between gap-3">
                                <dt><?php esc_html_e( 'Status', 'tethys' ); ?></dt>
                                <dd class="text-slate-100"><?php esc_html_e( 'Signals live · Book 1 in polish', 'tethys' ); ?></dd>
                            </div>
                            <div class="flex justify-between gap-3">
                                <dt><?php esc_html_e( 'Focus', 'tethys' ); ?></dt>
                                <dd class="text-slate-100"><?php esc_html_e( 'Science-fantasy epics', 'tethys' ); ?></dd>
                            </div>
                            <div class="flex justify-between gap-3">
                                <dt><?php esc_html_e( 'Format', 'tethys' ); ?></dt>
                                <dd class="text-slate-100"><?php esc_html_e( 'Novels · Signals audio · Lore drops', 'tethys' ); ?></dd>
                            </div>
                            <div class="flex justify-between gap-3">
                                <dt><?php esc_html_e( 'Current build', 'tethys' ); ?></dt>
                                <dd class="text-slate-100"><?php esc_html_e( 'Sky City edits · Dispatch releases', 'tethys' ); ?></dd>
                            </div>
                        </dl>
                    </aside>

                    <div class="space-y-5">
                        <div class="flex flex-wrap gap-3 text-[11px] uppercase tracking-[0.24em] text-slate-400">
                            <span class="stat-chip"><?php esc_html_e( 'Signals active', 'tethys' ); ?></span>
                            <span class="stat-chip stat-chip--emerald"><?php esc_html_e( 'Loyalty sync live', 'tethys' ); ?></span>
                        </div>
                        <div class="space-y-3">
                            <p class="eyebrow text-lava-200"><?php esc_html_e( 'World of Tethys', 'tethys' ); ?></p>
                            <h1 class="font-display text-4xl font-semibold text-slate-50 sm:text-5xl">
                                <?php esc_html_e( 'Science fantasy where ecosystems fight back.', 'tethys' ); ?>
                            </h1>
                            <p class="max-w-2xl text-sm text-slate-300">
                                <?php esc_html_e( 'Sky cities, prehistoric seas, and dangerous bonds between humans and their beasts—told in novels, Signals dispatches, and narrated shorts engineered for ACX. Every episode mixes field science, ecology, and character-first stakes.', 'tethys' ); ?>
                            </p>
                        </div>
                        <ul class="grid gap-3 text-sm text-slate-300 sm:grid-cols-2">
                            <li>• <?php esc_html_e( 'Signals shorts average 18–22 minutes with atmosphere-rich mastering.', 'tethys' ); ?></li>
                            <li>• <?php esc_html_e( 'Book One (Sky City) is in polish; Kindle singles ship meanwhile.', 'tethys' ); ?></li>
                            <li>• <?php esc_html_e( 'Patreon unlocks vault lore, engineering notes, and dispatch polls.', 'tethys' ); ?></li>
                            <li>• <?php esc_html_e( 'Substack drops experimental imagery + flight plans between launches.', 'tethys' ); ?></li>
                        </ul>
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <a href="<?php echo esc_url( tethys_page_link( 'signals-from-thethys' ) ); ?>" class="cta-primary w-full sm:w-auto">
                                <?php esc_html_e( 'Start with Signals Dispatches', 'tethys' ); ?>
                            </a>
                            <a href="https://www.patreon.com/c/WorldofTethysDCBarletta" target="_blank" rel="noopener noreferrer" class="nav-link--ghost inline-flex w-full items-center justify-center gap-2 text-slate-200 sm:w-auto">
                                <?php esc_html_e( 'Join the Patreon', 'tethys' ); ?>
                            </a>
                        </div>
                    </div>

                    <nav class="col-span-full flex flex-wrap gap-3 border-t border-slate-800/50 pt-4">
                        <a href="<?php echo esc_url( tethys_page_link( 'world-of-tethys' ) ); ?>" class="nav-pill"><?php esc_html_e( 'World', 'tethys' ); ?></a>
                        <a href="<?php echo esc_url( tethys_page_link( 'books-2' ) ); ?>" class="nav-pill"><?php esc_html_e( 'Books', 'tethys' ); ?></a>
                        <a href="<?php echo esc_url( tethys_page_link( 'signals-from-thethys' ) ); ?>" class="nav-pill"><?php esc_html_e( 'Signals', 'tethys' ); ?></a>
                        <a href="<?php echo esc_url( tethys_page_link( 'real-science' ) ); ?>" class="nav-pill"><?php esc_html_e( 'Real Science', 'tethys' ); ?></a>
                        <a href="<?php echo esc_url( tethys_page_link( 'comments' ) ); ?>" class="nav-pill"><?php esc_html_e( 'Comments', 'tethys' ); ?></a>
                    </nav>
                </div>
            </header>
        </div>
    </div>

    <main class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8 space-y-12">
        <section class="space-y-4">
            <p class="section-label"><?php esc_html_e( 'Start here', 'tethys' ); ?></p>
            <h2 class="font-display text-3xl font-semibold text-slate-50"><?php esc_html_e( 'Choose your way into Tethys', 'tethys' ); ?></h2>
            <div class="grid gap-5 md:grid-cols-3">
                <article class="card-shell flex h-full flex-col gap-3 p-5">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400"><?php esc_html_e( 'Read', 'tethys' ); ?></p>
                    <h3 class="text-lg font-semibold text-slate-50"><?php esc_html_e( 'Read the stories', 'tethys' ); ?></h3>
                    <p class="text-sm text-slate-300">
                        <?php esc_html_e( 'Start with the Signals short fiction line while Book One finishes edits.', 'tethys' ); ?>
                    </p>
                    <a href="<?php echo esc_url( tethys_page_link( 'world-of-tethys' ) . '#shorts' ); ?>" class="nav-link--ghost mt-auto inline-flex items-center gap-2 text-lava-200">
                        <?php esc_html_e( 'Explore Kindle releases ↗', 'tethys' ); ?>
                    </a>
                </article>

                <article class="card-shell flex h-full flex-col gap-3 p-5">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400"><?php esc_html_e( 'Listen', 'tethys' ); ?></p>
                    <h3 class="text-lg font-semibold text-slate-50"><?php esc_html_e( 'Listen to the audio', 'tethys' ); ?></h3>
                    <p class="text-sm text-slate-300">
                        <?php esc_html_e( 'Dive into premium 20-minute Signals from Tethys dispatches and narrated shorts.', 'tethys' ); ?>
                    </p>
                    <a href="<?php echo esc_url( tethys_page_link( 'signals-from-thethys' ) ); ?>" class="nav-link--ghost mt-auto inline-flex items-center gap-2 text-lava-200">
                        <?php esc_html_e( 'Hear the Signals ↗', 'tethys' ); ?>
                    </a>
                </article>

                <article class="card-shell flex h-full flex-col gap-3 p-5">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-400"><?php esc_html_e( 'Support', 'tethys' ); ?></p>
                    <h3 class="text-lg font-semibold text-slate-50"><?php esc_html_e( 'Support the world', 'tethys' ); ?></h3>
                    <p class="text-sm text-slate-300">
                        <?php esc_html_e( 'Join the Circle on Patreon, share clips, or grab shorts on Kindle and Audible.', 'tethys' ); ?>
                    </p>
                    <a href="<?php echo esc_url( tethys_page_link( 'support' ) ); ?>" class="nav-link--ghost mt-auto inline-flex items-center gap-2 text-lava-200">
                        <?php esc_html_e( 'See how to help ↗', 'tethys' ); ?>
                    </a>
                </article>
            </div>
        </section>

        <section class="card-shell p-6 space-y-4">
            <div class="space-y-2">
                <p class="section-label"><?php esc_html_e( 'Support CTA', 'tethys' ); ?></p>
                <h2 class="font-display text-3xl font-semibold text-slate-50"><?php esc_html_e( 'Fuel the Signals via Stripe', 'tethys' ); ?></h2>
                <p class="text-sm text-slate-300"><?php esc_html_e( 'Tap the hosted Stripe button to join Watcher’s Crescent ($2/mo) and keep dispatches flowing.', 'tethys' ); ?></p>
            </div>
            <div class="rounded-2xl border border-slate-800/70 bg-slate-950/60 p-4 text-center">
                <stripe-buy-button
                    buy-button-id="buy_btn_1Sci9DLW0kz6xhQECEesQvSM"
                    publishable-key="pk_live_51SbaZgLW0kz6xhQECz0AypYFbiL8voH7zKuKfOnOmHtfEqVKNUsSeDC6gcjdIj5fC8Zh3VfyU2jzEVUriEDdfsCG00sLw8aqaU"
                >
                </stripe-buy-button>
            </div>
        </section>

        <section>
            <div class="card-shell p-6">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="space-y-3">
                        <p class="section-label"><?php esc_html_e( 'Free newsletter', 'tethys' ); ?></p>
                        <h2 class="font-display text-3xl font-semibold text-slate-50"><?php esc_html_e( 'Pteroswifts from Tethys', 'tethys' ); ?></h2>
                        <p class="text-sm text-slate-300">
                            <?php esc_html_e( 'Flying dispatches from the World of Tethys—story updates, experimental imagery, and lore that doesn’t fit anywhere else. Expect early peeks at shorts and audiobooks, weird field cards, studio notes, and the occasional science-nerd dive.', 'tethys' ); ?>
                        </p>
                    </div>
                    <div class="flex flex-col gap-3 md:min-w-[240px]">
                        <a href="https://dcbarletta.substack.com" target="_blank" rel="noopener noreferrer" class="cta-primary justify-center">
                            <?php esc_html_e( 'Join the newsletter', 'tethys' ); ?>
                        </a>
                        <p class="text-center text-xs uppercase tracking-[0.2em] text-slate-500"><?php esc_html_e( 'Hosted on Substack', 'tethys' ); ?></p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<?php
get_footer();
