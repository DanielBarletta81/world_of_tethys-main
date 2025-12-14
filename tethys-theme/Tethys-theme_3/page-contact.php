<?php
/*
Template Name: Tethys Contact
*/
get_header();
?>
<div class="min-h-screen bg-abyss bg-tethys-radial text-slate-100">
    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        <header class="mb-10 space-y-3 text-center">
            <p class="section-label justify-center">Signal the Watch</p>
            <h1 class="font-display text-4xl font-semibold text-slate-50 drop-shadow-ember">Contact the World of Tethys</h1>
            <p class="text-sm text-slate-300">
                Pitch collaborations, request media kits, or tag in when you have a question about ashfalls, sky-hounds,
                or book launch logistics.
            </p>
        </header>

        <div class="grid gap-8 md:grid-cols-[1.1fr_0.9fr]">
            <section class="grid-panel">
                <h2 class="text-lg font-semibold text-slate-50">Drop a message</h2>
                <p class="text-sm text-slate-400">This form routes to the tiny team keeping Sky City lore aligned.</p>
                <form class="mt-4 form-grid" method="post" action="<?php echo esc_url( home_url( '/contact' ) ); ?>">
                    <div>
                        <label for="contact-name">Name</label>
                        <input id="contact-name" name="contact-name" type="text" placeholder="Sky-tier or clan" required>
                    </div>
                    <div>
                        <label for="contact-email">Email</label>
                        <input id="contact-email" name="contact-email" type="email" placeholder="you@example.com" required>
                    </div>
                    <div>
                        <label for="contact-topic">Topic</label>
                        <input id="contact-topic" name="contact-topic" type="text" placeholder="Podcast invite, bookstore event, lore question">
                    </div>
                    <div>
                        <label for="contact-message">Message</label>
                        <textarea id="contact-message" name="contact-message" placeholder="Let me tell you about the cliffside idea…"></textarea>
                    </div>
                    <button type="submit" class="nav-cta justify-center">Send transmission</button>
                </form>
            </section>

            <aside class="grid gap-4">
                <div class="card-shell p-5">
                    <p class="eyebrow text-lava-300">Need faster?</p>
                    <h3 class="mt-2 text-lg font-semibold text-slate-50">Email</h3>
                    <a class="cta-link" href="mailto:hello@worldoftethys.com">hello@worldoftethys.com ↗</a>
                </div>
                <div class="card-shell p-5">
                    <p class="eyebrow text-lava-300">Press & media</p>
                    <p class="mt-2 text-sm text-slate-300">
                        Request ARCs, trailers, graphics, or author interviews. Include deadlines and platform info.
                    </p>
                </div>
                <div class="card-shell p-5">
                    <p class="eyebrow text-lava-300">Bookstores & educators</p>
                    <p class="mt-2 text-sm text-slate-300">
                        Interested in signings, virtual Q&A, or custom curriculum tie-ins? Drop the details above.
                    </p>
                </div>
            </aside>
        </div>
    </div>
</div>
<?php get_footer(); ?>
