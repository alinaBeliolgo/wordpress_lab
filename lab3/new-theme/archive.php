<?php get_header(); ?>

<main class="site-content">
  <div class="entry-content">
    <h1>
      <?php
      if ( is_category() ) {
          echo 'Рубрика: ' . single_cat_title( '', false );
      } elseif ( is_tag() ) {
          echo 'Тег: ' . single_tag_title( '', false );
      } elseif ( is_author() ) {
          echo 'Автор: ' . get_the_author();
      } elseif ( is_year() ) {
          echo 'Архив за ' . get_the_date( 'Y' ) . ' год';
      } elseif ( is_month() ) {
          echo 'Архив за ' . get_the_date( 'F Y' );
      } else {
          echo 'Архив';
      }
      ?>
    </h1>
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

  <div class="pagination">
    <?php posts_nav_link(); ?>
  </div>
<?php else: ?>
  <p>Записей не найдено.</p>
<?php endif; ?>
  </div>
  <?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>