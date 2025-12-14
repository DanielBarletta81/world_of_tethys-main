<?php
/*
Template Name: Tethys Real Science
*/
get_header();
?>
<div class="min-h-screen bg-abyss bg-tethys-radial text-slate-100">
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <header class="mb-10 space-y-3 text-center">
            <p class="section-label justify-center">Lore meets lab</p>
            <h1 class="font-display text-4xl font-semibold text-slate-50 drop-shadow-ember">The Real Science Beneath Sky City</h1>
            <p class="text-sm text-slate-300">
                Volcano acoustics, bioluminescent algae, river hydraulics, and the actual physics that make
                bonded sky-hounds plausible.
            </p>
        </header>

        <section class="grid gap-6 lg:grid-cols-3">
            <article class="science-card">
                <p class="eyebrow text-lava-300">Volcanology</p>
                <h2 class="mt-2 text-lg font-semibold text-slate-50">The Weep & Watcher</h2>
                <p class="mt-2 text-sm text-slate-300">
                    Sky City’s cliffside mirrors real lava tube systems along Hawai‘i and Iceland. The Weep is modeled after
                    discharge data from Angel Falls (Venezuela) mixed with pressure gauges from geothermal plants.
                </p>
                <a class="cta-link mt-3" href="https://www.usgs.gov/programs/VHP" target="_blank" rel="noreferrer">USGS volcano watch ↗</a>
            </article>
            <article class="science-card">
                <p class="eyebrow text-lava-300">Bioacoustics</p>
                <h2 class="mt-2 text-lg font-semibold text-slate-50">Hearing colors</h2>
                <p class="mt-2 text-sm text-slate-300">
                    Ravel’s synesthetic diagnostics riff on real-world studies where clinicians map spectral data to
                    nerve responses. I’m obsessed with Dr. Sarah Angliss’s theremin-biomedical mashups.
                </p>
                <a class="cta-link mt-3" href="https://www.frontiersin.org/articles/10.3389/fnhum.2019.00373/full" target="_blank" rel="noreferrer">Medical synesthesia research ↗</a>
            </article>
            <article class="science-card">
                <p class="eyebrow text-lava-300">Aero biology</p>
                <h2 class="mt-2 text-lg font-semibold text-slate-50">Bonded sky-hounds</h2>
                <p class="mt-2 text-sm text-slate-300">
                    Stryker’s wing span, bone density, and heat shielding borrow from raptor biomechanics + NASA’s shuttle tiles.
                    Every glide path is checked against falcon telemetry out of Cornell’s raptor lab.
                </p>
                <a class="cta-link mt-3" href="https://www.birds.cornell.edu/home" target="_blank" rel="noreferrer">Cornell Lab of Ornithology ↗</a>
            </article>
        </section>

        <section class="mt-10 grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
            <article class="backlit-panel border border-lava-400/20">
                <h2 class="font-display text-2xl font-semibold text-slate-50">Field notebooks</h2>
                <p class="mt-2 text-sm text-slate-300">Clippings from the actual research stack.</p>
                <ul class="mt-4 space-y-3 text-sm text-slate-300">
                    <li class="flex items-start gap-3">
                        <span class="text-lava-300">01</span>
                        <div>
                            <p class="font-semibold text-slate-100">Flow maps</p>
                            <p>QGIS layers comparing river velocity to Silurian canoe routes.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-lava-300">02</span>
                        <div>
                            <p class="font-semibold text-slate-100">Atmospheric drag models</p>
                            <p>Used to decide how far a sky-hound can free fall before wing deployment.</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-lava-300">03</span>
                        <div>
                            <p class="font-semibold text-slate-100">Botanical dyes</p>
                            <p>For Younger Woods healers—real recipes derived from woad + cochineal.</p>
                        </div>
                    </li>
                </ul>
            </article>
            <aside class="card-shell p-5">
                <p class="eyebrow text-lava-300">Want deep dives?</p>
                <p class="mt-2 text-sm text-slate-300">
                    I publish mini “lab notes” videos whenever a research rabbit hole pays off.
                    Subscribe on YouTube or hop on the Tethys list to get them first.
                </p>
                <a class="nav-cta mt-4 inline-flex" href="https://www.youtube.com/@worldoftethysauthor" target="_blank" rel="noreferrer">
                    Watch the lab feed
                    <span>↗</span>
                </a>
            </aside>
        </section>
    </div>
</div>
<?php get_footer(); ?>
