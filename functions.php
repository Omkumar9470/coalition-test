<?php
/**
 * CT Custom functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package CT_Custom
 */

if ( ! function_exists( 'ct_custom_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ct_custom_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on CT Custom, use a find and replace
		 * to change 'ct-custom' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ct-custom', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'ct-custom' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'ct_custom_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'ct_custom_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ct_custom_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ct_custom_content_width', 640 );
}
add_action( 'after_setup_theme', 'ct_custom_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ct_custom_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ct-custom' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ct-custom' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'ct_custom_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ct_custom_scripts() {
	wp_enqueue_style( 'ct-custom-style', get_stylesheet_uri() );

	wp_enqueue_script( 'ct-custom-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'ct-custom-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_custom_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
// 1. Register Navigation Menu
function coalition_register_menus() {
    register_nav_menus( array(
        'primary-menu' => __( 'Primary Menu', 'textdomain' ),
    ) );
}
add_action( 'init', 'coalition_register_menus' );

// 2. Add Theme Options Page to Admin Sidebar
function coalition_add_theme_settings_page() {
    add_menu_page( 'Theme Settings', 'Theme Settings', 'manage_options', 'coalition-theme-settings', 'coalition_render_theme_settings_page', 'dashicons-admin-generic', 60 );
}
add_action( 'admin_menu', 'coalition_add_theme_settings_page' );

// 3. Register Settings via WP Settings API
function coalition_register_settings() {
    $settings = array( 'coalition_logo', 'coalition_phone', 'coalition_address', 'coalition_fax', 'coalition_social_facebook', 'coalition_social_twitter' );
    foreach ( $settings as $setting ) { 
        register_setting( 'coalition_settings_group', $setting ); 
    }
}
add_action( 'admin_init', 'coalition_register_settings' );

// 4. Enqueue WP Media Uploader Scripts
function coalition_admin_scripts( $hook ) {
    if ( 'toplevel_page_coalition-theme-settings' !== $hook ) return;
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'coalition_admin_scripts' );

// 5. Render Admin Settings Page
function coalition_render_theme_settings_page() {
    ?>
    <div class="wrap">
        <h1>Coalition Theme Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'coalition_settings_group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Header Logo</th>
                    <td>
                        <?php $logo = get_option( 'coalition_logo' ); ?>
                        <input type="hidden" id="coalition_logo" name="coalition_logo" value="<?php echo esc_attr( $logo ); ?>" />
                        <div id="logo-preview-container" style="margin-bottom: 10px;">
                            <?php if ( $logo ) : ?><img src="<?php echo esc_url( $logo ); ?>" style="max-width: 150px;" /><?php endif; ?>
                        </div>
                        <input type="button" class="button" id="coalition_logo_upload_btn" value="Upload Logo" />
                    </td>
                </tr>
                <tr valign="top"><th scope="row">Phone Number</th><td><input type="text" name="coalition_phone" value="<?php echo esc_attr( get_option( 'coalition_phone' ) ); ?>" class="regular-text" /></td></tr>
                <tr valign="top"><th scope="row">Address</th><td><textarea name="coalition_address" rows="3" class="regular-text"><?php echo esc_textarea( get_option( 'coalition_address' ) ); ?></textarea></td></tr>
                <tr valign="top"><th scope="row">Fax Number</th><td><input type="text" name="coalition_fax" value="<?php echo esc_attr( get_option( 'coalition_fax' ) ); ?>" class="regular-text" /></td></tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('#coalition_logo_upload_btn').click(function(e) {
                e.preventDefault();
                var uploader = wp.media({ title: 'Select Logo', button: { text: 'Use Logo' }, multiple: false })
                .on('select', function() {
                    var attachment = uploader.state().get('selection').first().toJSON();
                    $('#coalition_logo').val(attachment.url);
                    $('#logo-preview-container').html('<img src="' + attachment.url + '" style="max-width:150px;" />');
                }).open();
            });
        });
    </script>
    <?php
}