<?php
/**
 * Post Item - Article
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
				<div class="post-image-wrapper">
					<?php if (get_post_meta(get_the_ID(), 'item_image', true)) { ?>
						<div class="post-image">
							<?php echo wp_get_attachment_image( get_post_meta(get_the_ID(), 'item_image', true), $image_size, false, array('class'=>'post-item-image') ); ?>
						</div>
					<?php } elseif (get_the_post_thumbnail()) { ?>
						<div class="post-image">
							<div class="post-image-overlay"></div>
							<?php echo get_the_post_thumbnail(get_the_ID(), $image_size); ?>
							<a class="post-more" href="<?php echo get_the_permalink(); ?>"><?php echo __("Read More", "jevelinchild"); ?></a>
						</div>
					<?php } ?>
					<?php if (get_post_meta(get_the_ID(), 'icon', true)) { ?>
						<div class="post-icon">
							<?php echo wp_get_attachment_image( get_post_meta(get_the_ID(), 'icon', true), 'thumbnail', false, array('class'=>'original-image') ); ?>
							<?php echo wp_get_attachment_image( get_post_meta(get_the_ID(), 'second_icon', true), 'thumbnail', false, array('class'=>'hover-image') ); ?>
						</div>
					<?php } ?>
					<div class="post-date">
						<time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished">
							<div class="day">
								<?php echo get_the_date("d"); ?>
							</div>
							<div class="month">
								<?php echo get_the_date("F"); ?>
							</div>
						</time>
					</div>
				</div>
				<div class="post-info equalized-item-alt">
					<div class="post-meta-pre">
						<?php if (get_the_author()) { ?>
							<div class="post-author">
								<?php echo get_the_author(); ?>
							</div>
						<?php } ?>
						<?php if (getPostViews(get_the_ID())) { ?>
							<div class="post-views">
								<?php echo getPostViews(get_the_ID()) . " " . __("View(s)", "jevelinchild"); ?>
							</div>
						<?php } ?>
					</div>
					<div class="post-meta">
						<?php
						if ($taxonomies = get_post_taxonomies()) {
							$terms_names = ''; $terms = get_the_terms(get_the_ID(), $taxonomies[0]);
							$length = count($terms);
							foreach($terms as $index => $term){
								$separator = ($index==$length-1)?'':', ';
								$terms_names .= $term->name . $separator; 
								unset($term);
							}
							?>
							<div class="post-type">
								<i class="fa fa-tag" aria-hidden="true"></i>
								<span><?php echo $terms_names; ?></span>
							</div>
						<?php } ?>
						<div class="post-comments">
							<i class="fa fa-comments-o" aria-hidden="true"></i>
							<span><?php echo get_comments_number(); ?></span>
						</div>
					</div>
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
					<div class="more-minutes-wrapper">
						<a class="post-more-icon" href="<?php echo get_the_permalink(); ?>">
							<span><?php echo __("Read More", "jevelinchild"); ?></span>
							<?php echo $more_icon; ?>
						</a>
						<?php if (get_the_content()) { ?>
							<div class="content-minutes">
								<?php echo content_in_minutes_text(get_the_ID()); ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</article>