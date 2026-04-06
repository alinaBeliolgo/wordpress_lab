<?php get_header(); ?>

<main class="site-content">
  <div class="entry-content">
<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <h1><?php the_title(); ?></h1>

      <div class="entry-meta">
        <span class="entry-date"><?php echo get_the_date(); ?></span>
        <span class="entry-author"> | <?php the_author(); ?></span>
        <span class="entry-category"> | <?php the_category( ', ' ); ?></span>
      </div>

      <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
          <?php the_post_thumbnail( 'large' ); ?>
        </div>
      <?php endif; ?>

      <div class="post-content">
        <?php the_content(); ?>
      </div>

      <?php if ( has_tag() ) : ?>
        <div class="post-tags">
          <?php the_tags( 'Теги: ', ', ', '' ); ?>
        </div>
      <?php endif; ?>

      <div class="post-navigation">
        <div class="nav-previous">
          <?php previous_post_link( '%link', '&larr; Предыдущий пост' ); ?>
        </div>
        <div class="nav-next">
          <?php next_post_link( '%link', 'Следующий пост &rarr;' ); ?>
        </div>
      </div>
    </article>

    <?php comments_template(); ?>
  <?php endwhile; ?>
<?php endif; ?>
  </div>
  <?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>