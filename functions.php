<?php

define('HOMEPAGE__CPT_ARCHIVE', 'note');
define('NAV_CLASS', 'primary-menu');


/**
 * groundwork-2 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package groundwork-2
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function groundwork_2_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on groundwork-2, use a find and replace
		* to change 'groundwork-2' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'groundwork-2', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'groundwork-2' ),
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
			'groundwork_2_custom_background_args',
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
add_action( 'after_setup_theme', 'groundwork_2_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function groundwork_2_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'groundwork_2_content_width', 640 );
}
add_action( 'after_setup_theme', 'groundwork_2_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function groundwork_2_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'groundwork-2' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'groundwork-2' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'groundwork_2_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function groundwork_2_scripts() {
	wp_enqueue_style( 'groundwork-2-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'groundwork-2-style', 'rtl', 'replace' );

	wp_enqueue_script( 'groundwork-2-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'groundwork_2_scripts' );

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



/*	UTILITIES
		=========
		These functions provide basic theme machinery, and are used by other functions.
*/


function cfg($setting, $get_value = false, $default = '') {

	//	First: Is the setting even defined - that is, present in the config file?
	if (defined($setting)) {

		//	Okay, it's in settings, but is it true?
		if(constant($setting)) {

			//	And finally, do we need to know what its value actually is - say, if it's a string?
			if($get_value) {
				return constant($setting);
			}
			else {
				return true;
			}
		}
		else return false;
	}
	//  If the setting isn't present, but a default value was provided,
	//  return that default value.
	else if ($default !== '') {
		return $default;
	}
	//  No setting is defined, and no default value is specified
	else {
		return false;
	}
}




/*	POSTS
		===== */

function css() {
	
}


/*	DEV STUFF
		========= */

/*	Filters
		------- */






/*	ARCHIVE PAGES
		============= */

// https://wpdevdesign.com/how-to-remove-archive-category-etc-pre-title-inserts-in-archive-titles/

add_filter( 'get_the_archive_title', 'my_theme_archive_title' );
/**
 * Remove archive labels.
 *
 * @param  string $title Current archive title to be displayed.
 * @return string        Modified archive title to be displayed.
 */
function my_theme_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( cfg( 'ARCHIVE__CAT_PREFIX', true, '' ), false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( cfg( 'ARCHIVE__TAG_PREFIX', true, '' ), false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( cfg( 'ARCHIVE__POSTTYPE_PREFIX', true, '' ), false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    }

    return '<h1 class="u-pageTitle archives__title">'.$title.'</h1>';
}



//	https://gretathemes.com/guides/remove-category-title-category-pages/
function prefix_category_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    }
    return $title;
}
add_filter( 'get_the_archive_title', 'prefix_category_title' );


function translate_archive_month($list) {

	$patterns = array(
	'/January/', '/February/', '/March/', '/April/', '/May/', '/June/',
	'/July/', '/August/', '/September/', '/October/',  '/November/', '/December/'
	);

	$replacements = array( //PUT HERE WHATEVER YOU NEED
	'01.', '02.', '03.', '04.', '05.', '06.',
	'07.', '08.', '09.', '10.', '11.', '12.'
	);

	$list = preg_replace($patterns, $replacements, $list);
	return $list;
}
add_filter('get_archives_link', 'translate_archive_month');





/*
	In case you want the homepage to feature a
	listing of custom posts


if( cfg('HOMEPAGE__CPT_ARCHIVE', true ) ) {

	// https://wordpress.stackexchange.com/questions/30851/how-to-use-a-custom-post-type-archive-as-front-page
	add_action("pre_get_posts", "custom_front_page");

	function custom_front_page($wp_query){
	  //Ensure this filter isn't applied to the admin area
	  if(is_admin()) {
	      return;
	  }

	  if($wp_query->get('page_id') == get_option('page_on_front')):

	      $wp_query->set('post_type', cfg('HOMEPAGE__CPT_ARCHIVE', true ));
	      $wp_query->set('page_id', ''); //Empty

	      //Set properties that describe the page to reflect that
	      //we aren't really displaying a static page
	      $wp_query->is_page = 0;
	      $wp_query->is_singular = 0;
	      $wp_query->is_post_type_archive = 1;
	      $wp_query->is_archive = 1;

	  endif;
	}
}
*/









function be_dps_template_part( $output, $original_atts ) {

	// Return early if our "layout" attribute is not specified
	if( empty( $original_atts['layout'] ) )
		return $output;
	ob_start();
	get_template_part( 'partials/dps', $original_atts['layout'] );
	$new_output = ob_get_clean();
	if( !empty( $new_output ) )
		$output = $new_output;
	return $output;
}
add_action( 'display_posts_shortcode_output', 'be_dps_template_part', 10, 2 );
