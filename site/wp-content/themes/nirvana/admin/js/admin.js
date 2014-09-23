/*!
 * Admin js
 */

jQuery(document).ready(function() {

var uploadparent = 0;
 function media_upload( button_class) {
    var _custom_media = true,
    _orig_send_attachment = wp.media.editor.send.attachment;
    jQuery('body').on('click',button_class, function(e) {
	uploadparent = jQuery(this).closest('div');
        var button_id ='#'+jQuery(this).attr('id');
        /* console.log(button_id); */
        var self = jQuery(button_id);
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = jQuery(button_id);
       // var id = button.attr('id').replace('_button', '');
        _custom_media = true;
        wp.media.editor.send.attachment = function(props, attachment){
            if ( _custom_media  ) {
              // jQuery('.custom_media_id').val(attachment.id); 		  
               uploadparent.find('.slideimages').val(attachment.url);
			   uploadparent.find('.imagebox').attr('src',attachment.url);
              // jQuery('.custom_media_image').attr('src',attachment.url).css('display','block');   
            } else {
                return _orig_send_attachment.apply( button_id, [props, attachment] );
            }
        }
        wp.media.editor.open(button);
        return false;
    });
}
media_upload( '.upload_image_button');		


/* Show/hide postboxes by adding a 'closed' class */
if  (jQuery('#nirvana-postboxes').length > 0) {
	saved_arr = jQuery('#nirvana-postboxes').val().split(",");
    var data = {
        action: 'feed_action',
    };

if (jQuery.inArray('nirvana-news',saved_arr) == -1) {
	jQuery.post(ajaxurl, data, function(response) {
		jQuery("#nirvana-news .inside").html(response);
    });
}
saved_arr.forEach(function(entry) {
	jQuery('#'+entry).addClass('closed');
});
var values_arr = saved_arr;
jQuery('.postbox .handlediv').click(function() {
	postbox = jQuery(this).parent();
	if (postbox.hasClass('closed')) {
		postbox.removeClass('closed');	
		var i = values_arr.indexOf(postbox.attr('id'));
		if(i != -1) { 
			values_arr.splice(i, 1);
			}	
			/* ajax for nirvana-news */

    jQuery.post(ajaxurl, data, function(response) {
        jQuery("#nirvana-news .inside").html(response);
    });
		}
	else {
		postbox.addClass('closed');
		if (jQuery.inArray(postbox.attr('id'),values_arr) == -1) {
			values_arr.push(postbox.attr('id')); 
			}
		}
	jQuery('#nirvana-postboxes').val(values_arr.join()); 
});
	}		
			
// Show/hide slides
		jQuery('.slidetitle').click(function() {
				jQuery(this).next().toggle("fast");
				});


// Jquery confim window on reset to defaults
jQuery('#nirvana_defaults').click (function() {
		if (!confirm(reset_confirmation)) { return false;}
	});

// Jquery confim window on loading a color scheme
jQuery('#load-color-scheme').click (function() {
		if (!confirm(scheme_confirmation)) { return false;}
	});


// Hide or show slider settings
jQuery('#nirvana_slideType').change(function() {
	jQuery('.slideDivs').hide();
	switch (jQuery('#nirvana_slideType option:selected').val()) {

		case "Custom Slides" :
 		jQuery('#sliderCustomSlides').show("normal");
		break;

		case "Latest Posts" :
 		jQuery('#sliderLatestPosts').show("normal");
		break;

		case "Random Posts" :
 		jQuery('#sliderRandomPosts').show("normal");
		break;

		case "Sticky Posts" :
 		jQuery('#sliderStickyPosts').show("normal");
		break;

		case "Latest Posts from Category" :
 		jQuery('#sliderLatestCateg').show("normal");
		break;

		case "Random Posts from Category" :
 		jQuery('#sliderRandomCateg').show("normal");
		break;

		case "Specific Posts" :
 		jQuery('#sliderSpecificPosts').show("normal");
		break;

	}//switch
	
	sliderNr=jQuery('#nirvana_slideType').val();
	//Show category if a category type is selected
	if (sliderNr=="Latest Posts from Category" || sliderNr=="Random Posts from Category" )
			jQuery('#slider-category').show();
	else 	jQuery('#slider-category').hide();
	//Show number of slides if that's the case
	if (sliderNr=="Latest Posts" || sliderNr =="Random Posts" || sliderNr =="Sticky Posts" || sliderNr=="Latest Posts from Category" || sliderNr=="Random Posts from Category" )
			jQuery('#slider-post-number').show();
	else 	jQuery('#slider-post-number').hide();

});//function

jQuery('.slideDivs').hide();
jQuery('#nirvana_slideType').trigger('change');



// Hide or show column settings
jQuery('#nirvana_columnType').change(function() {
	jQuery('.columnDivs').hide();
	switch (jQuery('#nirvana_columnType option:selected').val()) {

		case "Widget Columns" :
 		jQuery('#columnWidgets').show("normal");
		break;

		case "Latest Posts" :
 		jQuery('#columnLatestPosts').show("normal");
		break;

		case "Random Posts" :
 		jQuery('#columnRandomPosts').show("normal");
		break;

		case "Sticky Posts" :
 		jQuery('#columnStickyPosts').show("normal");
		break;

		case "Latest Posts from Category" :
 		jQuery('#columnLatestCateg').show("normal");
		break;

		case "Random Posts from Category" :
 		jQuery('#columnRandomCateg').show("normal");
		break;

		case "Specific Posts" :
 		jQuery('#columnSpecificPosts').show("normal");
		break;

	}//switch
	
	columnNr=jQuery('#nirvana_columnType').val();
	//Show category if a category type is selected
	if (columnNr=="Latest Posts from Category" || columnNr=="Random Posts from Category" )
			jQuery('#column-category').show();
	else 	jQuery('#column-category').hide();
	//Show number of columns if that's the case
	if (columnNr=="Latest Posts" || columnNr =="Random Posts" || columnNr =="Sticky Posts" || columnNr=="Latest Posts from Category" || columnNr=="Random Posts from Category" )
			jQuery('#column-post-number').show();
	else 	jQuery('#column-post-number').hide();

});//function

jQuery('.columnDivs').hide();
jQuery('#nirvana_columnType').trigger('change');

//var nirvana_customcss = CodeMirror.fromTextArea(document.getElementById("nirvana_customcss"), { lineNumbers: true });
//var nirvana_customjs = CodeMirror.fromTextArea(document.getElementById("nirvana_customjs"), { lineNumbers: true });

// Create accordion from existing settings table
	jQuery('.form-table').wrap('<div>');
	jQuery(function() {
			jQuery( "#accordion" ).accordion({
				header: 'h3',
				autoHeight: false, // for jQueryUI <1.10
				heightStyle: "content", // required in jQueryUI 1.10
				collapsible: true,
				navigation: true,
				active: parseInt(jQuery('#nirvana_current').val()),
				});
	});

	jQuery("#nirvana_nrcolumns").bind('change', function() {
		column_image_width_hint(jQuery("#totalsize").html(),jQuery("#nirvana_nrcolumns").val());
	});										
	jQuery("#nirvana_nrcolumns").trigger('change');
	
	googleFontChange('.googlefonts');
	//save_main_options_ajax();	
	colorThingy();
	jQuery('#accordion h3').each(function() {
	jQuery(this).html('<div class="admin-menu">' + jQuery(this).text() + '</div>')
	});
		jQuery('#accordion h3').on('click',function() {
	var clicked = parseInt(jQuery(this).attr('id').replace( /^\D+/g, ''));
	var current = parseInt(jQuery('#nirvana_current').val().replace( /^\D+/g, ''));
	if (clicked == current) jQuery('#nirvana_current').val('');
	else jQuery('#nirvana_current').val(clicked);
	});
	

});// ready



