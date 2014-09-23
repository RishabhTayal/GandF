<?php
// Frontend

// Defaults
require_once(get_template_directory() . "/admin/defaults.php");
require_once(get_template_directory() . "/admin/prototypes.php");
// Custom CSS
require_once(get_template_directory() . "/includes/custom-styles.php");

// Admin Side

if( is_admin() ) {
	// Settings arrays
	require_once(get_template_directory() . "/admin/settings.php");
	// Callback functions
	require_once(get_template_directory() . "/admin/admin-functions.php");
	// Sanitize functions
	require_once(get_template_directory() . "/admin/sanitize.php");
	// Color scheme presets
	include(get_template_directory() . "/admin/schemes.php");
}

// Get the theme options and make sure defaults are used if no values are set
function nirvana_get_theme_options() {	
	$optionsNirvana = wp_parse_args( 
		get_option( 'nirvana_settings', array() ), 
		nirvana_get_option_defaults() 
	);
	$optionsNirvana['id'] = "nirvana_settings";
	return $optionsNirvana;
}

// load up theme options
$nirvanas = nirvana_get_theme_options();
foreach ($nirvanas as $key => $value) { ${"$key"} = $value; }

// Hooks/Filters
add_action('admin_init', 'nirvana_init_fn' );
add_action('admin_menu', 'nirvana_add_page_fn');
add_action('init', 'nirvana_init');


// $nirvanas = nirvana_get_theme_options(); // DUPLICATE?

// Register and enqueue all scripts and styles for the init hook
function nirvana_init() {
	// load text domain into the admin section
	load_theme_textdomain( 'nirvana', get_template_directory_uri() . '/languages' );
}

// Create admin subpages
function nirvana_add_page_fn() {
	global $page;
	$page = add_theme_page('Nirvana Settings', 'Nirvana Settings', 'edit_theme_options', 'nirvana-page', 'nirvana_page_fn');
	add_action( 'admin_enqueue_scripts', 'nirvana_admin_scripts' );
}

// Add admin scripts
function nirvana_admin_scripts($hook) {
	global $page;
	if( $page != $hook )
        return;
	/* STYLES */	
	wp_enqueue_style( 'jquery-ui-style', get_template_directory_uri() . '/js/jqueryui/css/ui-lightness/jquery-ui-1.8.16.custom.css' );
	wp_enqueue_style( 'nirvana-admin-style', get_template_directory_uri() . '/admin/css/admin.css' );
	wp_enqueue_style( 'cryout-admin-codemirror-style', get_template_directory_uri() . '/admin/css/codemirror.css' );
	
	/* SCRIPTS */
	// clean up all scripts that may interfere with the theme
	global $wp_scripts;
	$wp_scripts = new WP_Scripts; 
	// restore wp basic scripts
	wp_enqueue_script('jquery');
	wp_enqueue_script('common');
	wp_enqueue_script('admin-bar');
	wp_enqueue_script('utils');
	wp_enqueue_script('wp-auth-check');
	wp_enqueue_script('wp-pointer');
	// end cleanup
	
	// farbtastic color selector already included in WP
	wp_enqueue_script('farbtastic');
	wp_enqueue_style( 'farbtastic' );

	// Jquery accordion and slider libraries already included in WP
    wp_enqueue_script('jquery-ui-accordion');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('jquery-ui-tooltip');
	// Backwards compatibility where theme is installed on older versions of WP where the ui accordion and slider are not included
	if (!wp_script_is('jquery-ui-accordion',$list='registered')) {
		wp_enqueue_script('cryout_accordion',get_template_directory_uri() . '/admin/js/accordion-slider.js', array('jquery') );
	}
    wp_enqueue_media();// WP uploader
	wp_enqueue_script('cryout-admin-js',get_template_directory_uri() . '/admin/js/admin.js' ); // custom theme JS
    wp_enqueue_script('cryout-admin-codemirror-js',get_template_directory_uri() . '/admin/js/codemirror.min.js' ); // codemirror css markup
}

