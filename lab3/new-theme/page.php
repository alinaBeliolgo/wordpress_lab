<?php get_header(); ?>

<main class="site-content">
  <div class="entry-content">
<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>
    <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
      <h1><?php the_title(); ?></h1>

      <div class="entry-meta">
        <span class="entry-date"><?php echo get_the_date(); ?></span>
        <span class="entry-author"> | <?php the_author(); ?></span>
      </div>

      <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
          <?php the_post_thumbnail( 'large' ); ?>
        </div>
      <?php endif; ?>

      <div class="page-content">
        <?php the_content(); ?>
      </div>
    </article>

    <?php comments_template(); ?>
  <?php endwhile; ?>
<?php endif; ?>
  </div>
  <?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>