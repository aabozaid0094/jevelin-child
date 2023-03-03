<?php
/**
 * Post Item - Service
 */
$image_size = ($args['image_size']) ? $args['image_size'] : 'medium';
$title_tag = ($args['title_tag']) ? $args['title_tag'] : 'h3';
$more_icon = ($args['more_icon']) ? $args['more_icon'] : '<i class="button-icon fa fa-long-arrow-left" aria-hidden="true"></i>';
$columns = ($args['columns']) ? $args['columns'] : 1;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?> <?php Jevelin_Schema::blog(); ?>>
	<div class="post-container-wrapper">
		<div class="<?php echo ($columns==1) ? 'container-fluid' : '' ; ?>">
			<div class="post-item">
				<?php if (get_the_post_thumbnail()) { ?>
					<div class="post-image">
						<?php echo get_the_post_thumbnail(get_the_ID(), $image_size); ?>
					</div>
				<?php } ?>
				<?php if (get_post_meta(get_the_ID(), 'icon', true)) { ?>
					<div class="post-icon">
						<?php echo wp_get_attachment_image( get_post_meta(get_the_ID(), 'icon', true), 'thumbnail', false, array('class'=>'original-image') ); ?>
						<?php echo wp_get_attachment_image( get_post_meta(get_the_ID(), 'second_icon', true), 'thumbnail', false, array('class'=>'hover-image') ); ?>
					</div>
				<?php } ?>
				<div class="post-info equalized-item-alt">
					<?php if (get_the_title()) { ?>
						<a class="post-title-link" href="<?php echo get_the_permalink(); ?>">
							<<?php echo $title_tag; ?> class="post-title equalized-item">
								<?php echo get_the_title(); ?>
							</<?php echo $title_tag; ?>>
						</a>
					<?php } ?>
					<?php if (get_the_excerpt()) { ?>
						<div class="post-excerpt">
							<?php echo get_the_excerpt(); ?>
						</div>
					<?php } ?>
					<a class="post-more-icon" href="<?php echo get_the_permalink(); ?>">
						<span><?php echo __("Read More", "jevelinchild"); ?></span>
						<?php echo $more_icon; ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</article>