// Settings sections. All the referenced functions are found in admin-functions.php
function nirvana_init_fn(){
	register_setting('nirvana_settings', 'nirvana_settings', 'nirvana_settings_validate');

/**************
   sections
**************/

	add_settings_section('layout_section', __('Layout Settings','nirvana'), 'cryout_section_layout_fn', __FILE__);
	add_settings_section('header_section', __('Header Settings','nirvana'), 'cryout_section_header_fn', __FILE__);
	add_settings_section('presentation_section', __('Presentation Page','nirvana'), 'cryout_section_presentation_fn', __FILE__);
	add_settings_section('text_section', __('Text Settings','nirvana'), 'cryout_section_text_fn', __FILE__);
	add_settings_section('appereance_section',__('Color Settings','nirvana') , 'cryout_section_appereance_fn', __FILE__);
	add_settings_section('graphics_section', __('Graphics Settings','nirvana') , 'cryout_section_graphics_fn', __FILE__);
	add_settings_section('post_section', __('Post Information Settings','nirvana') , 'cryout_section_post_fn', __FILE__);
	add_settings_section('excerpt_section', __('Post Excerpt Settings','nirvana') , 'cryout_section_excerpt_fn', __FILE__);
	add_settings_section('featured_section', __('Featured Image Settings','nirvana') , 'cryout_section_featured_fn', __FILE__);
	add_settings_section('socials_section', __('Social Media Settings','nirvana') , 'cryout_section_social_fn', __FILE__);
	add_settings_section('misc_section', __('Miscellaneous Settings','nirvana') , 'cryout_section_misc_fn', __FILE__);

/*** layout ***/
	add_settings_field('nirvana_side', __('Main Layout','nirvana') , 'cryout_setting_side_fn', __FILE__, 'layout_section');
	add_settings_field('nirvana_sidewidth', __('Content / Sidebar Width','nirvana') , 'cryout_setting_sidewidth_fn', __FILE__, 'layout_section');
	add_settings_field('nirvana_mobile', __('Responsiveness','nirvana') , 'cryout_setting_mobile_fn', __FILE__, 'layout_section');

/*** presentation ***/
	add_settings_field('nirvana_frontpage', __('Enable Presentation Page','nirvana') , 'cryout_setting_frontpage_fn', __FILE__, 'presentation_section');
	add_settings_field('nirvana_frontposts', __('Show Posts on Presentation Page','nirvana') , 'cryout_setting_frontposts_fn', __FILE__, 'presentation_section');
	add_settings_field('nirvana_frontslider', __('Slider Settings','nirvana') , 'cryout_setting_frontslider_fn', __FILE__, 'presentation_section');
	add_settings_field('nirvana_frontslider2', __('Slides','nirvana') , 'cryout_setting_frontslider2_fn', __FILE__, 'presentation_section');
	add_settings_field('nirvana_frontcolumns', __('Columns','nirvana') , 'cryout_setting_frontcolumns_fn', __FILE__, 'presentation_section');
	add_settings_field('nirvana_fronttext', __('Text Areas','nirvana') , 'cryout_setting_fronttext_fn', __FILE__, 'presentation_section');
	add_settings_field('nirvana_frontextras', __('Extras','nirvana') , 'cryout_setting_frontextras_fn', __FILE__, 'presentation_section');

/*** header ***/
	add_settings_field('nirvana_hheight', __('Header Height','nirvana') , 'cryout_setting_hheight_fn', __FILE__, 'header_section');
	add_settings_field('nirvana_himage', __('Header Image','nirvana') , 'cryout_setting_himage_fn', __FILE__, 'header_section');
	add_settings_field('nirvana_siteheader', __('Site Header','nirvana') , 'cryout_setting_siteheader_fn', __FILE__, 'header_section');
	add_settings_field('nirvana_logoupload', __('Custom Logo Upload','nirvana') , 'cryout_setting_logoupload_fn', __FILE__, 'header_section');
	add_settings_field('nirvana_headermargin', __('Header Content Spacing','nirvana') , 'cryout_setting_headermargin_fn', __FILE__, 'header_section');
	add_settings_field('nirvana_favicon', __('FavIcon Upload','nirvana') , 'cryout_setting_favicon_fn', __FILE__, 'header_section');

/*** text ***/
	add_settings_field('nirvana_fontfamily', __('General Font','nirvana') , 'cryout_setting_fontfamily_fn', __FILE__, 'text_section');
	add_settings_field('nirvana_fonttitle', __('Post Title Font ','nirvana') , 'cryout_setting_fonttitle_fn', __FILE__, 'text_section');
	add_settings_field('nirvana_fontside', __('Widget Title Font','nirvana') , 'cryout_setting_fontside_fn', __FILE__, 'text_section');
	add_settings_field('nirvana_fontwidget', __('Widget Font','nirvana') , 'cryout_setting_fontwidget_fn', __FILE__, 'text_section');
	add_settings_field('nirvana_sitetitlefont', __('Site Title Font','nirvana') , 'cryout_setting_sitetitlefont_fn', __FILE__, 'text_section');
	add_settings_field('nirvana_menufont', __('Main Menu Font','nirvana') , 'cryout_setting_menufont_fn', __FILE__, 'text_section');
	add_settings_field('nirvana_fontheadings', __('Headings Font','nirvana') , 'cryout_setting_fontheadings_fn', __FILE__, 'text_section');
	add_settings_field('nirvana_textalign', __('Force Text Align','nirvana') , 'cryout_setting_textalign_fn', __FILE__, 'text_section');
	add_settings_field('nirvana_paragraphspace', __('Paragraph spacing','nirvana') , 'cryout_setting_paragraphspace_fn', __FILE__, 'text_section');
	add_settings_field('nirvana_parindent', __('Paragraph Indent','nirvana') , 'cryout_setting_parindent_fn', __FILE__, 'text_section');
	add_settings_field('nirvana_headingsindent', __('Headings Indent','nirvana') , 'cryout_setting_headingsindent_fn', __FILE__, 'text_section');
	add_settings_field('nirvana_lineheight', __('Line Height','nirvana') , 'cryout_setting_lineheight_fn', __FILE__, 'text_section');
	add_settings_field('nirvana_wordspace', __('Word Spacing','nirvana') , 'cryout_setting_wordspace_fn', __FILE__, 'text_section');
	add_settings_field('nirvana_letterspace', __('Letter Spacing','nirvana') , 'cryout_setting_letterspace_fn', __FILE__, 'text_section');
	add_settings_field('nirvana_letterspace', __('Uppercase Text','nirvana') , 'cryout_setting_uppercasetext_fn', __FILE__, 'text_section');

/*** appereance ***/

    add_settings_field('nirvana_sitebackground', __('Background Image','nirvana') , 'cryout_setting_sitebackground_fn', __FILE__, 'appereance_section');
	add_settings_field('nirvana_generalcolors', __('General','nirvana') , 'cryout_setting_generalcolors_fn', __FILE__, 'appereance_section');
	add_settings_field('nirvana_accentcolors', __('Accents','nirvana') , 'cryout_setting_accentcolors_fn', __FILE__, 'appereance_section');
	add_settings_field('nirvana_titlecolors', __('Site Title','nirvana') , 'cryout_setting_titlecolors_fn', __FILE__, 'appereance_section');
	add_settings_field('nirvana_menucolors', __('Main Menu','nirvana') , 'cryout_setting_menucolors_fn', __FILE__, 'appereance_section');
	add_settings_field('nirvana_topmenucolors', __('Top Bar','nirvana') , 'cryout_setting_topmenucolors_fn', __FILE__, 'appereance_section');
	add_settings_field('nirvana_contentcolors', __('Content','nirvana') , 'cryout_setting_contentcolors_fn', __FILE__, 'appereance_section');
	add_settings_field('nirvana_frontpagecolors', __('Presentation Page','nirvana') , 'cryout_setting_frontpagecolors_fn', __FILE__, 'appereance_section');
	add_settings_field('nirvana_sidecolors', __('Sidebar Widgets','nirvana') , 'cryout_setting_sidecolors_fn', __FILE__, 'appereance_section');
	add_settings_field('nirvana_widgetcolors', __('Footer Widgets','nirvana') , 'cryout_setting_widgetcolors_fn', __FILE__, 'appereance_section');
	add_settings_field('nirvana_linkcolors', __('Links','nirvana') , 'cryout_setting_linkcolors_fn', __FILE__, 'appereance_section');
	add_settings_field('nirvana_metacolors', __('Post metas','nirvana') , 'cryout_setting_metacolors_fn', __FILE__, 'appereance_section');
	add_settings_field('nirvana_socialcolors', __('Socials','nirvana') , 'cryout_setting_socialcolors_fn', __FILE__, 'appereance_section');
	add_settings_field('nirvana_caption', __('Caption type','nirvana') , 'cryout_setting_caption_fn', __FILE__, 'appereance_section');

/*** graphics ***/

	add_settings_field('nirvana_topbar', __('Top Bar','nirvana') , 'cryout_setting_topbar_fn', __FILE__, 'graphics_section');
	add_settings_field('nirvana_breadcrumbs', __('Breadcrumbs','nirvana') , 'cryout_setting_breadcrumbs_fn', __FILE__, 'graphics_section');
	add_settings_field('nirvana_pagination', __('Pagination','nirvana') , 'cryout_setting_pagination_fn', __FILE__, 'graphics_section');
	add_settings_field('nirvana_menualign', __('Menu Alignment','nirvana') , 'cryout_setting_menualign_fn', __FILE__, 'graphics_section');
	add_settings_field('nirvana_searchbar', __('Search Bar Locations','nirvana') , 'cryout_setting_searchbar_fn', __FILE__, 'graphics_section');
	add_settings_field('nirvana_contentmargins', __('Content Margins','nirvana') , 'cryout_setting_contentmargins_fn', __FILE__, 'graphics_section');
	add_settings_field('nirvana_image', __('Post Images Border','nirvana') , 'cryout_setting_image_fn', __FILE__, 'graphics_section');
	add_settings_field('nirvana_pagetitle', __('Page Titles','nirvana') , 'cryout_setting_pagetitle_fn', __FILE__, 'graphics_section');
	add_settings_field('nirvana_categetitle', __('Category Titles','nirvana') , 'cryout_setting_categtitle_fn', __FILE__, 'graphics_section');
	add_settings_field('nirvana_tables', __('Hide Tables','nirvana') , 'cryout_setting_tables_fn', __FILE__, 'graphics_section');
	add_settings_field('nirvana_backtop', __('Back to Top button','nirvana') , 'cryout_setting_backtop_fn', __FILE__, 'graphics_section');

/*** post metas***/
	add_settings_field('nirvana_metapos', __('Meta Bar Position','nirvana') , 'cryout_setting_metapos_fn', __FILE__, 'post_section');
	add_settings_field('nirvana_metashowblog', __('Show on Blog Pages','nirvana') , 'cryout_setting_metashowblog_fn', __FILE__, 'post_section');
	add_settings_field('nirvana_metashowsingle', __('Show on Single Pages','nirvana') , 'cryout_setting_metashowsingle_fn', __FILE__, 'post_section');
	add_settings_field('nirvana_comtext', __('Text Under Comments','nirvana') , 'cryout_setting_comtext_fn', __FILE__, 'post_section');
	add_settings_field('nirvana_comclosed', __('Comments are closed text','nirvana') , 'cryout_setting_comclosed_fn', __FILE__, 'post_section');
	add_settings_field('nirvana_comoff', __('Comments off','nirvana') , 'cryout_setting_comoff_fn', __FILE__, 'post_section');

/*** post exceprts***/
	add_settings_field('nirvana_excerpthome', __('Home Page','nirvana') , 'cryout_setting_excerpthome_fn', __FILE__, 'excerpt_section');
	add_settings_field('nirvana_excerptsticky', __('Sticky Posts','nirvana') , 'cryout_setting_excerptsticky_fn', __FILE__, 'excerpt_section');
	add_settings_field('nirvana_excerptarchive', __('Archive and Category Pages','nirvana') , 'cryout_setting_excerptarchive_fn', __FILE__, 'excerpt_section');
	add_settings_field('nirvana_excerptlength', __('Post Excerpt Length ','nirvana') , 'cryout_setting_excerptlength_fn', __FILE__, 'excerpt_section');
	add_settings_field('nirvana_magazinelayout', __('Magazine Layout','nirvana') , 'cryout_setting_magazinelayout_fn', __FILE__, 'excerpt_section');
	add_settings_field('nirvana_excerptdots', __('Excerpt suffix','nirvana') , 'cryout_setting_excerptdots_fn', __FILE__, 'excerpt_section');
	add_settings_field('nirvana_excerptcont', __('Continue reading link text ','nirvana') , 'cryout_setting_excerptcont_fn', __FILE__, 'excerpt_section');
	add_settings_field('nirvana_excerpttags', __('HTML tags in Excerpts','nirvana') , 'cryout_setting_excerpttags_fn', __FILE__, 'excerpt_section');

/*** featured ***/
	add_settings_field('nirvana_fpost', __('Featured Images as POST Thumbnails ','nirvana') , 'cryout_setting_fpost_fn', __FILE__, 'featured_section');
	add_settings_field('nirvana_fauto', __('Auto Select Images From Posts ','nirvana') , 'cryout_setting_fauto_fn', __FILE__, 'featured_section');
	add_settings_field('nirvana_falign', __('Thumbnails Alignment ','nirvana') , 'cryout_setting_falign_fn', __FILE__, 'featured_section');
	add_settings_field('nirvana_fsize', __('Thumbnails Size ','nirvana') , 'cryout_setting_fsize_fn', __FILE__, 'featured_section');
	add_settings_field('nirvana_fheader', __('Featured Images as HEADER Images ','nirvana') , 'cryout_setting_fheader_fn', __FILE__, 'featured_section');

/*** socials ***/
	add_settings_field('nirvana_socials1', __('Link nr. 1','nirvana') , 'cryout_setting_socials1_fn', __FILE__, 'socials_section');
	add_settings_field('nirvana_socials2', __('Link nr. 2','nirvana') , 'cryout_setting_socials2_fn', __FILE__, 'socials_section');
	add_settings_field('nirvana_socials3', __('Link nr. 3','nirvana') , 'cryout_setting_socials3_fn', __FILE__, 'socials_section');
	add_settings_field('nirvana_socials4', __('Link nr. 4','nirvana') , 'cryout_setting_socials4_fn', __FILE__, 'socials_section');
	add_settings_field('nirvana_socials5', __('Link nr. 5','nirvana') , 'cryout_setting_socials5_fn', __FILE__, 'socials_section');
	add_settings_field('nirvana_socialshow', __('Socials display','nirvana') , 'cryout_setting_socialsdisplay_fn', __FILE__, 'socials_section');

/*** misc ***/
	add_settings_field('nirvana_iecompat', __('Internet Explorer Compatibility Tag','nirvana') , 'cryout_setting_iecompat_fn', __FILE__, 'misc_section');
	add_settings_field('nirvana_copyright', __('Custom Footer Text','nirvana') , 'cryout_setting_copyright_fn', __FILE__, 'misc_section');
	add_settings_field('nirvana_customcss', __('Custom CSS','nirvana') , 'cryout_setting_customcss_fn', __FILE__, 'misc_section');
	add_settings_field('nirvana_customjs', __('Custom JavaScript','nirvana') , 'cryout_setting_customjs_fn', __FILE__, 'misc_section');

}

 // Display the admin options page
