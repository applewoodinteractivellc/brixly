<?php

require_once get_template_directory() . "/inc/vendor/autoload.php";


function brixly_page_builder_components( $components ) {
	$namespace = "BrixlyWP\\Theme\\BuilderComponents";

	$components = array_merge( $components, array(

		'css'                => "{$namespace}\\CSSOutput",

		// header components
		'header'             => "{$namespace}\\Header",

		// footer components
		'footer'             => "{$namespace}\\Footer",

		// page content
		'main'               => "{$namespace}\\MainContent",
		'single'             => "{$namespace}\\SingleContent",
		'content'            => "{$namespace}\\PageContent",
		'front-page-content' => "{$namespace}\\FrontPageContent",
		// sidebar
		'sidebar'            => "{$namespace}\\Sidebar",
		// 404
		'page-not-found'     => "{$namespace}\\PageNotFound",

	) );

	return $components;
}

function brixly_default_components( $components ) {

	$namespace = "BrixlyWP\\Theme\\Components";

	$components = array_merge( $components, array(

		// header components
		'header'               => "{$namespace}\\Header",
		'logo'                 => "{$namespace}\\Header\\Logo",
		'header-menu'          => "{$namespace}\\Header\\HeaderMenu",

		// inner page fragments
		'inner-nav-bar'        => "{$namespace}\\InnerHeader\\NavBar",
		'inner-top-bar'        => "{$namespace}\\InnerHeader\\TopBar",
		'inner-hero'           => "{$namespace}\\InnerHeader\\Hero",
		'inner-title'          => "{$namespace}\\InnerHeader\\Title",

		// front page fragments
		'front-hero'           => "{$namespace}\\FrontHeader\\Hero",
		'front-title'          => "{$namespace}\\FrontHeader\\Title",
		'front-subtitle'       => "{$namespace}\\FrontHeader\\Subtitle",
		'front-buttons'        => "{$namespace}\\FrontHeader\\ButtonsGroup",
		'top-bar-list-icons'   => "{$namespace}\\FrontHeader\\TopBarListIcons",
		'top-bar-social-icons' => "{$namespace}\\FrontHeader\\TopBarSocialIcons",
		'front-nav-bar'        => "{$namespace}\\FrontHeader\\NavBar",
		'front-top-bar'        => "{$namespace}\\FrontHeader\\TopBar",
		'front-image'          => "{$namespace}\\FrontHeader\\Image",


		// footer components
		'footer'               => "{$namespace}\\Footer",
		'front-footer'         => "{$namespace}\\Footer\\FrontFooter",

		// general components
		'css'                  => "{$namespace}\\CSSOutput",

		// page content
		'main'                 => "{$namespace}\\MainContent",
		'single'               => "{$namespace}\\SingleContent",
		'content'              => "{$namespace}\\PageContent",
		'front-page-content'   => "{$namespace}\\FrontPageContent",
		'search'               => "{$namespace}\\PageSearch",
		'page-not-found'       => "{$namespace}\\PageNotFound",

		// inner content fragments

		//main content
		'main-loop'            => "{$namespace}\\MainContent\ArchiveLoop",
		'post-loop'            => "{$namespace}\\MainContent\PostLoop",
		'archive-loop'         => "{$namespace}\\MainContent\ArchiveLoop",
		'single-template'      => "{$namespace}\\MainContent\SingleItemTemplate",

		// sidebar
		'sidebar'              => "{$namespace}\\Sidebar",
	) );

	return $components;
}

function brixly_register_components( $components = array() ) {
	if ( apply_filters( 'brixly_page_builder/installed', false ) ) {
		$components = brixly_page_builder_components( $components );
	} else {
		$components = brixly_default_components( $components );
	}

	return $components;
}

\BrixlyWP\Theme\Core\Hooks::brixly_add_action( 'components', 'brixly_register_components' );
\BrixlyWP\Theme\Theme::load();


/**
 * @return \BrixlyWP\Theme\Theme
 */
function brixly_theme() {
	return \BrixlyWP\Theme\Theme::getInstance();
}


/**
 * @return \BrixlyWP\Theme\AssetsManager
 */
function brixly_assets() {
	return brixly_theme()->getAssetsManager();
}


brixly_theme()
	->add_theme_support( 'automatic-feed-links' )
	->add_theme_support( 'title-tag' )
	->add_theme_support( 'post-thumbnails' )
	->add_theme_support( 'custom-logo', array(
		'flex-height' => true,
		'flex-width'  => true,
		'width'       => 150,
		'height'      => 70,
	) )
	->register_menus( array(
		'header-menu' => esc_html__( 'Header Menu', 'brixly' ),
		'footer-menu' => esc_html__( 'Footer Menu', 'brixly' ),
	) )
	->register_sidebars( array(
		array(
			'name'          => esc_html__( 'Blog sidebar widget area', 'brixly' ),
			'id'            => 'brixly-sidebar-1',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widgettitle">',
			'after_title'   => '</h5>',
		),
	) );


if ( ! apply_filters( 'brixly_page_builder/installed', false ) ) {
	brixly_assets()
		->registerTemplateScript(
			"brixly-theme",
			"/theme/theme.js",
			array( 'jquery', 'jquery-effects-slide', 'jquery-effects-core' )
		)
		->registerStylesheet( "brixly-theme", "/theme/theme.css" )
		->addGoogleFont( "Open Sans", array( "300", "400", "600", "700" ) )
		->addGoogleFont(
			"Muli",
			array(
				"300",
				"300italic",
				"400",
				"400italic",
				"600",
				"600italic",
				"700",
				"700italic",
				"900",
				"900italic"
			)
		);
}

