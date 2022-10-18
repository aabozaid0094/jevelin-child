<?php
add_shortcode('featurebox_item', 'featurebox_item');
function featurebox_item($atts)
{
    static $featurebox_item_id = 0;
    $attributes = shortcode_atts( array(
		'featurebox_count' => '',
		'featurebox_title' => '',
		'featurebox_info' => '',
		'featurebox_color' => '',
		'extra_classes' => 'featurebox-item',
	), $atts );
    $html = '';
    $featurebox_count = $attributes['featurebox_count'];
    $featurebox_title = $attributes['featurebox_title'];
    $featurebox_info = $attributes['featurebox_info'];
    $featurebox_color = $attributes['featurebox_color'];
    $extra_classes = ' ' . $attributes['extra_classes'];
    ob_start();
	echo '<div class="featurebox-item featurebox-item-' . $featurebox_item_id . $extra_classes . '">';
		echo '<style media="screen">.featurebox-item-' . $featurebox_item_id . ' .featurebox-count{color:' . $featurebox_color . ';}' . '</style>';
		echo '<div class="featurebox-count">' . $featurebox_count . '</div>';
        echo '<div class="featurebox-title-info">';
            echo '<h4 class="featurebox-title">' . $featurebox_title . '</h4>';
            echo '<div class="featurebox-info">' . $featurebox_info . '</div>';
	    echo '</div>';
	echo '</div>';
    $html = ob_get_clean();
    
    $featurebox_item_id++;
    
    return $html;
}

//Integrate With VC
add_action('vc_before_init', 'featurebox_item_integrateWithVC');
function featurebox_item_integrateWithVC()
{
	vc_map(array(
        "name" => __("Featurebox Item", "jevelinchild"),
        "base" => "featurebox_item",
        "description" => __("Featurebox Item", "jevelinchild"),
        // "custom_markup" => '<h4 class="wpb_element_title"> <i class="vc_general vc_element-count"></i> {{name}}</h4><div>"{{ params.featurebox_count }}"</div>',
        "show_settings_on_create" => true,
        "category" => __("Content", "jevelinchild"),
        
        "params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Count", "jevelinchild"),
				"param_name" => "featurebox_count",
                "value" => "",
                "group" => "Data",
                'admin_label' => true,
			),
			array(
				"type" => "textfield",
                "heading" => __("Title", "jevelinchild"),
                "param_name" => "featurebox_title",
                "value" => "",
                "group" => "Data",
                'admin_label' => true,
            ),
			array(
				"type" => "textarea",
                "heading" => __("Info", "jevelinchild"),
                "param_name" => "featurebox_info",
                "value" => "",
                "group" => "Data",
            ),
            array(
                "type" => "colorpicker",
                "heading" => __("Color", "jevelinchild"),
                "param_name" => "featurebox_color",
                "group" => "Structure",
            ),
            array(
                "type" => "textfield",
                "heading" => __("Extra Classes", "jevelinchild"),
                "param_name" => "extra_classes",
                "value" => "featurebox-item",
                "description" => __("Extra Classes to be Added to The Component, Separated with spaces ' '", "jevelinchild"),
                "group" => "Structure",
            ),
        ),
    ));
}