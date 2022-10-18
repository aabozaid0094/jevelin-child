<?php
function head_scripts()
{
	$head_footer_scripts_toggle = get_field('head_footer_scripts_toggle', 'option');
	if (!$head_footer_scripts_toggle) { return; }
	$general_head_scripts_toggle = get_field('head_scripts_toggle', 'option');
	if ($general_head_scripts_toggle) {
		$general_head_scripts = get_field('head_scripts', 'option');
		if ($general_head_scripts) {
			foreach ($general_head_scripts as $general_head_script) {
				if ($general_head_script['toggle'] && $general_head_script['script']) {
					echo $general_head_script['script'];
				}
			}
		}
	}
	$singular_head_scripts_toggle = get_field('head_scripts_toggle');
	if ($singular_head_scripts_toggle) {
		$singular_head_scripts = get_field('head_scripts');
		if ($singular_head_scripts) {
			foreach ($singular_head_scripts as $singular_head_script) {
				if ($singular_head_script['toggle'] && $singular_head_script['script']) {
					echo $singular_head_script['script'];
				}
			}
		}
	}
}
add_action('wp_head', 'head_scripts');