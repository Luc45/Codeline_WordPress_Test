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

function dd($a){echo '<pre>';var_dump($a);echo '</pre>';exit;}

/**
*   Returns a specific taxonomy from a list of taxonomies
*
*   @param array $taxonomies Array of all taxonomies from a post
*   @param string $retrieve Specific taxonomy we want to retrieve
*   @param bool $return_only_values If true, returns an array with only the values from that taxonomy
*   @return array
*/
function get_from_taxonomy(array $taxonomies, string $retrieve, bool $return_only_values = true) {
    $values = array();
    foreach ($taxonomies as $key => $taxonomy) {
        if (get_class($taxonomy) == "WP_Term" && property_exists($taxonomy, 'taxonomy')) {

            # Removes unwanted taxonomies from the taxonomies array
            if ($taxonomy->taxonomy !== $retrieve) {
                unset($taxonomies[$key]);
            } else {
                # This taxonomy is what we want to retrieve. Do we want only values?
                if ($return_only_values) $values[] = $taxonomy->name;
            }

        }
    }
    if ($return_only_values) return $values;
    return $taxonomies;
}
