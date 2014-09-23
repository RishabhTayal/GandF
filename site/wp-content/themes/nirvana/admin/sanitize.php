<?php

/*
 *
 * Settings arrays
 *
 */

/* Font family arrays */
$nirvana_colorschemes_array = array(
// color scheme presets are defined via schemes.php
);

$fonts = array(

	'General Theme Fonts'=> array(
					"Source Sans Pro",
					 "Ubuntu",
					 "Open Sans"),

	'Other Theme Fonts' => array(
					 "Droid Sans",
					 "Oswald",
					 "Oswald Light",
					 "Ubuntu Condensed",
					 "Yanone Kaffeesatz Regular",
					 "Yanone Kaffeesatz Light"),

	'Sans-Serif' => array("Segoe UI, Arial, sans-serif",
					 "Verdana, Geneva, sans-serif " ,
					 "Geneva, sans-serif ",
					 "Helvetica Neue, Arial, Helvetica, sans-serif",
					 "Helvetica, sans-serif" ,
					 "Century Gothic, AppleGothic, sans-serif",
				      "Futura, Century Gothic, AppleGothic, sans-serif",
					 "Calibri, Arian, sans-serif",
				      "Myriad Pro, Myriad,Arial, sans-serif",
					 "Trebuchet MS, Arial, Helvetica, sans-serif" ,
					 "Gill Sans, Calibri, Trebuchet MS, sans-serif",
					 "Impact, Haettenschweiler, Arial Narrow Bold, sans-serif ",
					 "Tahoma, Geneva, sans-serif" ,
					 "Arial, Helvetica, sans-serif" ,
					 "Arial Black, Gadget, sans-serif",
					 "Lucida Sans Unicode, Lucida Grande, sans-serif "),

	'Serif' => array("Georgia, Times New Roman, Times, serif" ,
					  "Times New Roman, Times, serif",
					  "Cambria, Georgia, Times, Times New Roman, serif",
					  "Palatino Linotype, Book Antiqua, Palatino, serif",
					  "Book Antiqua, Palatino, serif",
					  "Palatino, serif",
				       "Baskerville, Times New Roman, Times, serif",
 					  "Bodoni MT, serif",
					  "Copperplate Light, Copperplate Gothic Light, serif",
					  "Garamond, Times New Roman, Times, serif"),

	'MonoSpace' => array( "Courier New, Courier, monospace" ,
					  "Lucida Console, Monaco, monospace",
					  "Consolas, Lucida Console, Monaco, monospace",
					  "Monaco, monospace"),

	'Cursive' => array(  "Lucida Casual, Comic Sans MS , cursive ",
				      "Brush Script MT,Phyllis,Lucida Handwriting,cursive",
					 "Phyllis,Lucida Handwriting,cursive",
					 "Lucida Handwriting,cursive",
					 "Comic Sans MS, cursive")
); // fonts


/* Social media links */

$socialNetworks = array (
		"AboutMe", "AIM", "Amazon", "Contact", "Delicious", "DeviantArt", 
		"Digg", "Dribbble", "Etsy", "Facebook", "Flickr",
		"FriendFeed", "GoodReads", "GooglePlus", "IMDb", "Instagram",
		"LastFM", "LinkedIn", "Mail", "MindVox", "MySpace", "Newsvine", "Phone",
		"Picasa", "Pinterest", "Reddit", "RSS", "ShareThis",  
		"Skype", "Steam", "SoundCloud", "StumbleUpon", "Technorati", 
		"Tumblr",  "Twitch", "Twitter", "Vimeo", "VK",
		"WordPress", "Yahoo", "Yelp", "YouTube", "Xing" );

if (!function_exists ('nirvana_options_validate') ) :
/*
 *
 * Validate user data
 *
 */
