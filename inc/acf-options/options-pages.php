<?php
if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title'     => 'Custom Options',
		'menu_title'    => 'Custom Options',
		'menu_slug'     => 'custom-options',
		'capability'    => 'edit_posts',
		'icon_url' => 'dashicons-admin-generic',
		'redirect'        => true
	));
	acf_add_options_sub_page(array(
		'page_title'     => 'Sticky Buttons',
		'menu_title'    => 'Sticky Buttons',
		'menu_slug'     => 'sticky-buttons',
        'parent_slug'	=> 'custom-options',
		'capability'    => 'edit_posts',
		'icon_url' => 'dashicons-pressthis',
	));
    acf_add_options_sub_page(array(
		'page_title'     => 'Testimonials',
		'menu_title'    => 'Testimonials',
		'menu_slug'     => 'testimonials',
        'parent_slug'	=> 'custom-options',
		'capability'    => 'edit_posts',
		'icon_url' => 'dashicons-testimonial',
	));
    acf_add_options_sub_page(array(
		'page_title'     => 'Head Footer Scripts',
		'menu_title'    => 'Head Footer Scripts',
		'menu_slug'     => 'head-footer-scripts',
        'parent_slug'	=> 'custom-options',
		'capability'    => 'edit_posts',
		'icon_url' => 'dashicons-welcome-write-blog',
	));
    acf_add_options_sub_page(array(
		'page_title'     => 'Widget Areas',
		'menu_title'    => 'Widget Areas',
		'menu_slug'     => 'widget-areas',
        'parent_slug'	=> 'custom-options',
		'capability'    => 'edit_posts',
		'icon_url' => 'dashicons-welcome-widgets-menus',
	));
}