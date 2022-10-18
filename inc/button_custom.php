<?php
add_shortcode('button_custom', 'button_custom');
function button_custom($atts)
{
    static $button_custom_id = 0;
    $attributes = shortcode_atts( array(
		'button_info' => '',
		'button_title' => '',
		'button_link' => '',
		'dark' => false,
		'transparent' => false,
		'button_icon_classes' => '',
		'extra_classes' => 'button-item',
	), $atts );
    $html = '';
    $button_info = $attributes['button_info'];
    $button_title = $attributes['button_title'];
    $button_link = $attributes['button_link'];
    $button_link = (!empty($button_link))?vc_build_link($button_link):'';
    $button_icon_classes = ' ' . $attributes['button_icon_classes'];
    $extra_classes = ' ' . $attributes['extra_classes'];
    $dark = filter_var( $attributes['dark'], FILTER_VALIDATE_BOOLEAN );
    $transparent = filter_var( $attributes['transparent'], FILTER_VALIDATE_BOOLEAN );
    if ($dark) $extra_classes .= ' dark';
    if ($transparent) $extra_classes .= ' transparent';
    ob_start();
	echo '<a class="button-item button-item-' . $button_custom_id . $extra_classes .
    (($button_link['url'])?('" href="' .$button_link['url']):'') .
    ( ($button_title)?('" title="'.$button_title) : ( ($button_link['title']) ? ('" title="'.$button_link['title']):'' ) ) .
    (($button_link['target'])?('" target="' .$button_link['target']):'') .
    (($button_link['rel'])?('" rel="' .$button_link['rel']):'') .
    '">';
        echo ($button_icon_classes&&!ctype_space($button_icon_classes)) ? '<i class="button-icon' . $button_icon_classes . '"></i>':'';
        echo '<span class="button-info-box">';
            echo ($button_info) ? '<span class="button-info">' . $button_info . '</span>':'';
            echo ($button_title) ? '<span class="button-title">' . $button_title . '</span>':'';
        echo '</span>';
	echo '</a>';
    $html = ob_get_clean();
    
    wp_enqueue_style('button-custom-css', get_stylesheet_directory_uri() . '/css/button-custom.css');
    
    $button_custom_id++;
    
    return $html;
}

//Integrate With VC
add_action('vc_before_init', 'button_custom_integrateWithVC');
function button_custom_integrateWithVC()
{
	vc_map(array(
        "name" => __("Button Custom", "jevelinchild"),
        "base" => "button_custom",
        "description" => __("Button Custom", "jevelinchild"),
        "show_settings_on_create" => true,
        "category" => __("Content", "jevelinchild"),
        
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Info", "jevelinchild"),
                "param_name" => "button_info",
                "value" => "",
                "group" => "Data",
            ),
			array(
				"type" => "textfield",
                "heading" => __("Title", "jevelinchild"),
                "param_name" => "button_title",
                "value" => "",
                "group" => "Data",
                'admin_label' => true,
            ),
			array(
                "type" => "vc_link",
                "heading" => __("Link", "jevelinchild"),
                "param_name" => "button_link",
                "value" => "#",
                "group" => "Data",
                'admin_label' => true,
            ),
            array(
                "type" => "checkbox",
                "heading" => __("Dark", "jevelinchild"),
                "param_name" => "dark",
                "value" => false,
                "description" => __("Dark Button Instead of Light Button", "jevelinchild"),
                "group" => "Structure",
                'admin_label' => true,
            ),
            array(
                "type" => "checkbox",
                "heading" => __("Transparent", "jevelinchild"),
                "param_name" => "transparent",
                "value" => false,
                "description" => __("Transparent Button Instead of Colored Background", "jevelinchild"),
                "group" => "Structure",
                'admin_label' => true,
            ),
            array(
                "type" => "textfield",
                "heading" => __("Icon Classes", "jevelinchild"),
                "param_name" => "button_icon_classes",
                "value" => "",
                "group" => "Structure",
                'admin_label' => true,
            ),
            array(
                "type" => "textfield",
                "heading" => __("Extra Classes", "jevelinchild"),
                "param_name" => "extra_classes",
                "value" => "button-item",
                "description" => __("Extra Classes to be Added to The Component, Separated with spaces ' '", "jevelinchild"),
                "group" => "Structure",
            ),
        ),
    ));
}