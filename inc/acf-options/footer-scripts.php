<?php
function footer_scripts()
{
	$head_footer_scripts_toggle = get_field('head_footer_scripts_toggle', 'option');
	if (!$head_footer_scripts_toggle) { return; }
	$general_footer_scripts_toggle = get_field('footer_scripts_toggle', 'option');
	if ($general_footer_scripts_toggle) {
		$general_footer_scripts = get_field('footer_scripts', 'option');
		if ($general_footer_scripts) {
			foreach ($general_footer_scripts as $general_footer_script) {
				if ($general_footer_script['toggle'] && $general_footer_script['script']) {
					echo $general_footer_script['script'];
				}
			}
		}
	}
	$singular_footer_scripts_toggle = get_field('footer_scripts_toggle');
	if ($singular_footer_scripts_toggle) {
		$singular_footer_scripts = get_field('footer_scripts');
		if ($singular_footer_scripts) {
			foreach ($singular_footer_scripts as $singular_footer_script) {
				if ($singular_footer_script['toggle'] && $singular_footer_script['script']) {
					echo $singular_footer_script['script'];
				}
			}
		}
	}
}
add_action('wp_footer', 'footer_scripts');