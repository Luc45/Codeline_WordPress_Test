<?php
/**
 * @package unite
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 filme'); ?>>
    <header class="entry-header page-header">

        <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
            <?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail( 'films-archive' );
                } else {
                    echo '<img src="'.wp_get_attachment_url(17).'">';
                }
            ?>
            </a>

        <h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

    </header><!-- .entry-header -->

    <div class="entry-content">

        <?php the_excerpt(); ?>

        <?php
            wp_link_pages( array(
                'before' => '<div class="page-links">' . __( 'Pages:', 'unite' ),
                'after'  => '</div>',
            ) );
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-meta">
        <?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
            <?php
                /* translators: used between list items, there is a space after the comma */
                $categories_list = get_the_category_list( __( ', ', 'unite' ) );
                if ( $categories_list && unite_categorized_blog() ) :
            ?>
            <span class="cat-links"><i class="fa fa-folder-open-o"></i>
                <?php printf( __( ' %1$s', 'unite' ), $categories_list ); ?>
            </span>
            <?php endif; // End if categories ?>

            <?php
                /* translators: used between list items, there is a space after the comma */
                $tags_list = get_the_tag_list( '', __( ', ', 'unite' ) );
                if ( $tags_list ) :
            ?>
            <span class="tags-links"><i class="fa fa-tags"></i>
                <?php printf( __( ' %1$s', 'unite' ), $tags_list ); ?>
            </span>
            <?php endif; // End if $tags_list ?>
        <?php endif; // End if 'post' == get_post_type() ?>

        <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
        <span class="comments-link"><i class="fa fa-comment-o"></i><?php comments_popup_link( __( 'Leave a comment', 'unite' ), __( '1 Comment', 'unite' ), __( '% Comments', 'unite' ) ); ?></span>
        <?php endif; ?>

        <?php edit_post_link( __( 'Edit', 'unite' ), '<i class="fa fa-pencil-square-o"></i><span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-meta -->
    <hr class="section-divider">
</article><!-- #post-## -->
