<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo('name'); ?></title>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <header class="site-header">
    <?php if ( is_front_page() ) : ?>
  <h1>Добро пожаловать на сайт WordPressLab!</h1>
<?php else : ?>
    <h1><?php bloginfo('name'); ?></h1>
    <p><?php bloginfo('description'); ?></p>

<?php endif; ?>
  </header>

   <!-- Вывод навигационного меню -->
  <nav class="main-navigation">
    <?php
      wp_nav_menu( array(
        'theme_location' => 'header-menu', 
      ) );
    ?>
  </nav>