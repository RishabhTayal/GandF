<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * 
 */

function optionsframework_options() {

	// Post Navigation Links Location
	$post_nav_array = array(
		"disable" => __("Disable", "simpleo"),
		"sidebar" => __("Main Sidebar", "simpleo"),
		"below" => __("Below Content", "simpleo"),

	);
	
	// Post Info Location
	$post_info_array = array(
		"disable" => __("Disable", "simpleo"),
		"above" => __("Above Content", "simpleo"),

	);
	
	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/admin/images/';
	
	// Google Fonts
	$google_fonts = array(
						"PT Sans" => "PT Sans"
					);

	// Options Enable/Disable
	$options_enable = array(
						"Enable" => __("Enable","simpleo"),
						"Disable" => __("Disable","simpleo"),	
					);

	// Positions
	$positions = array(
						"Left" => __("Left","simpleo"),
						"Right" => __("Right","simpleo"),	
					);
										
	// Excerpt or Full Blog Content
	$options_content = array(
						"Excerpt" => __("Excerpt","simpleo"),
						"Full Content" => __("Full Content","simpleo"),	
					);
					
	// Image Sliders
	$slider_select = array("flex" => __("Flex Slider","simpleo"), "refine" => __("Refine Slider","simpleo"));
	
	// Featured Posts Display
	$options_feat_posts = array("grid" => __("Grid","simpleo"), "slider" => __("Image Slider","simpleo"));
	
	// Animation Effecta
	$animation_effects = array("fade" => "fade", "random" => "random", "slideV" => "slideV", "slideH" => "slideH", "sliceV" => "sliceV", "sliceH" => "sliceH", "cubeV" => "cubeV", "cubeH" => "cubeH", "scale" => "scale", "kaleidoscope" => "kaleidoscope", "fan" => "fan", "blindV" => "blindV", "blindH" => "blindH");

	// Font Sizes
	$font_sizes = array(
		'10' => '10',
		'11' => '11',
		'12' => '12',
		'13' => '13',
		'14' => '14',
		'15' => '15',
		'16' => '16',
		'17' => '17',
		'18' => '18',
		'19' => '19',
		'20' => '20',
		'21' => '21',
		'22' => '22',
		'23' => '23',
		'24' => '24',
		'25' => '25',
		'26' => '26',
		'27' => '27',
		'28' => '28',
		'29' => '29',
		'30' => '30',
		'31' => '31',
		'32' => '32',
		'33' => '33',
		'34' => '34',
		'35' => '35',
		'36' => '36',
		'37' => '37',
		'38' => '38',
		'39' => '39',
		'40' => '40',
		'41' => '41',
		'42' => '42',
	);
	
	// Button Colors
	$button_colors = array("green" => __("green","simpleo"),"darkgreen" => __("darkgreen","simpleo"),"orange" => __("orange","simpleo"), "blue" => __("blue","simpleo"), "red" => __("red","simpleo") ,"pink" => __("pink","simpleo"), "darkgray" => __("darkgray","simpleo"),"lightgray" => __("lightgray","simpleo"));
	

	$options = array();

	// General Settings
	$options[] = array(
		"name" => __("General","simpleo"),
		"type" => "heading");

	$options[] = array( "name" 	=> __("Enable Custom Favicon","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "enable_favicon",
		"std" => "0",
		"type" => "checkbox");

	$options[] = array( "name" => __("Custom Favicon","simpleo"),
		"desc" => __("You can upload a favicon for your theme, or specify a favicon image URL directly. Image size should be (16px x 16px)","simpleo"),
		"id" => "favicon",
		"mod" => "min",
		"type" => "upload");
	
	$options[] = array( "name" 	=> __("Breadcrumbs","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "enable_breadcrumbs",
		"std" => "1",
		"type" => "checkbox");
		
	$options[] = array( "name" 	=> __("Responsive Design","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "responsive_design",
		"std" => "1",
		"type" => "checkbox");
		
	$options[] = array( "name" 	=> __("ScrollUp","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "enable_scrollup",
		"std" => "1",
		"type" => "checkbox");
		
	$options[] = array( "name" => __("ScrollUp Color","simpleo"),
		"desc" => __("Pick the color (default is #ffcc0d)","simpleo"),
		"id" => "scrollup_color",
		"std" => "#8db529",
		"type" => "color");
		
	$options[] = array( "name" => __("ScrollUp Hover Color","simpleo"),
		"desc" => __("Pick the color (default is #ffffff)","simpleo"),
		"id" => "scrollup_hover_color",
		"std" => "#ffffff",
		"type" => "color");

	// Logo Settings
	$options[] = array(
		"name" => __("Logo", "simpleo"),
		"type" => "heading");

	$options[] = array( "name" => __("Logo Width (px)","simpleo"),
		"desc" => __("Default is 350","simpleo"),
		"id" => "logo_width",
		"std" => "350",
		"class" => "mini",
		"type" => "text");
		
	$options[] = array( "name" => __("Logo Height (px)","simpleo"),
		"desc" => __("Default is 80","simpleo"),
		"id" => "logo_height",
		"std" => "80",
		"class" => "mini",
		"type" => "text");

	$options[] = array( "name" => __("Logo Top Margin (px)","simpleo"),
		"desc" => __("Default is 25","simpleo"),
		"id" => "logo_top_margin",
		"std" => "25",
		"class" => "mini",
		"type" => "text");
		
	$options[] = array( "name" => __("Logo Left Margin (px)","simpleo"),
		"desc" => __("Default is 0","simpleo"),
		"id" => "logo_left_margin",
		"std" => "0",
		"class" => "mini",
		"type" => "text");
		
	$options[] = array( "name" => __("Logo Bottom Margin (px)","simpleo"),
		"desc" => __("Default is 25","simpleo"),
		"id" => "logo_bottom_margin",
		"std" => "25",
		"class" => "mini",
		"type" => "text");
		
	$options[] = array( "name" => __("Logo Right Margin (px)","simpleo"),
		"desc" => __("Default is 25","simpleo"),
		"id" => "logo_right_margin",
		"std" => "25",
		"class" => "mini",
		"type" => "text");
		
	$options[] = array( "name" => __("Image Logo","simpleo"),
		"desc" => __("You can upload a logo for your theme, or specify an image URL directly","simpleo"),
		"id" => "logo",
		"mod" => "min",
		"type" => "upload");

	$options[] = array( "name" => __("Logo ALT Text","simpleo"),
		"desc" => __("Specifies an alternate text for the logo","simpleo"),
		"id" => "logo_alt_text",
		"std" => "Logo",
		"type" => "text");

	$options[] = array( "name" 	=> __("Logo Uppercase","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "logo_uppercase",
		"std" => "1",
		"type" => "checkbox");
		
	$options[] = array( "name" => __("Select Logo Font Family","simpleo"),
		"desc" => __("Select logo font family","simpleo"),
		"id" => "google_font_logo",
		"std" => "PT Sans",
		"type" => "select",
		"options" => $google_fonts); 

	$options[] = array( "name" => __("Logo Font Size (px)","simpleo"),
		"desc" => __("Default is 50","simpleo"),
		"id" => "logo_font_size",
		"std" => "50",
		"class" => "mini",
		"type" => "text");
		
	$options[] = array( "name" => __("Logo Font Weight","simpleo"),
		"desc" => __("Defines from thin to thick characters (100 to 900)","simpleo"),
		"id" => "logo_font_weight",
		"std" => "700",
		"class" => "mini",
		"type" => "text");
		
	$options[] = array( "name" => __("Logo Color","simpleo"),
		"desc" => __("Pick logo color (default is #ffffff)","simpleo"),
		"id" => "text_logo_color",
		"std" => "#ffffff",
		"type" => "color");

	$options[] = array( "name" 	=> __("Enable Tagline Underneath Logo","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "enable_logo_tagline",
		"std" => "1",
		"type" => "checkbox");
	
	$options[] = array( "name" => __("Tagline Font Size (px)","simpleo"),
		"desc" => __("Default is 16","simpleo"),
		"id" => "tagline_font_size",
		"std" => "16",
		"class" => "mini",
		"type" => "text");
		
	$options[] = array( "name" => __("Tagline Color","simpleo"),
		"desc" => __("Pick tagline color (default is #ffffff)","simpleo"),
		"id" => "tagline_color",
		"std" => "#ffffff",
		"type" => "color");
		
	$options[] = array( "name" 	=> __("Tagline Uppercase","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "tagline_uppercase",
		"std" => "1",
		"type" => "checkbox");

	// Navigation Menu
	$options[] = array(
		"name" => __("Navigation", "simpleo"),
		"type" => "heading");

	$options[] = array( "name" => __("Select Main Navigation Menu Font Family","simpleo"),
		"desc" => __("Select a font family for the main navigation menu","simpleo"),
		"id" => "google_font_menu",
		"std" => "PT Sans",
		"type" => "select",
		"options" => $google_fonts); 
		
	$options[] = array( "name" 	=> __("Main Navigation Menu Font Size (px)","simpleo"),
		"desc" => __("Select the font size, default value: 14","simpleo"),
		"id" => "nav_font_size",
		"std" => "14",
		"class" => "mini",
		"type" => "text");
		
	$options[] = array( "name" 	=> __("Uppercase Menu","apprise"),
		"desc" => __("", "simpleo"),
		"id" => "menu_uppercase",
		"std" => "1",
		"type" => "checkbox");

	$options[] = array( "name" => __("Main Navigation Menu Font Color","simpleo"),
		"desc" => __("Pick a main navigation menu font color (default is #ffffff)","simpleo"),
		"id" => "nav_font_color",
		"std" => "#ffffff",
		"type" => "color");
					
	$options[] = array( "name" => __("Main Navigation Menu Border Color","simpleo"),
		"desc" => __("Pick border color for the main navigation menu (default is #ffffff)","simpleo"),
		"id" => "nav_border_color",
		"std" => "#ffffff",
		"type" => "color");
		
	$options[] = array( "name" => __("Main Navigation Background Color","simpleo"),
		"desc" => __("Pick background color for the main navigation menu (default is #888888)","simpleo"),
		"id" => "nav_bg_color",
		"std" => "#888888",
		"type" => "color");
		
	$options[] = array( "name" => __("Main Navigation Menu SubMenu Background Color","simpleo"),
		"desc" => __("Pick a background color for the navigation menu submenu (default #8db529)","simpleo"),
		"id" => "nav_bg_sub_color",
		"std" => "#8db529",
		"type" => "color");

	$options[] = array( "name" => __("Main Navigation Menu Hover Font Color","simpleo"),
		"desc" => __("Pick a main navigation menu hover font color (default is #000000)","simpleo"),
		"id" => "nav_hover_font_color",
		"std" => "#000000",
		"type" => "color");

	$options[] = array( "name" => __("Main Navigation Menu Background Hover Color","simpleo"),
		"desc" => __("Pick a background hover color for the main navigation menu (default #8db529)","simpleo"),
		"id" => "nav_bg_hover_color",
		"std" => "#8db529",
		"type" => "color");
		
	$options[] = array( "name" => __("Main Navigation Selected Menu Color","simpleo"),
		"desc" => __("Pick a selected menu item color (default #000000)","simpleo"),
		"id" => "nav_cur_item_color",
		"std" => "#000000",
		"type" => "color");
						
	// Typography Settings
	$options[] = array(
		"name" => __("Typography", "simpleo"),
		"type" => "heading");

	$options[] = array( "name" => __("Select Body Font Family","simpleo"),
		"desc" => __("Select a font family for body text","simpleo"),
		"id" => "google_font_body",
		"std" => "PT Sans",
		"type" => "select",
		"options" => $google_fonts); 

	$options[] = array( "name" => __("Body Font Size (px)","simpleo"),
		"desc" => __("Default is 15","simpleo"),
		"id" => "body_font_size",
		"std" => "15",
		"type" => "select",
		"options" => $font_sizes);

	$options[] = array( "name" =>  __("Body Font Color","simpleo"),
		"desc" => __("Pick body font color. ( Default: #000000 )","simpleo"),
		"id" => "body_font_color",
		"std" => "#000000",
		"type" => "color");						

	// Header Settings
	$options[] = array(
		"name" => __("Header", "simpleo"),
		"type" => "heading");

	$options[] = array( "name" => __("Header Address Section","simpleo"),
		"desc" => __("Enable or Disable header address section","simpleo"),
		"id" => "header_address_enable",
		"std" => "1",
		"type" => "checkbox");
		
	$options[] = array( "name" => __("Address", "simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "header_address",
		"std" => "1234 Street Name, City Name, United States",
		"type" => "text");
		
	$options[] = array( "name" => __("Phone Number", "simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "header_phone",
		"std" => "(123) 456-7890",
		"type" => "text");
		
	$options[] = array( "name" => __("Email", "simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "header_email",
		"std" => "info@yourdomain.com",
		"type" => "text");
		
	$options[] = array( "name" =>  __("Header Address Section Color","simpleo"),
		"desc" => __("Pick address section color. ( Default: #ffffff )","simpleo"),
		"id" => "address_color",
		"std" => "#ffffff",
		"type" => "color");
		
	$options[] = array( "name" => __("Header Social Links","simpleo"),
		"desc" => __("Enable or Disable header social links","simpleo"),
		"id" => "header_social_enable",
		"std" => "1",
		"type" => "checkbox");
		
	$options[] = array( "name" =>  __("Header Social Links Color","simpleo"),
		"desc" => __("Pick social links icons color. ( Default: #000000 )","simpleo"),
		"id" => "header_social_color",
		"std" => "#000000",
		"type" => "color");
		
	$options[] = array( "name" =>  __("Header Social Links Box Color","simpleo"),
		"desc" => __("Pick social links icons box color. ( Default: #8DB529 )","simpleo"),
		"id" => "header_social_box_color",
		"std" => "#8DB529",
		"type" => "color");
	
	if(class_exists('Woocommerce')) {
		$options[] = array( "name" => __("Shopping Cart","simpleo"),
			"desc" => __("Enable or Disable shopping cart.","simpleo"),
			"id" => "shopping_cart_enable",
			"std" => "1",
			"type" => "checkbox");
			
		$options[] = array( "name" =>  __("Shopping Cart Section Color","simpleo"),
			"desc" => __("Pick shopping cart section color. ( Default: #ffffff )","simpleo"),
			"id" => "shopping_color",
			"std" => "#ffffff",
			"type" => "color");
	}
										
	// Home Page Settings
	$options[] = array(
		"name" => __("Home Page", "simpleo"),
		"type" => "heading");
		
	$options[] = array( "name" => __("Enable Image Slider on Home Page","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "image_slider_on",
		"std" => "1",
		"type" => "checkbox");	
		
	$options[] = array( "name" => __("Display About Section on Home Page","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "about_section_on",
		"std" => "1",
		"type" => "checkbox");	

	$options[] = array( "name"	=> __("About Section Header Text","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "about_section_header",
		"std" => "About Us",
		"type" => "text");
		
	$options[] = array( "name"	=> __("About Section Text","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "about_section_text",
		"std" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
		"type" => "textarea");	
		
	$options[] = array( "name" =>  __("About Section Text Color","simpleo"),
		"desc" => __("Pick text color. ( Default: #000000 )","simpleo"),
		"id" => "about_text_color",
		"std" => "#000000",
		"type" => "color");
		
	$options[] = array( "name" =>  __("About Section Background Color","simpleo"),
		"desc" => __("Pick background color. ( Default: #ffffff )","simpleo"),
		"id" => "about_bg_color",
		"std" => "#ffffff",
		"type" => "color");	

	$options[] = array( "name" => __("Display Content Boxes Section on Home Page","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "content_boxes_section_on",
		"std" => "0",
		"type" => "checkbox");
		
	$options[] = array( "name" => __("Display Blog Posts on Home Page","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "blog_posts_on",
		"std" => "1",
		"type" => "checkbox");
											
	// Image Slider Settings
	$options[] = array(
		"name" => __("Image Slider", "simpleo"),
		"type" => "heading");
		
	$options[] = array( "name" => __("Default Image Slider:", "simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "default_slider",
		"std" => "refine",
		"type" => "select",
		"options" => $slider_select);
		
	$options[] = array( "name" => __("Select Image Slider Category","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "image_slider_cat",
		"std" => "",
		"type" => "select",
		"options" => $options_categories);
		
	$options[] = array( "name" => __("Slider Animation Effect:", "simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "slider_animation",
		"std" => "fade",
		"type" => "select",
		"options" => $animation_effects);
		
	$options[] = array( "name" => __("Slideshow Speed", "simpleo"),
		"desc" => __("Select the slideshow speed, 1000 = 1 second, default value: 5000","simpleo"),
		"id" => "slideshow_speed",
		"std" => "5000",
		"class" => "mini",
		"type" => "text");
					
	$options[] = array( "name" => __("Animation Speed", "simpleo"),
		"desc" => __("Select the animation speed, 1000 = 1 second, default value: 800","simpleo"),
		"id" => "animation_speed",
		"std" => "800",
		"class" => "mini",
		"type" => "text" );

	$options[] = array( "name" => __("Number of Slides to Display", "simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "slider_num",
		"std" => "3",
		"class" => "mini",
		"type" => "text" );

	$options[] = array("name" => __("Slider Captions", "simpleo"),
		"desc" => __("Enable/Disable captions on a slide","simpleo"),
		"id" => "captions",
		"std" => "0",
		"type" => "checkbox");
		
	$options[] = array( "name" => __("Captions Background Color","simpleo"),
		"desc" => __("Pick a background color (default is #8db529)","simpleo"),
		"id" => "captions_bg_color",
		"std" => "#8db529",
		"type" => "color");
		
	$options[] = array( "name" => __("Captions Font Color","simpleo"),
		"desc" => __("Pick the font color (default is #000000)","simpleo"),
		"id" => "captions_font_color",
		"std" => "#000000",
		"type" => "color");
		
	// Footer Options
	$options[] = array(
		"name" => __("Footer", "simpleo"),
		"type" => "heading");

	$options[] = array( "name" => __("Footer Background Color","simpleo"),
		"desc" => __("Pick a background color (default is #000000)","simpleo"),
		"id" => "footer_bg_color",
		"std" => "#000000",
		"type" => "color");

	$options[] = array( "name" => __("Copyright Section Background Color","simpleo"),
		"desc" => __("Pick a background color (default is #888888)","simpleo"),
		"id" => "copyright_bg_color",
		"std" => "#888888",
		"type" => "color");

	$options[] = array( "name" => __("Footer Widget Title Color","simpleo"),
		"desc" => __("Pick a widget title color (default is #ffffff)","simpleo"),
		"id" => "footer_widget_title_color",
		"std" => "#ffffff",
		"type" => "color");
		
	$options[] = array( "name" => __("Footer Widget Title Border Color","simpleo"),
		"desc" => __("Pick a widget title border color (default is #ffffff)","simpleo"),
		"id" => "footer_widget_title_border_color",
		"std" => "#ffffff",
		"type" => "color");
		
	$options[] = array( "name" => __("Footer Widget Text Color","simpleo"),
		"desc" => __("Pick a widget text color (default is #ffffff)","simpleo"),
		"id" => "footer_widget_text_color",
		"std" => "#ffffff",
		"type" => "color");
		
	$options[] = array( "name" => __("Footer Widget Text Border Color","simpleo"),
		"desc" => __("Pick a widget text border color (default is #dddddd)","simpleo"),
		"id" => "footer_widget_text_border_color",
		"std" => "#dddddd",
		"type" => "color");

	$options[] = array( "name" => __("Footer Widgets","simpleo"),
		"desc" 		=> __("Turn On / Off footer widgets","simpleo"),
		"id" 		=> "footer_widgets",
		"std" 		=> "1",
		"type" 		=> "checkbox");
		
	$options[] = array( "name" => __("Copyright Text","simpleo"),
         "desc" => __("", "simpleo"),
         "id" => "footer_copyright_text",
         "std" => 'Copyright '.date('Y').' '.get_bloginfo('site_title'),
         "type" => "textarea");

	// Layout Options
	$options[] = array(
		"name" => __("Layout", "simpleo"),
		"type" => "heading");
		
	$options[] = array(
		'name' => __("Select the Layout","simpleo"),
		'desc' => "",
		'id' => "layout_settings",
		'std' => "col2-l",
		'type' => "images",
		'options' => array(
			'col1' => $imagepath . 'col-1c.png',
			'col2-l' => $imagepath . 'col-2cl.png',
			'col2-r' => $imagepath . 'col-2cr.png')
	);

	// Blog Options
	$options[] = array(
		"name" => __("Blog Options", "simpleo"),
		"type" => "heading");

	$options[] = array( "name" 	=> __("Excerpt or Full Blog Content","simpleo"),
		"desc" => __("Show excerpt or full blog content on archive / blog pages","simpleo"),
		"id" => "blog_content",
		"std" => "Full Content",
		"options" => $options_content,
		"type" => "select");
		
	$options[] = array( "name"	=> __("Blog Excerpt Length","simpleo"),
		"desc" => __("Default: 50","simpleo"),
		"id" => "blog_excerpt",
		"std" => "50",
		"class" => "mini",
		"type" => "text");
		
	$options[] = array( "name" 	=> __("Use Simple Pagination","simpleo"),
		"desc" => __("Enable/Disable simple pagination","simpleo"),
		"id" => "simple_paginaton",
		"std" => "0",
		"type" => "checkbox");
		
	$options[] = array(
		"name" => __("Post Navigation Links", "simpleo"),
		"desc" => __("Shows links to the next and previous article","simpleo"),
		"id" => "post_navigation",
		"std" => "sidebar",
		"type" => "radio",
		"options" => $post_nav_array);
		
	$options[] = array(
		"name" => __("Post Info", "simpleo"),
		"desc" => __("Shows post info","simpleo"),
		"id" => "post_info",
		"std" => "above",
		"type" => "radio",
		"options" => $post_info_array);
		
	$options[] = array( "name" 	=> __("Display Featured Image Inside the Post","simpleo"),
		"desc" => __("Enable/Disable featured image inside the post","simpleo"),
		"id" => "featured_img_post",
		"std" => "1",
		"type" => "checkbox");

	// Content Boxes Settings
	$options[] = array(
		"name" => __("Content Boxes", "simpleo"),
		"type" => "heading");
		
	$options[] = array( "name" => __("First Column Header", "simpleo"),
		"desc" => __("Enter text to display in the header of the first column","simpleo"),
		"id" => "first_column_header",
		"std" => "Responsive Design",
		"type" => "text");
		
	$options[] = array( "name" => __("First Column Text", "simpleo"),
		"desc" => __("Enter text to display in the body of the first column","simpleo"),
		"id" => "first_column_text",
		"std" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
		"type" => "textarea");
		
	$options[] = array( "name" => __("First Column Image", "simpleo"),
		"desc" => sprintf( __( 'Enter Font Awesome icon name. For icon name refer to: <a href="%1$s" target="_blank">Font Awesome Website</a>', 'simpleo' ), 'http://fortawesome.github.io/Font-Awesome/icons/' ),
		"id" => "first_column_image",
		"std" => "fa-tablet",
		"type" => "text");
		
	$options[] = array( "name"	=> __("First Column URL","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "first_column_url",
		"std" => "",
		"type" => "text");
		
	$options[] = array( "name" => __("Second Column Header", "simpleo"),
		"desc" => __("Enter text to display in the header of the second column","simpleo"),
		"id" => "second_column_header",
		"std" => "High Quality",
		"type" => "text");
		
	$options[] = array( "name" => __("Second Column Text", "simpleo"),
		"desc" => __("Enter text to display in the body of the second column","simpleo"),
		"id" => "second_column_text",
		"std" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
		"type" => "textarea");
		
	$options[] = array( "name" => __("Second Column Image", "simpleo"),
		"desc" => sprintf( __( 'Enter Font Awesome icon name. For icon name refer to: <a href="%1$s" target="_blank">Font Awesome Website</a>', 'simpleo' ), 'http://fortawesome.github.io/Font-Awesome/icons/' ),
		"id" => "second_column_image",
		"std" => "fa-umbrella",
		"type" => "text");
		
	$options[] = array( "name"	=> __("Second Column URL","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "second_column_url",
		"std" => "",
		"type" => "text");
		
	$options[] = array( "name" => __("Third Column Header", "simpleo"),
		"desc" => __("Enter text to display in the header of the third column","simpleo"),
		"id" => "third_column_header",
		"std" => "Tons of Features",
		"type" => "text");
		
	$options[] = array( "name" => __("Third Column Text", "simpleo"),
		"desc" => __("Enter text to display in the body of the third column","simpleo"),
		"id" => "third_column_text",
		"std" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
		"type" => "textarea");
		
	$options[] = array( "name" => __("Third Column Image", "simpleo"),
		"desc" => sprintf( __( 'Enter Font Awesome icon name. For icon name refer to: <a href="%1$s" target="_blank">Font Awesome Website</a>', 'simpleo' ), 'http://fortawesome.github.io/Font-Awesome/icons/' ),
		"id" => "third_column_image",
		"std" => "fa-cog",
		"type" => "text");
		
	$options[] = array( "name"	=> __("Third Column URL","simpleo"),
		"desc" => __("", "simpleo"),
		"id" => "third_column_url",
		"std" => "",
		"type" => "text");
		
	$options[] = array( "name" =>  __("Section Text Color","simpleo"),
		"desc" => __("Pick text color. ( Default: #ffffff )","simpleo"),
		"id" => "cont_text_color",
		"std" => "#ffffff",
		"type" => "color");
		
	$options[] = array( "name" =>  __("Section Background Color","simpleo"),
		"desc" => __("Pick background color. ( Default: #8db529 )","simpleo"),
		"id" => "cont_bg_color",
		"std" => "#8db529",
		"type" => "color");
		
	// Widgets Options
	$options[] = array(
		"name" => __("Widgets", "simpleo"),
		"type" => "heading");
				
	$options[] = array(
		"name" => __("Archives Widget Settings:", "simpleo"),
		"desc" => __("", "simpleo"),
		"type" => "info");
		
	$options[] = array( "name" =>  __("Archives Widget Font Color","simpleo"),
		"desc" => __("Pick font color. ( Default: #8DB529 )","simpleo"),
		"id" => "archives_widget_font_color",
		"std" => "#8DB529",
		"type" => "color");
		
	$options[] = array( "name" =>  __("Archives Widget Title Color","simpleo"),
		"desc" => __("Pick title color. ( Default: #000000 )","simpleo"),
		"id" => "archives_widget_title_color",
		"std" => "#000000",
		"type" => "color");	
		
	$options[] = array(
		"name" => __("Categories Widget Settings:", "simpleo"),
		"desc" => __("", "simpleo"),
		"type" => "info");
		
	$options[] = array( "name" =>  __("Categories Widget Font Color","simpleo"),
		"desc" => __("Pick font color. ( Default: #8DB529 )","simpleo"),
		"id" => "categories_widget_font_color",
		"std" => "#8DB529",
		"type" => "color");
		
	$options[] = array( "name" =>  __("Categories Widget Title Color","simpleo"),
		"desc" => __("Pick title color. ( Default: #000000 )","simpleo"),
		"id" => "categories_widget_title_color",
		"std" => "#000000",
		"type" => "color");
		
	$options[] = array(
		"name" => __("Calendar Widget Settings:", "simpleo"),
		"desc" => __("", "simpleo"),
		"type" => "info");
		
	$options[] = array( "name" =>  __("Calendar Widget Font Color","simpleo"),
		"desc" => __("Pick font color. ( Default: #8DB529 )","simpleo"),
		"id" => "calendar_widget_font_color",
		"std" => "#8DB529",
		"type" => "color");
		
	$options[] = array( "name" =>  __("Calendar Widget Title Color","simpleo"),
		"desc" => __("Pick title color. ( Default: #000000 )","simpleo"),
		"id" => "calendar_widget_title_color",
		"std" => "#000000",
		"type" => "color");
		
	$options[] = array(
		"name" => __("Custom Menu Widget Settings:", "simpleo"),
		"desc" => __("", "simpleo"),
		"type" => "info");
		
	$options[] = array( "name" =>  __("Custom Menu Widget Font Color","simpleo"),
		"desc" => __("Pick font color. ( Default: #8DB529 )","simpleo"),
		"id" => "custom_menu_widget_font_color",
		"std" => "#8DB529",
		"type" => "color");
		
	$options[] = array( "name" =>  __("Custom Menu Widget Title Color","simpleo"),
		"desc" => __("Pick title color. ( Default: #000000 )","simpleo"),
		"id" => "custom_menu_widget_title_color",
		"std" => "#000000",
		"type" => "color");
		
	$options[] = array(
		"name" => __("Links Widget Settings:", "simpleo"),
		"desc" => __("", "simpleo"),
		"type" => "info");
		
	$options[] = array( "name" =>  __("Links Widget Font Color","simpleo"),
		"desc" => "Pick font color. ( Default: #8DB529 )",
		"id" => "links_widget_font_color",
		"std" => "#8DB529",
		"type" => "color");
		
	$options[] = array( "name" =>  __("Links Widget Title Color","simpleo"),
		"desc" => __("Pick title color. ( Default: #000000 )","simpleo"),
		"id" => "links_widget_title_color",
		"std" => "#000000",
		"type" => "color");
		
	$options[] = array(
		"name" => __("Meta Widget Settings:", "simpleo"),
		"desc" => __("", "simpleo"),
		"type" => "info");
		
	$options[] = array( "name" =>  __("Meta Widget Font Color","simpleo"),
		"desc" => __("Pick font color. ( Default: #8DB529 )","simpleo"),
		"id" => "meta_widget_font_color",
		"std" => "#8DB529",
		"type" => "color");
		
	$options[] = array( "name" =>  __("Meta Widget Title Color","simpleo"),
		"desc" => __("Pick title color. ( Default: #000000 )","simpleo"),
		"id" => "meta_widget_title_color",
		"std" => "#000000",
		"type" => "color");
		
	$options[] = array(
		"name" => __("Pages Widget Settings:", "simpleo"),
		"desc" => __("", "simpleo"),
		"type" => "info");
		
	$options[] = array( "name" =>  __("Pages Widget Font Color","simpleo"),
		"desc" => __("Pick font color. ( Default: #8DB529 )","simpleo"),
		"id" => "pages_widget_font_color",
		"std" => "#8DB529",
		"type" => "color");
		
	$options[] = array( "name" =>  __("Pages Widget Title Color","simpleo"),
		"desc" => __("Pick title color. ( Default: #000000 )","simpleo"),
		"id" => "pages_widget_title_color",
		"std" => "#000000",
		"type" => "color");
		
	$options[] = array(
		"name" => __("Recent Comments Widget Settings:", "simpleo"),
		"desc" => __("", "simpleo"),
		"type" => "info");
		
	$options[] = array( "name" =>  __("Recent Comments Widget Font Color","simpleo"),
		"desc" => __("Pick font color. ( Default: #8DB529 )","simpleo"),
		"id" => "recent_comments_widget_font_color",
		"std" => "#8DB529",
		"type" => "color");
		
	$options[] = array( "name" =>  __("Recent Comments Widget Title Color","simpleo"),
		"desc" => __("Pick title color. ( Default: #000000 )","simpleo"),
		"id" => "recent_comments_widget_title_color",
		"std" => "#000000",
		"type" => "color");

	$options[] = array(
		"name" => __("Recent Posts Widget Settings:", "simpleo"),
		"desc" => __("", "simpleo"),
		"type" => "info");
		
	$options[] = array( "name" =>  __("Recent Posts Widget Font Color","simpleo"),
		"desc" => __("Pick font color. ( Default: #8DB529 )","simpleo"),
		"id" => "recent_posts_widget_font_color",
		"std" => "#8DB529",
		"type" => "color");
		
	$options[] = array( "name" =>  __("Recent Posts Widget Title Color","simpleo"),
		"desc" => __("Pick title color. ( Default: #000000 )","simpleo"),
		"id" => "recent_posts_widget_title_color",
		"std" => "#000000",
		"type" => "color");
		
	$options[] = array(
		"name" => __("RSS Widget Settings:", "simpleo"),
		"desc" => __("", "simpleo"),
		"type" => "info");
		
	$options[] = array( "name" =>  __("RSS Widget Font Color","simpleo"),
		"desc" =>__( "Pick font color. ( Default: #8DB529 )","simpleo"),
		"id" => "rss_widget_font_color",
		"std" => "#8DB529",
		"type" => "color");
		
	$options[] = array( "name" =>  __("RSS Widget Title Color","simpleo"),
		"desc" => __("Pick title color. ( Default: #000000 )","simpleo"),
		"id" => "rss_widget_title_color",
		"std" => "#000000",
		"type" => "color");
		
	$options[] = array(
		"name" => __("Search Widget Settings:", "simpleo"),
		"desc" => __("", "simpleo"),
		"type" => "info");
		
	$options[] = array( "name" =>  __("Search Widget Font Color","simpleo"),
		"desc" => __("Pick font color. ( Default: #8DB529 )","simpleo"),
		"id" => "search_widget_font_color",
		"std" => "#8DB529",
		"type" => "color");
		
	$options[] = array( "name" =>  __("Search Widget Title Color","simpleo"),
		"desc" => __("Pick title color. ( Default: #000000 )","simpleo"),
		"id" => "search_widget_title_color",
		"std" => "#000000",
		"type" => "color");
		
	$options[] = array(
		"name" => __("Tag Cloud Widget Settings:", "simpleo"),
		"desc" => __("", "simpleo"),
		"type" => "info");
		
	$options[] = array( "name" =>  __("Tag Cloud Widget Font Color","simpleo"),
		"desc" => __("Pick font color. ( Default: #ffffff )","simpleo"),
		"id" => "tag_cloud_widget_font_color",
		"std" => "#ffffff",
		"type" => "color");
		
	$options[] = array( "name" =>  __("Tag Cloud Widget Title Color","simpleo"),
		"desc" => __("Pick title color. ( Default: #000000 )","simpleo"),
		"id" => "tag_cloud_widget_title_color",
		"std" => "#000000",
		"type" => "color");
		
	$options[] = array(
		"name" => __("Text Widget Settings:", "simpleo"),
		"desc" => __("", "simpleo"),
		"type" => "info");
		
	$options[] = array( "name" =>  __("Text Widget Font Color","simpleo"),
		"desc" => __("Pick font color. ( Default: #8DB529 )","simpleo"),
		"id" => "text_widget_font_color",
		"std" => "#8DB529",
		"type" => "color");
		
	$options[] = array( "name" =>  __("Text Widget Title Color","simpleo"),
		"desc" => __("Pick title color. ( Default: #000000 )","simpleo"),
		"id" => "text_widget_title_color",
		"std" => "#000000",
		"type" => "color");
		
	$options[] = array(
		"name" => __("Other Widgets Settings:", "simpleo"),
		"desc" => __("", "simpleo"),
		"type" => "info");
		
	$options[] = array( "name" =>  __("Other Widgets Font Color","simpleo"),
		"desc" => __("Pick font color. ( Default: #8DB529 )","simpleo"),
		"id" => "other_widget_font_color",
		"std" => "#8DB529",
		"type" => "color");
		
	$options[] = array( "name" =>  __("Other Widgets Title Color","simpleo"),
		"desc" => __("Pick title color. ( Default: #000000 )","simpleo"),
		"id" => "other_widget_title_color",
		"std" => "#000000",
		"type" => "color");
		
	// Social Links		
	$options[] = array(
		'name' => __('Social Links', 'simpleo'),
		'type' => 'heading');

	$options[] = array( "name" => __("Facebook","simpleo"),
		"desc" => __("Enter your profile URL. To remove it, just leave it blank","simpleo"),
		"id" => "facebook_link",
		"std" => "#",
		"type" => "text"); 

	$options[] = array( "name" => __("Flickr","simpleo"),
		"desc" => __("Enter your profile URL. To remove it, just leave it blank","simpleo"),
		"id" => "flickr_link",
		"std" => "#",
		"type" => "text");

	$options[] = array( "name" => __("RSS","simpleo"),
		"desc" => __("Enter your profile URL. To remove it, just leave it blank","simpleo"),
		"id" => "rss_link",
		"std" => "#",
		"type" => "text"); 

	$options[] = array( "name" => __("Twitter","simpleo"),
		"desc" => __("Enter your profile URL. To remove it, just leave it blank","simpleo"),
		"id" => "twitter_link",
		"std" => "#",
		"type" => "text");

	$options[] = array( "name" => __("Youtube","simpleo"),
		"desc" => __("Enter your profile URL. To remove it, just leave it blank","simpleo"),
		"id" => "youtube_link",
		"std" => "#",
		"type" => "text");

	$options[] = array( "name" => __("Pinterest","simpleo"),
		"desc" => __("Enter your profile URL. To remove it, just leave it blank","simpleo"),
		"id" => "pinterest_link",
		"std" => "#",
		"type" => "text");

	$options[] = array( "name" => __("Tumblr","simpleo"),
		"desc" => __("Enter your profile URL. To remove it, just leave it blank","simpleo"),
		"id" => "tumblr_link",
		"std" => "#",
		"type" => "text");

	$options[] = array( "name" => __("Google Plus","simpleo"),
		"desc" => __("Enter your profile URL. To remove it, just leave it blank","simpleo"),
		"id" => "google_link",
		"std" => "#",
		"type" => "text");

	$options[] = array( "name" => __("Dribbble","simpleo"),
		"desc" => __("Enter your profile URL. To remove it, just leave it blank","simpleo"),
		"id" => "dribbble_link",
		"std" => "#",
		"type" => "text");

	$options[] = array( "name" => __("LinkedIn","simpleo"),
		"desc" => __("Enter your profile URL. To remove it, just leave it blank","simpleo"),
		"id" => "linkedin_link",
		"std" => "#",
		"type" => "text");
		
	$options[] = array( "name" => __("Instagram","simpleo"),
		"desc" => __("Enter your profile URL. To remove it, just leave it blank","simpleo"),
		"id" => "instagram_link",
		"std" => "#",
		"type" => "text");
			
	return $options;
}