function nirvana_settings_validate($input) {
global $nirvana_defaults;
global $nirvanas;
global $nirvana_colorschemes_array ;

$colorSchemes = ( ! empty( $input['nirvana_schemessubmit']) ? true : false );
if ($colorSchemes) : $input = array_merge($nirvanas,json_decode("{".$nirvana_colorschemes_array[$input['nirvana_colorschemes']]."}",true));
else :
	//echo "processing all inputs"; //DEBUG
	// generic checks, based on datatypes and on field names
    foreach ($input as $name => $value):
	//echo "<br/>&raquo; $name = <span style='color:#aaa;font-style:italic;'>".substr(htmlentities((is_array($value)?"[".implode(";",$value)."]":$value)),0,100)." ~ "; //DEBUG
	if (preg_match("/^nirvana_.*/i",$name)): // only process theme settings
		if (is_array($value)):
			$input[$name] = cryout_proto_arrsan($value); // array
			//echo "[".substr(htmlentities((is_array($input[$name])?implode(";",$input[$name]):$input[$name])),0,100)."]</span> &dash; array"; // DEBUG
		else:
		switch($value):
			case (preg_match("/^(#[0-9a-f]{3}|#?[0-9a-f]{6})$/i", trim(wp_kses_data($value))) ? $value : !$value):  // colour field
				$input[$name] = cryout_color_clean(trim(wp_kses_data($input[$name])));
				//echo "".substr(htmlentities($input[$name]),0,100)."</span> &dash; color field"; //DEBUG
			break;	
			case (preg_match("/^[0-9]+$/i", trim(wp_kses_data($value))) ? $value : !$value):  // numeric field
				$input[$name] = intval(wp_kses_data($input[$name]));
				//echo "".substr(htmlentities($input[$name]),0,100)."</span> &dash; numeric field"; //DEBUG
			break;
			default:
				switch($name):
					case (preg_match("/.*(copyright|excerpt|customcss|customjs|slidertext|columntext|fronttext).*/i",trim($name)) ? $name: !$name): // long content fields
						$input[$name] = trim(wp_kses_post($input[$name]));
						//echo "".substr(htmlentities($input[$name]),0,100)."</span> &dash; kses post"; //DEBUG
						break;
					case (preg_match("/.*(sliderlink|columnlink).*/i",trim($name)) ? $name: !$name): // url fields
						$input[$name] = esc_url_raw($input[$name]);
						//echo "".substr(htmlentities($input[$name]),0,100)."</span> &dash; url raw"; //DEBUG
						break;
					default:
						$input[$name] = trim(wp_kses_data($input[$name])); // generic sanitization for the rest
						//echo "".substr(htmlentities($input[$name]),0,100)."</span> &dash; kses data *generic"; //DEBUG
				endswitch;
		endswitch;
		endif; // if array	

	endif;
	endforeach;
//echo "<br/>submit ended"; //DEBUG

	// more specific checks that should be kept (for now)
/*** 1 ***/
	if(isset($input['nirvana_sidewidth']) && is_numeric($input['nirvana_sidewidth']) && $input['nirvana_sidewidth']>=500 && $input['nirvana_sidewidth'] <=1760) {} else {$input['nirvana_sidewidth']=$nirvana_defaults['nirvana_sidewidth']; }
	if(isset($input['nirvana_sidebar']) && is_numeric($input['nirvana_sidebar']) && $input['nirvana_sidebar']>=220 && $input['nirvana_sidebar'] <=800) {} else {$input['nirvana_sidebar']=$nirvana_defaults['nirvana_sidebar']; }

	$input['nirvana_hheight'] =  intval(wp_kses_data($input['nirvana_hheight']));
	//$input['nirvana_copyright'] = trim(wp_kses_post($input['nirvana_copyright']));

	$input['nirvana_excerptlength'] =  intval(wp_kses_data($input['nirvana_excerptlength']));
	//$input['nirvana_excerptdots'] =  wp_kses_data($input['nirvana_excerptdots']);
	//$input['nirvana_excerptcont'] =  wp_kses_data($input['nirvana_excerptcont']);

	$input['nirvana_fwidth'] =  intval(wp_kses_data($input['nirvana_fwidth']));
	$input['nirvana_fheight'] =  intval(wp_kses_data($input['nirvana_fheight']));
	
	$input['nirvana_contentmargintop'] =  intval(wp_kses_data($input['nirvana_contentmargintop']));
	$input['nirvana_contentpadding'] =  intval(wp_kses_data($input['nirvana_contentpadding']));

/*** 2 ***/

	$cryout_special_terms = array('mailto:','callto://', 'tel:');
	$cryout_special_keys = array('Mail', 'Skype', 'Phone');
	for ($i=1;$i<10;$i+=2) {
		if (!isset($input['nirvana_social_target'.$i])) {$input['nirvana_social_target'.$i] = "0";}
		$input['nirvana_social_title'.$i] = wp_kses_data(trim($input['nirvana_social_title'.$i]));
		$j=$i+1;
		if (in_array($input['nirvana_social'.$i],$cryout_special_keys)) :
			$input['nirvana_social'.$j]	= wp_kses_data(str_replace($cryout_special_terms,'',$input['nirvana_social'.$j]));
			if (in_array($input['nirvana_social'.$i],$cryout_special_keys)):
				$prefix = $cryout_special_terms[array_search($input['nirvana_social'.$i],$cryout_special_keys)];
				$input['nirvana_social'.$j] = $prefix.$input['nirvana_social'.$j];
			endif;
		else :
			$input['nirvana_social'.$j] = esc_url_raw($input['nirvana_social'.$j]);
		endif;
	}
	for ($i=0;$i<=5;$i++) if (!isset($input['nirvana_socialsdisplay'.$i])) {$input['nirvana_socialsdisplay'.$i] = "0";}
		
	$show_blog= array("author","date","time","category","tag","comments");
	foreach ($show_blog as $item) :
		if (!isset($input['nirvana_blog_show'][$item])) {$input['nirvana_blog_show'][$item] = 0;}
	endforeach;
	
	$show_single= array("author","date","time","category","tag","bookmark");
	foreach ($show_single as $item) :
	if (!isset($input['nirvana_single_show'][$item])) {$input['nirvana_single_show'][$item] = 0;}
	endforeach;


	$input['nirvana_favicon'] =  esc_url_raw($input['nirvana_favicon']);
	$input['nirvana_logoupload'] =  esc_url_raw($input['nirvana_logoupload']);
	$input['nirvana_headermargintop'] =  intval(wp_kses_data($input['nirvana_headermargintop']));
	$input['nirvana_headermarginleft'] =  intval(wp_kses_data($input['nirvana_headermarginleft']));

	//$input['nirvana_customcss'] =  wp_kses_post(trim($input['nirvana_customcss']));
	//$input['nirvana_customjs'] =  wp_kses_post(trim($input['nirvana_customjs']));

	$input['nirvana_slideNumber'] =  intval(wp_kses_data($input['nirvana_slideNumber']));
	$input['nirvana_slideSpecific'] = wp_kses_data($input['nirvana_slideSpecific']);

	$input['nirvana_fpsliderwidth'] =  intval(wp_kses_data($input['nirvana_fpsliderwidth']));
	$input['nirvana_fpsliderheight'] = intval(wp_kses_data($input['nirvana_fpsliderheight']));
	$input['nirvana_fpslider_topmargin'] = intval(wp_kses_data($input['nirvana_fpslider_topmargin']));
	$input['nirvana_fpslider_bordersize'] = intval(wp_kses_data($input['nirvana_fpslider_bordersize']));
	
/** 3 ***/	
	$input['nirvana_columnNumber'] = intval(wp_kses_data($input['nirvana_columnNumber']));
	$input['nirvana_nrcolumns'] = intval(wp_kses_data($input['nirvana_nrcolumns']));
	$input['nirvana_colimageheight'] = intval(wp_kses_data($input['nirvana_colimageheight']));
	$input['nirvana_colspace'] = (abs(wp_kses_data($input['nirvana_colspace']))> 10 ? 10 : abs(wp_kses_data($input['nirvana_colspace'])));
	
/** 4 **/
	$input['nirvana_postboxes'] = wp_kses_post($input['nirvana_postboxes']);

	$resetDefault = ( ! empty( $input['nirvana_defaults']) ? true : false );

	if ($resetDefault) { $input = $nirvana_defaults; }
endif;

	return $input; // return validated input

}

endif;
?>