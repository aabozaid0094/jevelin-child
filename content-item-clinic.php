<?php
/**
 * Post Item - Clinic
 */
$image_size = ($args['image_size']) ? $args['image_size'] : 'medium';
$title_tag = ($args['title_tag']) ? $args['title_tag'] : 'h3';
$more_icon = ($args['more_icon']) ? $args['more_icon'] : '<i class="button-icon fa fa-long-arrow-left" aria-hidden="true"></i>';
$columns = ($args['columns']) ? $args['columns'] : 1;
?>
<div class="post-container-wrapper">
	<div class="<?php echo ($columns==1) ? 'container-fluid' : '' ; ?>">
		<?php
			echo '<div class="clinic-item clinic-item-' . get_the_ID() . ' equalized-item">';
				echo '<h4 class="clinic-title">' . get_the_title() . '</h4>';
				$clinic_location = get_post_meta(get_the_ID(), 'location', true);
				$clinic_location_url = get_post_meta(get_the_ID(), 'location_url', true);
				if ($clinic_location) {
					echo '<div class="clinic-location">';
						echo ($clinic_location_url) ? '<a href="' . $clinic_location_url . '">' : '';
							echo $clinic_location;
						echo ($clinic_location_url) ? '</a>' : '';
					echo '</div>';
				}
				$clinic_phone = get_post_meta(get_the_ID(), 'phone', true);
				$clinic_phone_url = get_post_meta(get_the_ID(), 'phone_url', true);
				if ($clinic_phone) {
					echo '<div class="clinic-phone">';
						echo ($clinic_phone_url) ? '<a href="' . $clinic_phone_url . '">' : '';
							echo $clinic_phone;
						echo ($clinic_phone_url) ? '</a>' : '';
					echo '</div>';
				}
			echo '</div>';
		?>
	</div>
</div>