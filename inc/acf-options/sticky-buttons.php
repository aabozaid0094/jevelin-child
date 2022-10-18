<?php
function sticky_buttons()
{
	$sticky_buttons_toggle = get_field('sticky_buttons_toggle', 'option');
	if ($sticky_buttons_toggle) {
		$sticky_buttons = get_field('sticky_buttons', 'option');
		$sticky_buttons_active = get_field('sticky_buttons_active', 'option');
		$sticky_buttons_position = get_field('sticky_buttons_position', 'option');
		$sticky_buttons_size = get_field('sticky_buttons_size', 'option');
		$sticky_buttons_shape = get_field('sticky_buttons_shape', 'option');
		$sticky_buttons_hidden_active = get_field('sticky_buttons_hidden_active', 'option');
		$sticky_buttons_toggler_icon = '<svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1683 1331l-166 165q-19 19-45 19t-45-19l-531-531-531 531q-19 19-45 19t-45-19l-166-165q-19-19-19-45.5t19-45.5l742-741q19-19 45-19t45 19l742 741q19 19 19 45.5t-19 45.5z"/></svg>';
		$hidden_index = 0;
		if ($sticky_buttons) {
			echo '<div class="sticky-buttons';
			if ($sticky_buttons_active) {
				echo ' active';
			}
			if ($sticky_buttons_position) {
				echo ' ' . $sticky_buttons_position;
			}
			if ($sticky_buttons_size) {
				echo ' ' . $sticky_buttons_size;
			}
			if ($sticky_buttons_shape) {
				echo ' ' . $sticky_buttons_shape;
			}
			echo '">';
			foreach ($sticky_buttons as $index => $sticky_button) {
				echo '<a ';
				if ($sticky_button['link_element_class']) {
					echo 'class="' . $sticky_button['link_element_class'] . '" ';
				}
				if ($sticky_button['link_href']) {
					echo 'href="' . $sticky_button['link_href'] . '" ';
				}
				if ($sticky_button['link_target']) {
					echo 'target="' . $sticky_button['link_target'] . '" ';
				}
				if ($sticky_button['has_hidden_data']) {
					echo 'hidden-data-id="hidden-data-' . $index . '" ';
				}
				if (!$sticky_buttons_active) {
					echo 'style="display:none"';
				}
				echo '>';
				echo $sticky_button['icon'];
				echo '</a>';

				if ($sticky_button['has_hidden_data']) {
					if ($sticky_button['hidden_data']) {
						$hidden_index++;
						$active = ( ($hidden_index == 1) && ($sticky_buttons_active) && ($sticky_buttons_hidden_active) ) ? ' active': '';
						echo '<div class="hidden-data' . $active . '" hidden-data-id="hidden-data-' . $index . '">';
						echo $sticky_button['hidden_data'];
						echo '</div>';
					}
				}
			}
			echo '<a id="sticky_toggler" class="sticky_toggler" href="#">' . $sticky_buttons_toggler_icon . '</a>';
			echo '</div>';
		}
	}
}
add_action('wp_footer', 'sticky_buttons');