function nirvana_page_fn() {
	// Load the import form page if the import button has been pressed
	if (isset($_POST['nirvana_import'])) {
		nirvana_import_form();
		return;
	}
	// Load the import form  page after upload button has been pressed
	if (isset($_POST['nirvana_import_confirmed'])) {
		nirvana_import_file();
		return;
	}
	// Load the presets  page after presets button has been pressed
	if (isset($_POST['nirvana_presets'])) {
		nirvana_init_fn();
		nirvana_presets();
		return;
	}
	if (!current_user_can('edit_theme_options'))  {
		wp_die( __('Sorry, but you do not have sufficient permissions to access this page.','nirvana') );
	}
?>
<div id="loading-big"></div>
<div class="wrap"><!-- Admin wrap page -->

<div id="lefty"><!-- Left side of page - the options area -->
<div>
	<div id="admin_header"><img src="<?php echo get_template_directory_uri() . '/admin/images/nirvana-logo.png' ?>" /> </div>
	<div id="admin_links">
		<a target="_blank" href="http://www.cryoutcreations.eu/nirvana">Nirvana Homepage</a>
		<a target="_blank" href="http://www.cryoutcreations.eu/forum">Support</a>
		<a target="_blank" href="http://www.cryoutcreations.eu">Cryout Creations</a>
	</div>
	<div style="clear: both;"></div>
</div>
<?php
if ( isset( $_GET['settings-updated'] ) ) {
    echo "<div class='updated fade' style='clear:left;'><p>";
	echo _e('Nirvana settings updated successfully.','nirvana');
	echo "</p></div>";
}
?>
<div id="jsAlert" class=""><b>Checking jQuery functionality...</b><br/><em>If this message remains visible after the page has loaded then there is a problem with your WordPress jQuery library. This can have several causes, including poorly written plugins.
The Nirvana Settings page cannot function without jQuery. </em></div>
<?php global $nirvanas; $nirvana_varalert = cryout_maxvarcheck(count($nirvanas));
	if ($nirvana_varalert): ?><div id="varlimitalert"> <?php echo $nirvana_varalert; ?> </div><?php endif; ?>
	<div id="main-options">
		<form name="nirvana_form" id="nirvana_form" action="options.php" method="post" enctype="multipart/form-data">
			<div id="accordion">
				<?php settings_fields('nirvana_settings'); ?>
				<?php do_settings_sections(__FILE__); ?>
			</div>
			<div id="submitDiv">
			    <br>
				<input class="button" name="nirvana_settings[nirvana_submit]" type="submit" id="nirvana_sumbit" style="float:right;"   value="<?php _e('Save Changes','nirvana'); ?>" />
				<input class="button" name="nirvana_settings[nirvana_defaults]" id="nirvana_defaults" type="submit" style="float:left;" value="<?php _e('Reset to Defaults','nirvana'); ?>" />
				</div>
		</form>
		<span id="version">
		Nirvana v<?php echo NIRVANA_VERSION; ?> by <a href="http://www.cryoutcreations.eu" target="_blank">Cryout Creations</a>
		</span>
	</div><!-- main-options -->
</div><!--lefty -->


<div id="righty" ><!-- Right side of page - Coffee, RSS tips and others -->
	<div id="nirvana-donate" class="postbox donate">
	 <div title="Click to toggle" class="handlediv"><br /></div>
		<h3 class="hndle"> Coffee Break </h3>
		<div class="inside">
		<?php echo "<p>We here at Cryout Creations have reached a higher state of mind. While meticulously crafting WordPress themes we have elevated to another dimension
		where we have spent ages enhancing our cognitive development, growing infinitely wiser and more experienced. In this surreal place called Nirvana we've finally found
		the answer to the question humanity has been asking itself since the dawn of time: <i>'What is the meaning of life?'</i> </p>
		<p>And now, thanks to us, that question has an absolute and undisputable answer: <i>'Coffee'</i>. Coffee is the answer to everything, the key to every lock,
		the source code to the Universe. Coffee powers our bodies and minds and it's what our souls are made of. </p>
	<p>Also, it's a universal fact that when coffee takes the form of a question ('Coffee?') the answer will always be <i>'Yes, please'</i>, so...</p>"; ?>
			<div style="display:block;float:none;margin:0 auto;text-align:center;">
					
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
							">
				<input type="image" src="<?php echo get_template_directory_uri() . '/admin/images/coffee.png' ?>" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
			</div>
		</div><!-- inside -->
	</div><!-- donate -->

    <div id="nirvana-export" class="postbox export non-essential-option" style="overflow:hidden;">
            <div title="Click to toggle" class="handlediv"><br /></div>
           	<h3 class="hndle"><?php _e( 'Import/Export Settings', 'nirvana' ); ?></h3>
        <div class="panel-wrap inside">
				<form action="" method="post">
                	<?php wp_nonce_field('nirvana-export', 'nirvana-export'); ?>
                    <input type="hidden" name="nirvana_export" value="true" />
                    <input type="submit" class="button" value="<?php _e('Export Theme options', 'nirvana'); ?>" />
					<p class="imex-text"><?php _e("It's that easy: a mouse click away - the ability to export your Nirvana settings and save them on your computer. Feeling safer? You should!","nirvana"); ?></p>
                </form>
				<br />
                <form action="" method="post">
                    <input type="hidden" name="nirvana_import" value="true" />
                    <input type="submit" class="button" value="<?php _e('Import Theme options', 'nirvana'); ?>" />
					<p class="imex-text"><?php _e("Without the import, the export would just be a fool's exercise. Make sure you have the exported file ready and see you after the mouse click.","nirvana"); ?></p>
                </form>
			<?php /*	<br />
				<form action="" method="post">
                    <input type="hidden" name="nirvana_presets" value="true" />
                    <input type="submit" class="button" id="presets_button" value="<?php _e('Color Schemes', 'nirvana'); ?>" />
					<p class="imex-text"><?php _e("A collection of preset color schemes to use as the starting point for your site. Just load one up and see your blog in a different light.","nirvana"); ?></p>
                </form>
				*/ ?>

		</div><!-- inside -->
	</div><!-- export -->

    <div id="nirvana-news" class="postbox news" >
	 <div title="Click to toggle" class="handlediv"><br /></div>
        		<h3 class="hndle"><?php _e( 'Nirvana Latest News', 'nirvana' ); ?></h3>
            <div class="panel-wrap inside" style="height:200px;overflow:auto;">
             
            </div><!-- inside -->
    </div><!-- news -->


</div><!--  righty -->
</div><!--  wrap -->

<script type="text/javascript">
var reset_confirmation = '<?php echo esc_html(__('Reset Nirvana Settings to Defaults?','nirvana')); ?>';

function startfarb(a,b) {
	jQuery(b).css('display','none');
	jQuery(b).farbtastic(a).addtitle({id: a});

	jQuery(a).click(function() {
			if(jQuery(b).css('display') == 'none')	{
                                        			jQuery(b).parents('div:eq(0)').addClass('ui-accordion-content-overflow');
                                                    jQuery(b).css({'display':'inline-block','position':'absolute',marginLeft:'100px',opacity:0}).animate({opacity:1,marginLeft:'0px'},150);
                                                       }
	});

	jQuery(document).mousedown( function() {
		if(jQuery(b).css('display') != 'none') setTimeout(function () { jQuery(b).css('display','none');},150);
		jQuery(b).animate({opacity:0,marginLeft:'100px'},150, function(){ jQuery(b).parents('div:eq(0)').removeClass('ui-accordion-content-overflow'); });
			// todo: find a better way to remove class after the fade on IEs
	});
}

function tooltip_terain() {
jQuery('#accordion small').parent('div').append('<a class="tooltip"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-tooltip.png" /></a>').
	each(function() {
	//jQuery(this).children('a.tooltip').attr('title',jQuery(this).children('small').html() );
	var tooltip_info = jQuery(this).children('small').html();
	jQuery(this).children('.tooltip').tooltip({content : tooltip_info});
    jQuery(this).children('.tooltip').tooltip( "option", "items", "a" );
	//jQuery(this).children('.tooltip').tooltip( "option", "show", "false");
	jQuery(this).children('.tooltip').tooltip( "option", "hide", "false");
	jQuery(this).children('small').remove();
	if (!jQuery(this).hasClass('slmini') && !jQuery(this).hasClass('slidercontent') && !jQuery(this).hasClass('slideDivs')) jQuery(this).addClass('tooltip_div');
	});
}

function coloursel(el){
	var id = "#"+jQuery(el).attr('id');
	jQuery(id+"2").hide();
	var bgcolor = jQuery(id).val();
	if (bgcolor <= "#666666") { jQuery(id).css('color','#ffffff'); } else { jQuery(id).css('color','#000000'); };
	jQuery(id).css('background-color',jQuery(id).val());
}

function vercomp(ver, req) {
    var v = ver.split('.');
    var q = req.split('.');
    for (var i = 0; i < v.length; ++i) {
        if (q.length == i) { return true; } // v is bigger
        if (parseInt(v[i]) == parseInt(q[i])) { continue; } // nothing to do here, move along
        else if (parseInt(v[i]) > parseInt(q[i])) { return true; } // v is bigger
        else { return false; } // q is bigger
    }
    if (v.length != q.length) { return false; } // q is bigger
    return true; // v = q;
}

// farbtastic title addon function
(function($){
        $.fn.extend({
            addtitle: function(options) {
                var defaults = {
                    id: ''
                }
                var options = $.extend(defaults, options);
            return this.each(function() {
                    var o = options;
					var title = jQuery(o.id).attr('title');
                    if (title===undefined) { } else { jQuery(o.id+'2').children('.farbtastic').append('<span class="mytitle">'+title+'</span>'); }
            });
        }
        });
})(jQuery);


jQuery(document).ready(function(){
	//var _jQueryVer = parseFloat('.'+jQuery().jquery.replace(/\./g, ''));  // jQuery version as float, eg: 0.183
	//var _jQueryUIVer = parseFloat('.'+jQuery.ui.version.replace(/\./g, '')); // jQuery UI version as float, eg: 0.192
	//if (_jQueryUIVer >= 0.190) {
	if (vercomp(jQuery.ui.version,"1.9.0")) {
		tooltip_terain();
		jQuery('.colorthingy').each(function(){
			id = "#"+jQuery(this).attr('id');
			startfarb(id,id+'2');
		});
	} else {
		jQuery("#main-options").addClass('oldwp');
		setTimeout(function(){jQuery('#nirvana_slideType').trigger('click')},1000);
		jQuery('.colorthingy').each(function(){
			id = "#"+jQuery(this).attr('id');
			jQuery(this).on('keyup',function(){coloursel(this)});
			coloursel(this);
		});
		// warn about the old partially unsupported version
		jQuery("#jsAlert").after("<div class='updated fade' style='clear:left; font-size: 16px;'><p>Nirvana has detected you are running an older version of Wordpress / jQuery. Some features may not work correctly. Consider updating your Wordpress to the latest version.</p></div>");
	}
});
jQuery('#jsAlert').hide();
</script>

<?php } // nirvana_page_fn()
?>