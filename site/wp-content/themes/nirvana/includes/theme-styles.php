<?php
/*
 * Styles and scripts registration and enqueuing
 *
 * @package nirvana
 * @subpackage Functions
 */

/* = Loading CSS
--------------------------------------*/
 
/* Enqueue all styles */
function nirvana_enqueue_styles() {
	global $nirvanas;
	foreach ($nirvanas as $key => $value) { ${"$key"} = $value ;}

	wp_enqueue_style( 'nirvanas', get_stylesheet_uri() ); //style.css
	/* Google fonts */
	if($nirvana_googlefont) wp_enqueue_style( 'nirvana_googlefont', esc_attr("//fonts.googleapis.com/css?family=".preg_replace( '/\s+/', '+', $nirvana_googlefont )));
	if($nirvana_googlefonttitle) wp_enqueue_style( 'nirvana_googlefonttitle', esc_attr("//fonts.googleapis.com/css?family=".preg_replace( '/\s+/', '+',$nirvana_googlefonttitle )));
	if($nirvana_googlefontside) wp_enqueue_style( 'nirvana_googlefontside',esc_attr("//fonts.googleapis.com/css?family=".preg_replace( '/\s+/', '+',$nirvana_googlefontside )));
	if($nirvana_headingsgooglefont) wp_enqueue_style( 'nirvana_headingsgooglefont', esc_attr("//fonts.googleapis.com/css?family=".preg_replace( '/\s+/', '+',$nirvana_headingsgooglefont )));
	if($nirvana_sitetitlegooglefont) wp_enqueue_style( 'nirvana_sitetitlegooglefont', esc_attr("//fonts.googleapis.com/css?family=".preg_replace( '/\s+/', '+',$nirvana_sitetitlegooglefont )));
	if($nirvana_menugooglefont) wp_enqueue_style( 'nirvana_menugooglefont', esc_attr("//fonts.googleapis.com/css?family=".preg_replace( '/\s+/', '+',$nirvana_menugooglefont )));
}

add_action('wp_head', 'nirvana_enqueue_styles', 5 ); 

/* Enqueue all custom styles */
function nirvana_styles_echo() {
	global $nirvanas;
	foreach ($nirvanas as $key => $value) { ${"$key"} = $value ;}
	
	echo preg_replace("/[\n\r\t\s]+/"," " ,nirvana_custom_styles())."\n"; // Custom-styles.php
	if ($nirvana_frontpage == "Enable" && is_front_page() && 'posts' == get_option( 'show_on_front' ) ) { echo preg_replace("/[\n\r\t\s]+/"," " ,nirvana_presentation_css())."\n";} // PP styles also in custom-styles.php
	echo preg_replace("/[\n\r\t\s]+/"," " ,nirvana_customcss())."\n"; // User custom CSS
}
add_action('wp_head', 'nirvana_styles_echo', 20);

/* Enqueue PP styles */
function nirvana_enqueue_frontpage() {
	global $nirvanas;
	foreach ($nirvanas as $key => $value) { ${"$key"} = $value ;}
	if (($nirvana_frontpage=="Enable") && is_front_page() && 'posts' == get_option( 'show_on_front' )) {  wp_enqueue_style( 'nirvana-frontpage', get_template_directory_uri() . '/styles/style-frontpage.css' ); }
}
add_action('wp_head', 'nirvana_enqueue_frontpage', 21 );


/* Enqueue mobile styles */
function nirvana_load_mobile_css() {
	global $nirvanas;
	foreach ($nirvanas as $key => $value) {${"$key"} = $value ;}
	if ($nirvana_mobile=="Enable") { wp_enqueue_style( 'nirvana-mobile', get_template_directory_uri() . '/styles/style-mobile.css' );}
}
add_action ('wp_head','nirvana_load_mobile_css', 30);

/* = Loading JS
--------------------------------------*/

// User Custom JS
add_action('wp_head', 'nirvana_customjs', 35 );

// Scripts loading and hook into wp_enque_scripts
function nirvana_scripts_method() {
global $nirvanas;
foreach ($nirvanas as $key => $value) {
									${"$key"} = $value ;
									}
// If frontend - load the js for the menu and the social icons animations
	if ( !is_admin() ) {
		wp_enqueue_script('cryout-frontend',get_template_directory_uri() . '/js/frontend.js', array('jquery') );
  		// If nirvana front page is enabled and the current page is home page - load the nivo slider js
		if ($nirvana_frontpage == "Enable" && is_front_page()) {
			wp_enqueue_script('cryout-nivoSlider',get_template_directory_uri() . '/js/nivo-slider.js', array('jquery'));
			add_action('wp_head', 'nirvana_pp_slider' ); // add slider js

		}
  	}

	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}
if( !is_admin() ) { add_action('wp_enqueue_scripts', 'nirvana_scripts_method'); }
?>