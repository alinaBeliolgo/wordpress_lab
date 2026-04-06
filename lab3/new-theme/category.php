<?php get_header(); ?>

<main class="site-content">
  <div class="entry-content">
    <h1><?php single_cat_title(); ?></h1>
<?php 
  if ( is_category() ) : ?>
    <?php 
      $category_description = category_description();
      if ( $category_description ) {
        echo '<div class="archive-description">' . $category_description . '</div>';
      }
    ?>
<?php endif; ?>
<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>
    <article <?php post_class(); ?>>
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <div class="entry-meta">
        <span class="entry-date"><?php echo get_the_date(); ?> | <?php the_author(); ?></span>
      </div>
      <div>
        <?php the_excerpt(); ?>
      </div>
      <a class="read-more" href="<?php the_permalink(); ?>">Читать далее -></a>
    </article>
  <?php endwhile; ?>
<?php else: ?>
  <p>Записей не найдено в этой категории.</p>
<?php endif; ?>
  </div>
  <?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>