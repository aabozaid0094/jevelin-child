<?php
/**
 * Post Item - Testimonial
 */
$image_size = ($args['image_size']) ? $args['image_size'] : 'medium';
$title_tag = ($args['title_tag']) ? $args['title_tag'] : 'h3';
$more_icon = ($args['more_icon']) ? $args['more_icon'] : '<i class="button-icon fa fa-long-arrow-left" aria-hidden="true"></i>';
$columns = ($args['columns']) ? $args['columns'] : 1;
?>
<div class="post-container-wrapper">
	<div class="<?php echo ($columns==1) ? 'container-fluid' : '' ; ?>">
		<?php
			echo '<div class="testimonial-item testimonial-item-' . get_the_ID() . ' equalized-item">';
				if (get_post_meta(get_the_ID(), 'quote', true)) {
					echo '<div class="testimonial-quote">' .  get_post_meta(get_the_ID(), 'quote', true) . '</div>';
				}
				echo '<div class="testimonial-person">';
					echo '<div class="testimonial-image">' . get_the_post_thumbnail(get_the_ID(), "thumbnail") . '</div>';
					echo '<div class="testimonial-textual-info">';
						echo '<h4 class="testimonial-title">' . get_the_title() . '</h4>';
						if (get_post_meta(get_the_ID(), 'info', true)) {
							echo '<div class="testimonial-info">' .  get_post_meta(get_the_ID(), 'info', true) . '</div>';
						}
						if (get_post_meta(get_the_ID(), 'stars_count', true)) {
							echo '<div class="testimonial-stars active' . get_post_meta(get_the_ID(), 'stars_count', true) . '">' . str_repeat('<i class="fa fa-star"></i>', 5) . '</div>'; 
						}
					echo '</div>';
				echo '</div>';
			echo '</div>';
		?>
	</div>
</div>