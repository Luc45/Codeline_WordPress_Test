<?php
/**
 * @package unite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-film'); ?>>
    <header class="entry-header col-md-4">

        <div class="movie-poster">
            <?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail( 'films-archive' );
                } else {
                    echo '<img src="'.wp_get_attachment_url(17).'">';
                }
            ?>
        </div>

    </header><!-- .entry-header -->

    <div class="entry-content col-md-8">
        <h1 class="entry-title "><?php the_title(); ?></h1>

        <?php the_content(); ?>

        <ul class="film-data">
            <?php
                # Gets ACF Fields
                $ticket_price = get_field('ticket_price');
                $release_date = get_field('release_date');

                # Let's do a single database query for the taxonomies
                $taxonomies = wp_get_post_terms(get_the_ID(), array('actor', 'genre', 'country', 'release_year'));

                # And then separate it programatically
                $actors = implode(', ', get_from_taxonomy($taxonomies, 'actor'));
                $genres = implode(', ', get_from_taxonomy($taxonomies, 'genre'));
                $countries = implode(', ', get_from_taxonomy($taxonomies, 'country'));
                $release_year = implode(', ', get_from_taxonomy($taxonomies, 'release_year'));

                # Displays ACF Fields
                if ($ticket_price) echo '<li><strong>Ticket Price:</strong> U$ '.$ticket_price.'</li>';
                if ($release_date) echo '<li><strong>Release Date:</strong> '.$release_date.'</li>';

                # Display Taxonomies
                if (!empty($actors)) echo '<li><strong>Actors:</strong> '.$actors.'</li>';
                if (!empty($genres)) echo '<li><strong>Genres:</strong> '.$genres.'</li>';
                if (!empty($countries)) echo '<li><strong>Countries:</strong> '.$countries.'</li>';
                if (!empty($release_year)) echo '<li><strong>Year:</strong> '.$release_year.'</li>';
            ?>
        </ul>
        <?php
            wp_link_pages( array(
                'before' => '<div class="page-links">' . __( 'Pages:', 'unite' ),
                'after'  => '</div>',
            ) );
        ?>
    </div><!-- .entry-content -->


    <footer class="entry-meta" style="clear:both">
        <?php
            /* translators: used between list items, there is a space after the comma */
            $category_list = get_the_category_list( __( ', ', 'unite' ) );

            /* translators: used between list items, there is a space after the comma */
            $tag_list = get_the_tag_list( '', __( ', ', 'unite' ) );

            if ( ! unite_categorized_blog() ) {
                // This blog only has 1 category so we just need to worry about tags in the meta text
                if ( '' != $tag_list ) {
                    $meta_text = '<i class="fa fa-folder-open-o"></i> %2$s. <i class="fa fa-link"></i> <a href="%3$s" rel="bookmark">permalink</a>.';
                } else {
                    $meta_text = '<i class="fa fa-link"></i> <a href="%3$s" rel="bookmark">permalink</a>.';
                }

            } else {
                // But this blog has loads of categories so we should probably display them here
                if ( '' != $tag_list ) {
                    $meta_text = '<i class="fa fa-folder-open-o"></i> %1$s <i class="fa fa-tags"></i> %2$s. <i class="fa fa-link"></i> <a href="%3$s" rel="bookmark">permalink</a>.';
                } else {
                    $meta_text = '<i class="fa fa-folder-open-o"></i> %1$s. <i class="fa fa-link"></i> <a href="%3$s" rel="bookmark">permalink</a>.';
                }

            } // end check for categories on this blog

            printf(
                $meta_text,
                $category_list,
                $tag_list,
                get_permalink()
            );
        ?>

        <?php edit_post_link( __( 'Edit', 'unite' ), '<i class="fa fa-pencil-square-o"></i><span class="edit-link">', '</span>' ); ?>
        <?php unite_setPostViews(get_the_ID()); ?>
        <hr class="section-divider">
    </footer><!-- .entry-meta -->
</article><!-- #post-## -->
