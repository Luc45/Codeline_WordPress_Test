<?php
# Register style.css for Child-Theme
function register_child_style() {
    $parent_style="unite-style";
    wp_enqueue_style($parent_style, get_template_directory_uri().'/style.css');
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts','register_child_style', PHP_INT_MAX);

# Image sizes for films archive
add_image_size('films-archive', 220, 310, false);
add_image_size('films-archive-crop', 220, 310, true);
