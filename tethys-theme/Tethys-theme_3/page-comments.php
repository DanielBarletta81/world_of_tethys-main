<?php
/*
Template Name: Tethys Comments
*/
get_header();
?>
<div class="min-h-screen bg-abyss bg-tethys-radial text-slate-100">
    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        <header class="mb-10 space-y-3 text-center">
            <p class="section-label justify-center">Reader signals</p>
            <h1 class="font-display text-4xl font-semibold text-slate-50 drop-shadow-ember">Comments from the Edge</h1>
            <p class="text-sm text-slate-300">
                Notes from early readers, lore obsessives, and fellow engineers who weighed in on Sky City.
            </p>
        </header>

        <section class="grid gap-5 md:grid-cols-2">
            <?php
            $comments = [
                [
                    'quote' => 'Igzier feels like the first engineer hero who actually respects math on the page.',
                    'author' => 'Mara V. · aerospace analyst'
                ],
                [
                    'quote' => 'The Younger Woods scenes smell like wet cedar and copper. I still hear the Weep.',
                    'author' => 'Noor · beta reader'
                ],
                [
                    'quote' => 'As someone who grew up on volcano monitoring stations, this book nails the tension.',
                    'author' => 'Leo P. · volcanology grad'
                ],
                [
                    'quote' => 'Stryker is the chaotic good emotional support monster I didn’t know I needed.',
                    'author' => 'Ari · creature designer'
                ]
            ];
            foreach ( $comments as $signal ) : ?>
                <article class="comment-card">
                    <p class="text-base text-slate-100">“<?php echo esc_html( $signal['quote'] ); ?>”</p>
                    <p class="mt-3 text-[11px] uppercase tracking-[0.22em] text-slate-500"><?php echo esc_html( $signal['author'] ); ?></p>
                </article>
            <?php endforeach; ?>
        </section>

        <section class="mt-10 grid-panel">
            <h2 class="text-lg font-semibold text-slate-50">Leave your own signal</h2>
            <p class="text-sm text-slate-400">Use the form if Substack comments aren’t your thing.</p>
            <form class="form-grid mt-3" method="post" action="<?php echo esc_url( home_url( '/comments' ) ); ?>">
                <div>
                    <label for="comment-name">Name / handle</label>
                    <input id="comment-name" name="comment-name" type="text" placeholder="Sky City resident" required>
                </div>
                <div>
                    <label for="comment-role">Role</label>
                    <input id="comment-role" name="comment-role" type="text" placeholder="Reader, scientist, bookseller">
                </div>
                <div>
                    <label for="comment-message">Comment</label>
                    <textarea id="comment-message" name="comment-message" placeholder="What did you feel when the Weep cracked?"></textarea>
                </div>
                <button type="submit" class="nav-cta justify-center">Transmit</button>
            </form>
        </section>
    </div>
</div>
<?php get_footer(); ?>
