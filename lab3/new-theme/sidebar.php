<aside class="main-sidebar sidebar">

    <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    <?php else : ?>

        <div class="widget">
            <h3 class="widget-title">О сайте</h3>
            <p><?php bloginfo('description'); ?></p>
        </div>

        <div class="widget">
            <h3 class="widget-title">Последние записи</h3>
            <ul>
                <?php
                $recent = wp_get_recent_posts( array('numberposts' => 5) );
                foreach ( $recent as $post ) : ?>
                    <li>
                        <a href="<?php echo get_permalink( $post['ID'] ); ?>">
                            <?php echo $post['post_title']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="widget">
            <h3 class="widget-title">Рубрики</h3>
            <ul>
                <?php wp_list_categories( array('title_li' => '') ); ?>
            </ul>
        </div>

    <?php endif; ?>

</aside>