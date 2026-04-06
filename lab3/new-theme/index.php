<?php get_header(); ?>

<main class="site-content">
    <div class="entry-content">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
        <article <?php post_class(); ?>>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="entry-meta">
                <span class="entry-date"><?php echo get_the_date(); ?> | <?php the_author(); ?></span>
            </div>
            <div class="entry-content">
                <?php the_excerpt(); ?>
                <a class="read-more" href="<?php the_permalink(); ?>">Читать далее -></a>
            </div>
        </article>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
<?php else : ?>
    <p><?php _e('Извините, ничего не найдено.'); ?></p>
<?php endif; ?>
    </div>
  <?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>
