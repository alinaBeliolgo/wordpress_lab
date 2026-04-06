<?php

// Регистрируем поддержку миниатюр для записей
add_theme_support('post-thumbnails');

function new_theme_register_menus() {
    register_nav_menus( array(
        'header-menu' => __( 'Main Menu', 'new-theme' ),
        'footer-menu' => __( 'Footer Menu', 'new-theme' ),
    ) );
}
add_action( 'after_setup_theme', 'new_theme_register_menus' );


function new_theme_widgets_init() {
    register_sidebar( array(
        'name'          => 'Main Sidebar',
        'id'            => 'sidebar-1',
        'description'   => 'Основная боковая колонка сайта',
        'before_widget' => '<div id="%1$s" class="widget %2$s">', 
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'new_theme_widgets_init' );


function new_theme_enqueue_scripts() {
    wp_enqueue_style( 'new-theme-style', get_stylesheet_uri(), array(), '1.0', 'all' );
    
}
add_action( 'wp_enqueue_scripts', 'new_theme_enqueue_scripts' );