\BrixlyWP\Theme\Core\Hooks::brixly_do_action( 'theme_loaded', 'brixly_theme_loaded' );
add_filter( 'brixly_page_builder/theme_supported', '__return_true' );


//blog options

function brixly_show_post_meta_setting_filter( $value ) {

	$value = get_theme_mod( 'blog_post_meta_enabled', $value );

	return ( $value == 1 );
}

add_filter( 'brixly_show_post_meta', 'brixly_show_post_meta_setting_filter' );


function brixly_posts_per_row_setting_filter( $value ) {

	$value = get_theme_mod( 'blog_posts_per_row', $value );

	return $value;
}

add_filter( 'brixly_posts_per_row', 'brixly_posts_per_row_setting_filter' );

function brixly_archive_post_highlight_setting_filter( $value ) {

	$value = get_theme_mod( 'blog_post_highlight_enabled', $value );

	return $value;
}

add_filter( 'brixly_archive_post_highlight', 'brixly_archive_post_highlight_setting_filter' );


function brixly_blog_sidebar_enabled_setting_filter( $value ) {

	$value = get_theme_mod( 'blog_sidebar_enabled', $value );

	return ( $value == 1 );
}

add_filter( 'brixly_blog_sidebar_enabled', 'brixly_blog_sidebar_enabled_setting_filter' );


add_filter( 'brixly_override_with_thumbnail_image', function ( $value ) {
	global $post;

	if ( isset( $post ) && $post->post_type === 'post' ) {
		$value = get_theme_mod( 'blog_show_post_featured_image', true );
		$value = ( intval( $value ) === 1 );
	}

	return $value;
} );


function brixly_is_wporg_preview() {

	if ( defined( 'BRIXLY_IS_WPORG_PREVIEW' ) && BRIXLY_IS_WPORG_PREVIEW ) {
		return BRIXLY_IS_WPORG_PREVIEW;
	}

	$url    = site_url();
	$parse  = parse_url( $url );
	$wp_org = 'wp-themes.com';
	$result = false;

	if ( isset( $parse['host'] ) && $parse['host'] === $wp_org ) {
		$result = true;
	}

	return $result;
}

function brixly_print_archive_entry_class( $class = "" ) {

	$classes = array( "post-list-item", "h-col-xs-12", "space-bottom" );
	$classes = array_merge( $classes, explode( " ", $class ) );
	$classes = get_post_class( $classes );

	$default     = get_theme_mod( 'blog_posts_per_row', \BrixlyWP\Theme\Defaults::get( 'blog_posts_per_row' ) );
	$postsPerRow = max( 1, apply_filters( 'brixly_posts_per_row', $default ) );
	$classes[]   = "h-col-sm-12 h-col-md-" . ( 12 / intval( $postsPerRow ) );

	$classes = apply_filters( 'brixly_archive_entry_class', $classes );

	$classesText = implode( " ", $classes );

	echo esc_attr( $classesText );
}

function brixly_print_masonry_col_class( $echo = false ) {

	global $wp_query;
	$index        = $wp_query->current_post;
	$hasBigClass  = ( is_sticky() || ( $index === 0 && apply_filters( 'brixly_archive_post_highlight', false ) ) );
	$showBigEntry = ( is_archive() || is_home() );

	$class = "";
	if ( $showBigEntry && $hasBigClass ) {
		$class = "col-md-12";
	} else {
		$default     = get_theme_mod( 'blog_posts_per_row', \BrixlyWP\Theme\Defaults::get( 'blog_posts_per_row' ) );
		$postsPerRow = max( 1, apply_filters( 'brixly_posts_per_row', $default ) );
		$class       = "col-sm-12.col-md-" . ( 12 / intval( $postsPerRow ) );
	}

	if ( $echo ) {
		echo esc_attr( $class );

		return;
	}

	return esc_attr( $class );
}


\BrixlyWP\Theme\Core\Hooks::brixly_add_filter( 'info_page_tabs', function ( $tabs ) {

	$tabs['get-started'] = array(
		'title'       => \BrixlyWP\Theme\Translations::translate( 'get_started' ),
		'tab_partial' => "admin/get-started"
	);

	return $tabs;
} );

\BrixlyWP\Theme\Core\Hooks::brixly_add_filter( 'theme_plugins', function ( $plugins ) {
	return array_merge( $plugins, array(
		'brixly-page-builder' => array(
			'name'        => 'Brixly Page Builder',
			'description' => \BrixlyWP\Theme\Translations::translate( 'page_builder_plugin_description' ),
			'source'      => 'http://extendstudio.net/jenkins/dev/brixly-page-builder.zip',
			'plugin_path' => 'brixly-page-builder/brixly-page-builder.php'
		),
		'contact-form-7'       => array(
			'name'        => 'Contact Form 7',
			'description' => \BrixlyWP\Theme\Translations::translate( 'contact_form_plugin_description' )
		),
	) );
} );


add_filter( 'http_request_host_is_external', 'brixly_allow_internal_host', 10, 3 );
function brixly_allow_internal_host( $allow, $host, $url ) {
	if ( $host === 'extendstudio.net' ) {
		$allow = true;
	}

	return $allow;
}

add_action( 'wp_ajax_brixly_front_set_predesign', function () {
	$predesign_index = isset( $_REQUEST['index'] ) ? $_REQUEST['index'] : 0;
	update_option( 'brixly_predesign_front_page_index', intval( $predesign_index ) );
} );

