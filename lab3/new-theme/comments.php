<?php
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">
  <?php if ( have_comments() ) : ?>
    <h2 class="comments-title">
      <?php
        printf(
          _n( 'Один комментарий', '%s комментариев', get_comments_number(), 'new-theme' ),
          number_format_i18n( get_comments_number() )
        );
      ?>
    </h2>

    <ol class="comment-list">
      <?php wp_list_comments(); ?>
    </ol>
  <?php endif; ?>

  <?php if ( comments_open() ) : ?>
    <?php comment_form(); ?>
  <?php endif; ?>
</div>
