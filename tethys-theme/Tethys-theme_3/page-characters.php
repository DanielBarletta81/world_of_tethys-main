<?php
/*
Template Name: Tethys Characters
*/
get_header();
?>
<div class="min-h-screen bg-abyss bg-tethys-radial text-slate-100">
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        <header class="mb-8 flex flex-col gap-4 rounded-3xl border border-lava-400/30 bg-slate-950/70 p-6 shadow-ember-line md:flex-row md:items-center md:justify-between">
            <div>
                <p class="eyebrow text-lava-300 drop-shadow-ember">World of Tethys · Cast</p>
                <h1 class="font-display text-3xl font-semibold text-slate-50 drop-shadow-ember">
                    Characters of <span class="italic">Sky City</span>
                </h1>
                <p class="max-w-2xl text-sm text-slate-300">
                    The experiment in the clouds, the river clans below, the forests in between,
                    and the creatures that stop obeying. Start with the core cast of
                    <span class="font-semibold text-slate-100">World of Tethys: Sky City</span>.
                </p>
            </div>
            <nav class="flex gap-3 text-[11px]">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-link nav-link--ghost">Igzier file</a>
                <a href="<?php echo esc_url( tethys_page_link( 'books-2' ) ); ?>" class="nav-link">Books</a>
            </nav>
        </header>

        <div class="mb-6 flex flex-wrap items-center gap-3 rounded-full border border-slate-800/80 bg-slate-950/70 px-4 py-3 text-[11px] text-slate-400 shadow-soft-bronze">
            <span class="uppercase tracking-[0.18em] text-slate-500">Legend</span>
            <span class="inline-flex items-center gap-1 rounded-full bg-slate-900/70 px-2.5 py-1">
                <span class="h-1.5 w-1.5 rounded-full bg-lava-500"></span>
                Sky City
            </span>
            <span class="inline-flex items-center gap-1 rounded-full bg-slate-900/70 px-2.5 py-1">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                Mystic Woods
            </span>
            <span class="inline-flex items-center gap-1 rounded-full bg-slate-900/70 px-2.5 py-1">
                <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                Tethys Sea &  Danian River
            </span>
        </div>

        <section class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <article class="card-shell relative flex h-full flex-col overflow-hidden p-4 transition hover:-translate-y-1">
                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-lava-500 to-slate-500 opacity-70"></div>
                <div class="mb-3 flex items-center justify-between gap-2 text-[11px] text-slate-400">
                    <span class="inline-flex items-center gap-1">
                        <span class="inline-block h-1.5 w-1.5 rounded-full bg-lava-500"></span>
                        Sky City · Exile
                    </span>
                    <span>POV · Book 1</span>
                </div>
                <h2 class="text-sm font-semibold text-slate-50">Igzier</h2>
                <p class="mt-1 text-xs text-slate-300">
                    Mixed-lineage engineer who values honesty, and lives in a dishonest Sky City.
                    Thrown from the Weep for telling the truth about his mentor’s death, and rabidly in love with Karys
                </p><br>
                <p class="mt-3 text-[11px] text-slate-400">
                    • Exiled by choice, instead of painless "The Quick"<br>
                    • Bonded with Stryker<br>
                    • Still deciding if the City deserves saving, or burning
                </p><br>
                <div class="mt-auto pt-4">
                    
                </div>
            </article>

            <article class="card-shell relative flex h-full flex-col overflow-hidden p-4 transition hover:-translate-y-1">
                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-sky-400 to-lava-500 opacity-70"></div>
                <div class="mb-3 flex items-center justify-between gap-2 text-[11px] text-slate-400">
                    <span class="inline-flex items-center gap-1">
                        <span class="inline-block h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                        Ptero-raptor “sky-hound”
                    </span>
                    <span>Creature · Bonded</span>
                </div>
                <h2 class="text-sm font-semibold text-slate-50">Stryker</h2>
                <p class="mt-1 text-xs text-slate-300">
                    Ptero–raptor “sky-hound” who chooses exile with Igzier, then loses him
                    in ashfall when the Watcher wakes. Moose-sized, scarred, still thinks he’s a lap pet.
                </p>
                <p class="mt-3 text-[11px] text-slate-400">
                    • Built for gliding, diving, and bad decisions<br>
                    • Tracks Igzier through caves, shelves, and ash<br>
                    • Center of the Ashwing sigil
                </p>
                <div class="mt-auto pt-4">
                    <a href="#" class="inline-flex items-center gap-1 text-[11px] font-semibold text-lava-400 hover:text-lava-300">
                        View Stryker’s file
                        <span>↗</span>
                    </a>
                </div>
            </article>

            <article class="card-shell relative flex h-full flex-col overflow-hidden p-4 transition hover:-translate-y-1">
                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-emerald-400 to-lava-400 opacity-70"></div>
                <div class="mb-3 flex items-center justify-between gap-2 text-[11px] text-slate-400">
                    <span class="inline-flex items-center gap-1">
                        <span class="inline-block h-1.5 w-1.5 rounded-full bg-lava-500"></span>
                        Sky City · Greenhouse
                    </span>
                    <span>Key POV</span>
                </div>
                <h2 class="text-sm font-semibold text-slate-50">Karys</h2>
                <p class="mt-1 text-xs text-slate-300">
                    Greenhouse heir who maps roots and water flow while the Triumvirate edits reality.
                    Tied to comfort by family, tied to change by conscience.
                </p>
                <p class="mt-3 text-[11px] text-slate-400">
                    • Daughter of Lady Eldora<br>
                    • Sees where pipes – and policies – crack<br>
                    • One of the hands on the City’s scale
                </p>
                <div class="mt-auto pt-4">
                    <a href="#" class="inline-flex items-center gap-1 text-[11px] font-semibold text-lava-400 hover:text-lava-300">
                        View Karys’s file
                        <span>↗</span>
                    </a>
                </div>
            </article>

            <article class="card-shell relative flex h-full flex-col overflow-hidden p-4 transition hover:-translate-y-1">
                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-emerald-400 to-sky-400 opacity-70"></div>
                <div class="mb-3 flex items-center justify-between gap-2 text-[11px] text-slate-400">
                    <span class="inline-flex items-center gap-1">
                        <span class="inline-block h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        Mystic Woods
                    </span>
                    <span>POV · Healer</span>
                </div>
                <h2 class="text-sm font-semibold text-slate-50">Ravel</h2>
                <p class="mt-1 text-xs text-slate-300">
                    Mushroom tea-drunk forest healer who hears colors, tones, and “bruises in the air”
                    instead of warnings. The man following Igzier by sound alone.
                </p>
                <p class="mt-3 text-[11px] text-slate-400">
                    • Calls the Weep “screaming in cracked teal”<br>
                    • Talks to roots and a secretive archaeopteryx<br>
                    • Quietly decides Igzier is worth keeping alive
                </p>
                <div class="mt-auto pt-4">
                    <a href="#" class="inline-flex items-center gap-1 text-[11px] font-semibold text-lava-400 hover:text-lava-300">
                        View Ravel’s file
                        <span>↗</span>
                    </a>
                </div>
            </article>

            <article class="card-shell relative flex h-full flex-col overflow-hidden p-4 transition hover:-translate-y-1">
                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-lava-400 to-slate-500 opacity-70"></div>
                <div class="mb-3 flex items-center justify-between gap-2 text-[11px] text-slate-400">
                    <span class="inline-flex items-center gap-1">
                        <span class="inline-block h-1.5 w-1.5 rounded-full bg-lava-500"></span>
                        Sky City · Infrastructure
                    </span>
                    <span>Supporting</span>
                </div>
                <h2 class="text-sm font-semibold text-slate-50">Jairo</h2>
                <p class="mt-1 text-xs text-slate-300">
                    Lower-tier lifer who keeps the water flowing and the records clean. Wants
                    to believe the City is fixable… until the cracks stop being theoretical.
                </p>
                <p class="mt-3 text-[11px] text-slate-400">
                    • Grew up alongside Igzier<br>
                    • Mixed-lineage, too sharp for his slot<br>
                    • Torn between loyalty and data
                </p>
                <div class="mt-auto pt-4">
                    <a href="#" class="inline-flex items-center gap-1 text-[11px] font-semibold text-lava-400 hover:text-lava-300">
                        View Jairo’s file
                        <span>↗</span>
                    </a>
                </div>
            </article>

            <article class="card-shell relative flex h-full flex-col overflow-hidden p-4 transition hover:-translate-y-1">
                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-slate-400 to-lava-500 opacity-70"></div>
                <div class="mb-3 flex items-center justify-between gap-2 text-[11px] text-slate-400">
                    <span class="inline-flex items-center gap-1">
                        <span class="inline-block h-1.5 w-1.5 rounded-full bg-lava-500"></span>
                        Sky City · Mentor
                    </span>
                    <span>Deceased · Echo</span>
                </div>
                <h2 class="text-sm font-semibold text-slate-50">Melden</h2>
                <p class="mt-1 text-xs text-slate-300">
                    The scientist who insisted Sky City was an experiment, not a miracle.
                    His “natural” death and Igzier’s refusal to lie about it light the fuse.
                </p>
                <p class="mt-3 text-[11px] text-slate-400">
                    • Runs tests above the Weep<br>
                    • Frames survival as chance colliding with rules<br>
                    • Lives on in Igzier’s worst (best) decisions
                </p>
                <div class="mt-auto pt-4">
                    <a href="#" class="inline-flex items-center gap-1 text-[11px] font-semibold text-lava-400 hover:text-lava-300">
                        View Melden’s file
                        <span>↗</span>
                    </a>
                </div>
            </article>

            <article class="card-shell relative flex h-full flex-col overflow-hidden border-dashed border-slate-700/80 bg-slate-950/50 p-4 transition hover:-translate-y-1">
                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-sky-500 to-emerald-400 opacity-40"></div>
                <div class="mb-3 flex items-center justify-between gap-2 text-[11px] text-slate-400">
                    <span class="inline-flex items-center gap-1">
                        <span class="inline-block h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                        Factions
                    </span>
                    <span>Coming soon</span>
                </div>
                <h2 class="text-sm font-semibold text-slate-50">Silurians & Others</h2>
                <p class="mt-1 text-xs text-slate-300">
                    River clans, shelf-dwellers, and other groups whose choices shape what happens
                    when Sky City’s experiment cracks.
                </p>
                <p class="mt-3 text-[11px] text-slate-400">
                    • Silurians – riverbone people<br>
                    • Thals – bonded warfronts<br>
                    • More to be unveiled as the series grows
                </p>
            </article>
        </section>
    </div>
</div>
<?php get_footer(); ?>
