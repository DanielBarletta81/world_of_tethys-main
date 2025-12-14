<?php
/*
Template Name: Tethys Books
*/
get_header();
?>
<div class="min-h-screen bg-abyss bg-tethys-radial text-slate-100">
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        <header class="mb-8 flex flex-col gap-4 rounded-3xl border border-lava-400/30 bg-slate-950/70 p-6 shadow-ember-line md:flex-row md:items-center md:justify-between">
            <div>
                <p class="eyebrow text-lava-300 drop-shadow-ember">World of Tethys · Books</p>
                <h1 class="font-display text-3xl font-semibold text-slate-50 drop-shadow-ember">
                    Books in the World of Tethys
                </h1>
                <p class="max-w-2xl text-sm text-slate-300">
                    Sky cities, volcanic shelves, river clans, and forests that remember what the City forgot.
                    This is where the <span class="font-semibold text-slate-100">World of Tethys</span> series lives as books.
                </p>
            </div>
            <nav class="flex gap-3 text-[11px]">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-link nav-link--ghost">Igzier file</a>
                <a href="<?php echo esc_url( tethys_page_link( 'characters' ) ); ?>" class="nav-link">Characters</a>
            </nav>
        </header>

        <div class="mb-8 overflow-hidden rounded-3xl border border-lava-400/25 bg-slate-950/70 shadow-soft-bronze">
            <div class="border-b border-slate-800/80 bg-slate-950/90 px-4 py-2 text-[11px] uppercase tracking-[0.18em] text-slate-400">
                Series status
            </div>
            <div class="grid gap-4 px-4 py-4 text-xs text-slate-300 sm:grid-cols-3">
                <div class="space-y-1 rounded-2xl border border-slate-800/80 bg-slate-950/70 p-3">
                    <p class="text-[11px] font-semibold text-slate-200">Book 1 · Sky City</p>
                    <p><span class="inline-flex items-center gap-1 rounded-full bg-slate-900/90 px-2 py-1 text-[10px] text-lava-300">
                        <span class="h-1.5 w-1.5 rounded-full bg-lava-500"></span>
                        In edits
                    </span></p>
                    <p>Final polish, lore alignment, and art underway.</p>
                </div>
                <div class="space-y-1 rounded-2xl border border-slate-800/80 bg-slate-950/70 p-3">
                    <p class="text-[11px] font-semibold text-slate-200">Future books</p>
                    <p>Book 2 and beyond are outlined and in progress, expanding beyond Sky City into river clans, shelves, and open Tethys sea.</p>
                </div>
                <div class="space-y-1 rounded-2xl border border-slate-800/80 bg-slate-950/70 p-3">
                    <p class="text-[11px] font-semibold text-slate-200">Stay in the loop</p>
                    <p>For trailers, lore drops, and release news, follow:</p>
                    <p class="mt-1">
                        YouTube · <span class="text-sky-400">@worldoftethysauthor</span><br>
                        TikTok · <span class="text-sky-400">@worldoftethys_writer</span>
                    </p>
                </div>
            </div>
        </div>

        <section class="grid gap-6 md:grid-cols-2">
            <article class="relative flex h-full flex-col overflow-hidden rounded-3xl border border-lava-500/40 bg-slate-950/85 p-5 shadow-[0_0_45px_rgba(248,113,113,0.25)] transition hover:-translate-y-1 hover:shadow-lava-ring">
                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-lava-500 via-orange-400 to-slate-500 opacity-80"></div>
                <div class="mb-3 flex items-center justify-between text-[11px] text-slate-400">
                    <span class="inline-flex items-center gap-1">
                        <span class="inline-block h-1.5 w-1.5 rounded-full bg-lava-500"></span>
                        Book One · In edits
                    </span>
                    <span>Epic science fantasy</span>
                </div>
                <h2 class="font-display text-xl font-semibold text-slate-50">World of Tethys: Sky City</h2>
                <p class="mt-1 text-xs text-slate-400">by D.C. Barletta</p>
                <p class="mt-3 text-sm text-slate-200">
                    A sky city carved into a volcanic cliff. An engineer exiled for telling the truth.
                    A bonded sky-hound who jumps after him. A healer in the woods who hears colors instead of warnings.
                </p>
                <ul class="mt-3 space-y-1.5 text-xs text-slate-300">
                    <li>• <span class="font-semibold text-slate-100">Igzier</span> – mixed-lineage engineer thrown from the Weep for refusing to lie.</li>
                    <li>• <span class="font-semibold text-slate-100">Stryker</span> – ptero–raptor sky-hound, moose-sized and stupidly loyal.</li>
                    <li>• <span class="font-semibold text-slate-100">Karys</span> – greenhouse heir who sees where the pipes crack.</li>
                    <li>• <span class="font-semibold text-slate-100">Ravel</span> – forest healer tuned to tones, colors, and root gossip.</li>
                    <li>• <span class="font-semibold text-slate-100">Melden</span> – the mentor who calls Sky City an experiment, not a miracle.</li>
                </ul>
                <div class="mt-5 space-y-3 text-xs text-slate-300">
                    <div class="rounded-2xl border border-slate-700/80 bg-slate-950/90 p-3">
                        <p class="text-[11px] font-semibold text-slate-200 uppercase tracking-[0.16em]">Release & availability</p>
                        <p class="mt-1">Currently in edits. Not yet available on Amazon or in bookstores—but that’s the goal.</p>
                        <p class="mt-2">
                            If you want first notice when <span class="font-semibold text-slate-100">Sky City</span> is ready
                            to preorder or request at your local bookstore, keep an eye on the socials.
                        </p>
                    </div>
                    <div class="rounded-2xl border border-slate-700/80 bg-slate-950/90 p-3">
                        <p class="text-[11px] font-semibold text-slate-200 uppercase tracking-[0.16em]">Get book 1 updates</p>
                        <p class="mt-1">You can also join the Tethys list for release news and early lore drops.</p>
                        <a href="#" class="mt-2 inline-flex items-center gap-2 rounded-full bg-lava-500 px-4 py-2 text-[11px] font-semibold text-slate-950 shadow-lava hover:bg-lava-400">
                            Join the watchlist
                            <span>🪽</span>
                        </a>
                        <p class="mt-1 text-[10px] text-slate-500">No spam, no empires. Just Tethys.</p>
                    </div>
                </div>
            </article>

            <article class="card-shell flex h-full flex-col p-5 transition hover:-translate-y-1">
                <div class="mb-3 flex items-center justify-between text-[11px] text-slate-400">
                    <span class="inline-flex items-center gap-1">
                        <span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-500"></span>
                        Series roadmap
                    </span>
                    <span>Work in progress</span>
                </div>
                <h2 class="font-display text-xl font-semibold text-slate-50">Beyond Sky City</h2>
                <p class="mt-3 text-sm text-slate-200">
                    <span class="font-semibold text-slate-100">World of Tethys</span> is planned as a multi-book series.
                    Book 1 anchors you in Sky City and the immediate fallout of Igzier’s exile.
                    Future books open up the map.
                </p>
                <ul class="mt-3 space-y-1.5 text-xs text-slate-300">
                    <li>• River clans and estuary warfare along Silurian territory.</li>
                    <li>• Thals assembling with bonded mammoths and sabertooths.</li>
                    <li>• Pteros Island, its bone piles, and the sky-creature breeding grounds.</li>
                    <li>• Deeper dives into the Tethys Sea shelves and what hunts there.</li>
                    <li>• How far Sky City will go to pretend the experiment is still under control.</li>
                </ul>
                <div class="mt-5 grid gap-3 text-xs text-slate-300">
                    <div class="rounded-2xl border border-slate-700/80 bg-slate-950/90 p-3">
                        <p class="text-[11px] font-semibold text-slate-200">Book Two · Working title</p>
                        <p class="mt-1 text-slate-400">
                            Expands beyond the cliff: river warfare, Silurian politics, and the cost
                            of bringing Sky City problems downstream.
                        </p>
                    </div>
                    <div class="rounded-2xl border border-slate-700/80 bg-slate-950/90 p-3">
                        <p class="text-[11px] font-semibold text-slate-200">Future stories & prequels</p>
                        <p class="mt-1 text-slate-400">
                            Melden’s earlier experiments, the first bonded creatures, and how the
                            experiment in the clouds was sold as salvation in the first place.
                        </p>
                    </div>
                </div>
                <div class="mt-6 border-t border-slate-800/80 pt-4 text-[11px] text-slate-400">
                    For now, the best way to help this series reach bookstores and readers is to follow the channels,
                    share the trailers, and tell other SFF nerds “hey, there’s a sky city carved into a volcano.”
                </div>
            </article>
        </section>
    </div>
</div>
<?php get_footer(); ?>
