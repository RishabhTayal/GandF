<?php 
/**
 * @package Simpleo
 */
?>
<div class="post-info">
	<?php if(has_post_format('image')) {?>
		<span><i class="fa fa-camera"></i><a href="<?php printf(esc_url( get_post_format_link( 'image' ))); ?>"><?php printf( __('Image','simpleo')); ?></a></span>
	<?php } elseif(has_post_format('gallery')) {?>
		<span><i class="fa fa-picture-o"></i><a href="<?php printf(esc_url( get_post_format_link( 'gallery' ))); ?>"><?php printf( __('Gallery','simpleo')); ?></a></span>
	<?php } elseif(has_post_format('video')) {?>
		<span><i class="fa fa-video-camera"></i><a href="<?php printf(esc_url( get_post_format_link( 'video' ))); ?>"><?php printf( __('Video','simpleo')); ?></a></span>
	<?php } elseif(has_post_format('quote')) {?>
		<span><i class="fa fa-quote-left"></i><a href="<?php printf(esc_url( get_post_format_link( 'quote' ))); ?>"><?php printf( __('Quote','simpleo')); ?></a></span>
	<?php } elseif(has_post_format('link')) {?>
		<span><i class="fa fa-chain-broken"></i><a href="<?php printf(esc_url( get_post_format_link( 'link' ))); ?>"><?php printf( __('Link','simpleo')); ?></a></span>
	<?php } elseif(has_post_format('aside')) {?>
		<span><i class="fa fa-file-text"></i><a href="<?php printf(esc_url( get_post_format_link( 'aside' ))); ?>"><?php printf( __('Aside','simpleo')); ?></a></span>
	<?php } elseif(has_post_format('audio')) {?>
		<span><i class="fa fa-music"></i><a href="<?php printf(esc_url( get_post_format_link( 'audio' ))); ?>"><?php printf( __('Audio','simpleo')); ?></a></span>
	<?php } elseif(has_post_format('chat')) {?>
		<span><i class="fa fa-comments"></i><a href="<?php printf(esc_url( get_post_format_link( 'chat' ))); ?>"><?php printf( __('Chat','simpleo')); ?></a></span>
	<?php } else {?>
		<span><i class="fa fa-thumb-tack"></i><?php printf( __('Standard','simpleo')); ?></span>
	<?php } ?>
	<span class="separator"> / </span>
	<span><i class="fa fa-user"></i><?php _e('by ','simpleo'); printf(esc_url(the_author_posts_link())); ?> </span>
	<span class="separator"> / </span>
	<span><i class="fa fa-calendar"></i><?php printf(esc_attr( get_the_date())); ?> </span>
	<span class="separator"> / </span>
	<span><i class="fa fa-comment-o"></i><a href="<?php comments_link(); ?>"><?php comments_number( __('No Comments','simpleo'), __('1 Comment','simpleo'), __('% Comments','simpleo')); ?></a></span>
</div>