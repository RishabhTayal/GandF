<?php 
/**
 * @package Simpleo
 */
?>
<div <?php post_class('post-wrapper'); ?>>
			<?php if (of_get_option('enable_breadcrumbs') == '1') { ?>
				<div class="breadcrumbs">
					<div class="breadcrumbs-wrap"> 
						<?php get_template_part( 'breadcrumbs'); ?>
					</div><!--breadcrumbs-wrap-->
				</div><!--breadcrumbs-->
			<?php } ?>	
	<?php get_template_part( 'post', 'formats');?>
</div>