<?php
 
/* Load Necessary PHP Files
-------------------------------------------------------------------------------- */
add_action( 'rocktree_init', 'rocktree_load_functions' );

function rocktree_load_functions() {
	
	// Directory Constants
	define( 'RT_LIBRARY_DIR', get_template_directory() . '/library' );	
		 
	// admin
	require_once( RT_LIBRARY_DIR . '/admin/theme-options.php' );
	require_once( RT_LIBRARY_DIR . '/admin/page-meta.php' );
	
	// content
	require_once( RT_LIBRARY_DIR . '/content/content.php' );
	require_once( RT_LIBRARY_DIR . '/content/sidebars.php' );
	
	// plugins
	require_once( RT_LIBRARY_DIR . '/plugins/features/features.php' ); // all other feature functions are called from features.php
	
	// widgets
	require_once( RT_LIBRARY_DIR . '/widgets/info-tile.php' );
	require_once( RT_LIBRARY_DIR . '/widgets/social-links.php' );
	
}

/* Registration
-------------------------------------------------------------------------------- */
add_action( 'rocktree_init', 'rocktree_registration' );

function rocktree_registration() {
 
	// Custom Menus
	add_action( 'init', 'register_my_menu' );
	 
	function register_my_menu() {
		register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
		register_nav_menu( 'footer-menu', __( 'Footer Menu' ) );
	}
	
	// Post Thumbnails
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 200, 200 ); // Normal post thumbnails
		add_image_size( 'blog-home-thumbnail', 200, 200 ); // Permalink thumbnail size 'blog-home-thumbnail' sets img class
	}
	
	// Enable post and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	//Enable multisite feature (WordPress 3.0)
	define('WP_ALLOW_MULTISITE', true);

}


/* Initialize Theme (hooks to functions above)
-------------------------------------------------------------------------------- */
do_action( 'rocktree_init' );



/*********************************************************************************/
/*********************************************************************************/



// WP Built-In Hooks --->

/* Scripts  & Styles
-------------------------------------------------------------------------------- */
// Animation of main menu
add_action( 'wp_enqueue_scripts', 'load_main_menu_scripts' );	
function load_main_menu_scripts() {
	wp_enqueue_script('hover-control', get_template_directory_uri() . '/library/js/hover-control.js',array('jquery') );
	wp_enqueue_script('footer', get_template_directory_uri() . '/library/js/footer.js',array('jquery') );
	wp_enqueue_script('main-menu', get_template_directory_uri() . '/library/js/main-menu.js',array('jquery') );
}

// Admin scripts. These only run when on admin site.
if( isset($_GET['page']) && $_GET['page'] == 'rt_theme_options' ) add_action( 'admin_enqueue_scripts', 'rt_load_admin_scripts' );	
function rt_load_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	wp_enqueue_script( 'theme-options', get_template_directory_uri() . '/library/admin/theme-options.js', array('jquery','media-upload','thickbox') );
	wp_enqueue_style( 'theme-options', get_template_directory_uri() . '/library/admin/theme-options.css' );	
}

/* Widgets 
-------------------------------------------------------------------------------- */
add_action( 'widgets_init', 'load_widgets' );

function load_widgets() {
	register_widget( 'Info_Tile' );
	register_widget( 'Social_Links' );
}

//Initialize the update checker.
require get_template_directory() . '/library/admin/theme-update-checker.php';
$example_update_checker = new ThemeUpdateChecker(
    'buckeye',
    'http://thepolymathlab.com/theme-updates/buckeye-theme-update-checker.json'
);

?>