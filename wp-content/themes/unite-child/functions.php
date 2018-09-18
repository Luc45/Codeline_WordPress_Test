<?php
# Register style.css for Child-Theme
function register_child_style() {
    $parent_style="unite-style";
    wp_enqueue_style($parent_style, get_template_directory_uri().'/style.css');
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        filemtime(get_stylesheet_directory() . '/style.css')
    );
}
add_action('wp_enqueue_scripts','register_child_style', PHP_INT_MAX);

# Image sizes for films archive
add_image_size('films-archive', 220, 310, false);
add_image_size('films-archive-crop', 220, 310, true);

add_image_size('films-archive-half', 110, 155, false);
add_image_size('films-archive-half-crop', 110, 155, true);

# Debug function
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


/**
 * Our own version of "unite_post_nav function". Display navigation to next/previous film when applicable.
 *
 * @return void
 */
function unite_post_nav_films() {
    // Don't print empty markup if there's nowhere to navigate.
    $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous ) {
        return;
    }
    $previous_thumbnail = get_the_post_thumbnail( $previous->ID, 'films-archive-half' );
    $next_thumbnail = get_the_post_thumbnail( $next->ID, 'films-archive-half' );
    $next_class = empty($previous) ? '' : 'text-right';
    ?>
    <nav class="navigation post-navigation" role="navigation">
        <h3 class="screen-reader-text"><?php _e( 'More films', 'unite' ); ?></h3>
        <div class="nav-links">
            <?php
                previous_post_link( '<div class="nav-previous col-xs-6">%link</div>', _x( $previous_thumbnail.'<br><i class="fa fa-chevron-left"></i> %title', 'Previous post link', 'unite' ) );
                next_post_link(     '<div class="nav-next col-xs-6 '.$next_class.'">%link</div>',     _x( $next_thumbnail.'<br>%title <i class="fa fa-chevron-right"></i>', 'Next post link',     'unite' ) );
            ?>
        </div><!-- .nav-links -->
    </nav><!-- .navigation -->
    <?php
}

/**
*   Shortcode to display latest films
*/
function latest_films_shortcode() {
    $films = get_posts(array(
        'post_type' => 'films',
        'numberposts' => 5
    ));
    ob_start();
    ?>
        <div class="latest-films-shortcode">
            <h3 class="widget-title"><?=__('Latest Films', 'unite-child')?></h3>
            <ul>
                <?php foreach($films as $film):?>
                    <li>
                        <a href="<?=get_post_permalink($film->ID);?>">
                            <div class="film-shortcode-img">
                                <?php
                                    if (has_post_thumbnail($film->ID)) {
                                        echo get_the_post_thumbnail( $film->ID, 'films-archive-half' );
                                    } else {
                                        echo '<img src="'.wp_get_attachment_url(17).'">';
                                    }
                                ?>
                            </div>
                            <div class="film-shortcode-data">
                                <div class="film-title"><?=$film->post_title?></div>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'latest_films', 'latest_films_shortcode' );
