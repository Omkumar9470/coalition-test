<?php
/**
 * The template for displaying all pages
 */

get_header();
?>

<main id="primary" class="site-main ct-container" style="padding: 40px 20px;">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header" style="margin-bottom: 25px;">
                <h1 class="entry-title" style="color: #ff6000; font-size: 32px;"><?php the_title(); ?></h1>
            </header><!-- .entry-header -->

            <div class="entry-content" style="line-height: 1.8; color: #555;">
                <?php
                the_content();

                wp_link_pages(
                    array(
                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ct-custom' ),
                        'after'  => '</div>',
                    )
                );
                ?>
            </div><!-- .entry-content -->
        </article><!-- #post-<?php the_ID(); ?> -->
        <?php
    endwhile;
    ?>
</main><!-- #primary -->

<?php
get_footer();