<?php
/* WPBakery Buttons */
add_action('vc_after_init', 'change_vc_button_colors');
function change_vc_button_colors()
{

	//Get current values stored in the color param in "Call to Action" element
	$param = WPBMap::getParam('vc_btn', 'color');

	// Add New Colors to the 'value' array
	// btn-custom-1 and btn-custom-2 are the new classes that will be 
	// applied to your buttons, and you can add your own style declarations
	// to your stylesheet to style them the way you want.
	$param['value'][__('Dark Theme BG', 'jevelinchild')] = 'dark-theme-bg';
	$param['value'][__('Light Theme BG', 'jevelinchild')] = 'light-theme-bg';
	$param['value'][__('Light Theme Link', 'jevelinchild')] = 'light-theme-link';
	$param['value'][__('White Link', 'jevelinchild')] = 'white-link';
	// Finally "update" with the new values
	vc_update_shortcode_param('vc_btn', $param);
}