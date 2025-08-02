<?php
/**
 *CCSO functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @packageCCSO
 */

if ( ! defined( 'ccso_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'ccso_VERSION', '1.0.1' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ccso_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based onCCSO, use a find and replace
		* to change 'ccso' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'ccso', get_template_directory() . '/languages' );

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
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary', 'ccso' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'ccso_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'ccso_setup' );


function wpse_edit_footer() {
    add_filter( 'admin_footer_text', 'wpse_edit_text', 11 );
}
function wpse_edit_text($content) {
    return "Designed and Developed by Aiden Johnson | TGM.One";
}
add_action( 'admin_init', 'wpse_edit_footer' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ccso_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ccso_content_width', 640 );
}
add_action( 'after_setup_theme', 'ccso_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ccso_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'ccso' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'ccso' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'ccso_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ccso_scripts() {
	wp_enqueue_style('ccso-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('cmi-magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css');
    wp_enqueue_style('slick', get_template_directory_uri() . '/assets/css/slick.css');
    wp_enqueue_style('ccso-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css');
    wp_enqueue_style('ccso-style', get_stylesheet_uri());
    wp_enqueue_style('ccso-color', get_template_directory_uri() . '/assets/css/color-font.css');
    wp_enqueue_style('ccso-responsive', get_template_directory_uri() . '/assets/css/responsive.css');
    wp_enqueue_script('ccso-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '6', true);
    wp_enqueue_script('slick', get_template_directory_uri() . '/assets/js/slick.min.js', array('jquery'), '1.0.4', true);
    wp_enqueue_script('magnific', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), '6', true);
	wp_enqueue_style( 'ccso-style', get_stylesheet_uri(), array(), ccso_VERSION );
	wp_style_add_data( 'ccso-style', 'rtl', 'replace' );

	wp_enqueue_style('dashicons');

	wp_enqueue_script( 'ccso-navigation', get_template_directory_uri() . '/js/navigation.js', array(), ccso_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ccso_scripts' );

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

// /**
// Register Custom Navigation Walker
//  */
require_once get_template_directory() . '/inc/wp_bootstrap_navwalker.php';

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

function rd_duplicate_post_link( $actions, $post ) {
    if (current_user_can('edit_posts')) {
        $actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce') . '" title="Duplicate this post" rel="permalink">Duplicate</a>';
    }
    return $actions;
}
add_filter('post_row_actions', 'rd_duplicate_post_link', 10, 2);
add_filter('page_row_actions', 'rd_duplicate_post_link', 10, 2);
function rd_duplicate_post_as_draft(){
    global $wpdb;

    // Check for nonce and current user capabilities
    if (!(isset($_GET['post']) || isset($_POST['post']) || (isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action']))) {
        wp_die('No post to duplicate has been supplied!');
    }

    // Get the original post id
    $post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);

    // Get the original post object
    $post = get_post($post_id);

    // Create a new post object
    $new_post = array(
        'post_title' => $post->post_title . ' (Copy)',
        'post_content' => $post->post_content,
        'post_excerpt' => $post->post_excerpt,
        'post_status' => 'draft',
        'post_type' => $post->post_type,
        'post_author' => $post->post_author,
        'post_category' => wp_get_post_categories($post_id),
    );

    // Insert the new post into the database
    $new_post_id = wp_insert_post($new_post);

    // Copy the taxonomies
    $taxonomies = get_object_taxonomies($post->post_type); 
    foreach ($taxonomies as $taxonomy) {
        $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
        wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
    }

    // Copy the metadata
    $post_meta = get_post_meta($post_id);
    foreach ($post_meta as $meta_key => $meta_values) {
        foreach ($meta_values as $meta_value) {
            add_post_meta($new_post_id, $meta_key, $meta_value);
        }
    }

    // Redirect to the edit screen for the new draft
    wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));
    exit;
}
add_action('admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft');

function disable_theme_file_editor() {
    define('DISALLOW_FILE_EDIT', true);
}
add_action('init', 'disable_theme_file_editor');

function hide_ics_calendar_page() {
    // Check if the current user has a certain capability, for example, 'manage_options'
    if (!current_user_can('manage_options')) {
        // Remove the ICS Calendar page from the admin menu
        remove_menu_page('ics-calendar');
    }
}
add_action('admin_menu', 'hide_ics_calendar_page', 999);


function custom_post_types() {
	$labels = array( //Set UI labels for Custom Post Type
        'name'                => _x( 'Officer Years', 'Post Type General Name', 'ccso' ),
        'singular_name'       => _x( 'Officer Year', 'Post Type Singular Name', 'ccso' ),
        'menu_name'           => __( 'Officers', 'ccso' ),
        'parent_item_colon'   => __( 'Parent Year', 'ccso' ),
        'all_items'           => __( 'All Years', 'ccso' ),
        'view_item'           => __( 'View Year', 'ccso' ),
        'add_new_item'        => __( 'Add New Year', 'ccso' ),
        'add_new'             => __( 'Add New', 'ccso' ),
        'edit_item'           => __( 'Edit Year', 'ccso' ),
        'update_item'         => __( 'Update Year', 'ccso' ),
        'search_items'        => __( 'Search Year', 'ccso' ),
        'not_found'           => __( 'Not Found', 'ccso' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'ccso' ),
    );
    $args = array( // Set other options for Custom Post Type
        'label'               => __( 'officer', 'ccso' ),
        'description'         => __( 'Executive Boards by Year', 'ccso' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'revisions', 'page-attributes' ),  // Features this CPT supports in Post Editor
        'taxonomies'          => array( ),
		'rewrite'   		  => array( 'slug' => 'officer' ),
        'hierarchical'        => false, //allows for child & parent id's
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
		'menu_icon'           => 'dashicons-buddicons-buddypress-logo',
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
    );
    register_post_type( 'officers', $args );

	$labels = array( //Set UI labels for Custom Post Type
        'name'                => _x( 'Resources', 'Post Type General Name', 'ccso' ),
        'singular_name'       => _x( 'Resource', 'Post Type Singular Name', 'ccso' ),
        'menu_name'           => __( 'Resources', 'ccso' ),
        'parent_item_colon'   => __( 'Parent Resource', 'ccso' ),
        'all_items'           => __( 'All Resources', 'ccso' ),
        'view_item'           => __( 'View Resource', 'ccso' ),
        'add_new_item'        => __( 'Add New Resource', 'ccso' ),
        'add_new'             => __( 'Add New', 'ccso' ),
        'edit_item'           => __( 'Edit Resource', 'ccso' ),
        'update_item'         => __( 'Update Resource', 'ccso' ),
        'search_items'        => __( 'Search Resource', 'ccso' ),
        'not_found'           => __( 'Not Found', 'ccso' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'ccso' ),
    );
    $args = array( // Set other options for Custom Post Type
        'label'               => __( 'resouces', 'ccso' ),
        'description'         => __( 'Resources', 'ccso' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor','revisions', 'page-attributes' ),  // Features this CPT supports in Post Editor
        'taxonomies'          => array( ),
		'rewrite'   		  => array( 'slug' => 'resouce' ),
        'hierarchical'        => false, //allows for child & parent id's
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
		'menu_icon'           => 'dashicons-category',
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
    );
    register_post_type( 'resources', $args );

	$labels = array( //Set UI labels for Custom Post Type
        'name'                => _x( 'Competitions', 'Post Type General Name', 'ccso' ),
        'singular_name'       => _x( 'Competition', 'Post Type Singular Name', 'ccso' ),
        'menu_name'           => __( 'Competitions', 'ccso' ),
        'parent_item_colon'   => __( 'Parent Competition', 'ccso' ),
        'all_items'           => __( 'All Competitions', 'ccso' ),
        'view_item'           => __( 'View Competition', 'ccso' ),
        'add_new_item'        => __( 'Add New Competition', 'ccso' ),
        'add_new'             => __( 'Add New', 'ccso' ),
        'edit_item'           => __( 'Edit Competition', 'ccso' ),
        'update_item'         => __( 'Update Competition', 'ccso' ),
        'search_items'        => __( 'Search Competition', 'ccso' ),
        'not_found'           => __( 'Not Found', 'ccso' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'ccso' ),
    );
    $args = array( // Set other options for Custom Post Type
        'label'               => __( 'competition', 'ccso' ),
        'description'         => __( 'Competitions', 'ccso' ),
        'labels'              => $labels,
        'supports'            => array( 'title','revisions' ),  // Features this CPT supports in Post Editor
        'taxonomies'          => array( ),
		'rewrite'   		  => array( 'slug' => 'competition' ),
        'hierarchical'        => false, //allows for child & parent id's
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
		'menu_icon'           => 'dashicons-flag',
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
    );
    register_post_type( 'competitions', $args );

	$labels = array( //Set UI labels for Custom Post Type
        'name'                => _x( 'Sponsors', 'Post Type General Name', 'ccso' ),
        'singular_name'       => _x( 'Sponsor', 'Post Type Singular Name', 'ccso' ),
        'menu_name'           => __( 'Sponsors', 'ccso' ),
        'parent_item_colon'   => __( 'Parent Sponsor', 'ccso' ),
        'all_items'           => __( 'All Sponsors', 'ccso' ),
        'view_item'           => __( 'View Sponsor', 'ccso' ),
        'add_new_item'        => __( 'Add New Sponsor', 'ccso' ),
        'add_new'             => __( 'Add New', 'ccso' ),
        'edit_item'           => __( 'Edit Sponsor', 'ccso' ),
        'update_item'         => __( 'Update Sponsor', 'ccso' ),
        'search_items'        => __( 'Search Sponsor', 'ccso' ),
        'not_found'           => __( 'Not Found', 'ccso' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'ccso' ),
    );
    $args = array( // Set other options for Custom Post Type
        'label'               => __( 'sponsor', 'ccso' ),
        'description'         => __( 'Sponsors', 'ccso' ),
        'labels'              => $labels,
        'supports'            => array( 'title','revisions' ),  // Features this CPT supports in Post Editor
        'taxonomies'          => array( ),
		'rewrite'   		  => array( 'slug' => 'sponsor' ),
        'hierarchical'        => false, //allows for child & parent id's
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
		'menu_icon'           => 'dashicons-star-filled',
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
    );
    register_post_type( 'sponsors', $args );
}
add_action( 'init', 'custom_post_types', 0 );

function ccso_calendar_shortcode() {
    ob_start();
    ?>
        <div class="container calendar-container">
            <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/calendar.css">
            <div class="row">
                <?php 
                    $calandar = 'https://outlook.office365.com/owa/calendar/cf25a4f7d0204f569b41143580630f05@psu.edu/413a9df4b16a46f58a1788e0389cab3a12905045537426276961/calendar.ics';
                    $calandar_array = r34ics_get_ics_data(array(
                        'limitdays' => 455,
                        'pastdays' => 90,
                        'url' => $calandar,
                        ));
                    $calandar_json = json_encode($calandar_array);
                ?>
                <script>
                    var events = <?php echo $calandar_json; ?>;
                </script>
                <div class="daily-view">
                <div class="day-header">
                    <h2 class="day-header-text">Today</h2>
                </div>
                <div class="day-events">
                    <div class="event">
                    <h3>Event Title</h3>
                    <p>Event Description</p>
                    </div>
                </div>
                </div>
                <div class="monthly-view">
                    <?php echo do_shortcode('[ics_calendar url="'.$calandar.'" view="month" ajax="true" color="#25acb7" compact="true"]'); ?>
                </div>
            </div>
            <script src="<?php echo get_template_directory_uri(); ?>/assets/js/calendar.js"></script>
        </div>
    <?php
    return ob_get_clean();
}
add_shortcode('ccso_calendar', 'ccso_calendar_shortcode');