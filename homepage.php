<?php
/**
 * Template Name: Homepage
 */
get_header();

// Fetch our dynamic theme settings
$logo     = get_option( 'coalition_logo' );
$phone    = get_option( 'coalition_phone' );
$address  = get_option( 'coalition_address' );
$fax      = get_option( 'coalition_fax' );
$facebook = get_option( 'coalition_social_facebook' );
$twitter  = get_option( 'coalition_social_twitter' );
?>

<div class="ct-top-bar">
    <div class="ct-container ct-top-bar-inner">
        <div class="ct-top-phone">
            CALL US NOW! <strong><?php echo esc_html( $phone ); ?></strong>
        </div>
        <div class="ct-top-auth">
            <a href="#">LOGIN</a> <a href="#">SIGNUP</a>
        </div>
    </div>
</div>

<header class="ct-site-header ct-container">
    <div class="ct-logo">
        <?php if ( $logo ) : ?>
            <img src="<?php echo esc_url( $logo ); ?>" alt="Logo">
        <?php else: ?>
            <h1 style="color:#ff6000; margin:0;">YOUR<span style="color:#333;">LOGO</span></h1>
        <?php endif; ?>
    </div>
    <nav class="ct-main-navigation">
        <?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => false ) ); ?>
    </nav>
</header>

<main id="primary" class="site-main ct-container">
    <div class="ct-breadcrumbs">
        Home / Who we are / <strong>Contact</strong>
    </div>

    <section class="ct-page-intro">
        <!-- Outputs the page title and paragraph from the WP Page Editor -->
        <?php
        while ( have_posts() ) : the_post();
            echo '<h2>' . get_the_title() . '</h2>';
            the_content();
        endwhile;
        ?>
    </section>

    <section class="ct-contact-section">
        <div class="ct-contact-left">
            <h3 class="ct-section-title">CONTACT US</h3>
            <!-- Replace '123' with your actual Contact Form 7 ID -->
            <?php echo do_shortcode('[contact-form-7 id="1b4c4e9" title="Contact form 1"]'); ?>
        </div>

        <div class="ct-contact-right">
            <h3 class="ct-section-title ct-reach-us-title">REACH US</h3>
            <div class="ct-address-info">
                <p><strong>Coalition Skills Test</strong><br>
                <?php echo nl2br( esc_html( $address ) ); ?></p>
                <br>
                <p>Phone: <?php echo esc_html( $phone ); ?><br>
                Fax: <?php echo esc_html( $fax ); ?></p>
            </div>
            
            <div class="ct-social-links">
                <?php if($facebook): ?><a href="<?php echo esc_url($facebook); ?>" class="ct-social-icon fb">f</a><?php endif; ?>
                <?php if($twitter): ?><a href="<?php echo esc_url($twitter); ?>" class="ct-social-icon tw">t</a><?php endif; ?>
                <a href="#" class="ct-social-icon in">in</a>
                <a href="#" class="ct-social-icon pi">p</a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>