// Save settings via Ajax
	function save_main_options_ajax() {
           jQuery('#nirvana_sumbit').click( function (event) {
				event.preventDefault();
				jQuery('#loading-big').css('display','block');
                var b =  jQuery('#nirvana_form').serialize();
                jQuery.post( 'options.php', b ).error( 
                    function() {
                        alert('error');
                    }).success( function() {
					jQuery('#loading-big').css('display','none');
					jQuery('#settings-saved').remove();
					jQuery('body').append('<div id="settings-saved"><span>Settings Saved</span></div>');
                    });
                    return false;    
                });
            }
  
// Columns image width hint
function column_image_width_hint(total, colcount) {
total=total;
if (colcount==0) var size = 0;
else 
	var size = parseInt((total)/colcount);

jQuery('#nirvana_colimagewidth_show').html(size);
jQuery('#nirvana_colimagewidth').val(size);

}

  // Change border for selecte inputs
function changeBorder (idName, className) {
	jQuery('.'+className).removeClass( 'checkedClass' );
	jQuery('.'+className).removeClass( 'borderful' );
	jQuery('#'+idName).addClass( 'borderful' );

return 0;
}

// Chnage opacity for font selector if google font exisits

function colorThingy() {
jQuery('.colorthingy').click(function() {
if (!jQuery(this).val()) jQuery(this).val(' ');
});

}

function googleFontChange(googleFont) {
jQuery(googleFont).each(function(){
if(jQuery(this).val()) {jQuery(this).prev().css('opacity','0.5');}
});

jQuery(googleFont).blur(function() {
	if(jQuery(this).val()) jQuery(this).prev().animate({'opacity':'0.5'},300);
	else jQuery(this).prev().animate({'opacity':'1'},300);
	});
}