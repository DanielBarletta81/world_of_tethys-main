<?php get_header(); ?>
<div class="min-h-screen bg-abyss bg-tethys-radial text-slate-100">
    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article <?php post_class( 'prose prose-invert max-w-none text-slate-200' ); ?>>
                    <h1 class="font-display text-3xl font-semibold text-slate-50"><?php the_title(); ?></h1>
                    <div class="mt-4 space-y-4 text-sm leading-relaxed">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p class="text-center text-sm text-slate-400">Add content in the WordPress editor to see it here.</p>
        <?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>
