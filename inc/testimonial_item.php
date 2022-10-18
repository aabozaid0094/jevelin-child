<?php
add_shortcode('testimonial_item', 'testimonial_item');
function testimonial_item($atts)
{
    static $testimonial_item_id = 0;
    $attributes = shortcode_atts( array(
		'testimonial_image_id' => '',
		'testimonial_title' => '',
		'testimonial_info' => '',
		'testimonial_stars' => '5',
		'testimonial_quote' => '',
		'testimonial_quote_watermark_id' => '',
		'extra_classes' => 'testimonial-item',
	), $atts );
    $html = '';
    $testimonial_image_id = intval($attributes['testimonial_image_id']);
    $image_size = 'thumbnail';
    $testimonial_image = wp_get_attachment_image( $testimonial_image_id, $image_size);
    $testimonial_title = $attributes['testimonial_title'];
    $testimonial_info = $attributes['testimonial_info'];
    $testimonial_stars = intval($attributes['testimonial_stars']);
    $testimonial_quote = $attributes['testimonial_quote'];
    $testimonial_quote_watermark_id = intval($attributes['testimonial_quote_watermark_id']);
    $quote_watermark_image_size = 'thumbnail';
    $testimonial_quote_watermark = wp_get_attachment_image( $testimonial_quote_watermark_id, $quote_watermark_image_size);
    $extra_classes = ' ' . $attributes['extra_classes'];
    ob_start();
	echo '<div class="testimonial-item testimonial-item-' . $testimonial_item_id . $extra_classes . '">';
		echo '<div class="testimonial-image">' . $testimonial_image . '</div>';
		echo '<h4 class="testimonial-title">' . $testimonial_title . '</h4>';
		echo '<h5 class="testimonial-info">' . $testimonial_info . '</h5>';
		echo '<div class="testimonial-stars active' . $testimonial_stars . '">' . str_repeat('<i class="fa fa-star"></i>', 5) . '</div>';
		echo '<div class="testimonial-quote">' . $testimonial_quote . '</div>';
		echo '<div class="testimonial-quote-watermark">' . $testimonial_quote_watermark . '</div>';
	echo '</div>';
    $html = ob_get_clean();
    
    $testimonial_item_id++;
    
    return $html;
}

//Integrate With VC
add_action('vc_before_init', 'testimonial_item_integrateWithVC');
function testimonial_item_integrateWithVC()
{
	vc_map(array(
        "name" => __("Testimonial Item", "jevelinchild"),
        "base" => "testimonial_item",
        "description" => __("Testimonial Item", "jevelinchild"),
        "show_settings_on_create" => true,
        "category" => __("Content", "jevelinchild"),
        
        "params" => array(
			array(
				"type" => "attach_image",
				"heading" => __("Image", "jevelinchild"),
				"param_name" => "testimonial_image_id",
				"group" => "Data",
			),
			array(
				"type" => "textfield",
                "heading" => __("Title", "jevelinchild"),
                "param_name" => "testimonial_title",
                "value" => "",
                "group" => "Data",
            ),
			array(
				"type" => "textfield",
                "heading" => __("Info", "jevelinchild"),
                "param_name" => "testimonial_info",
                "value" => "",
                "group" => "Data",
            ),
			array(
				"type" => "dropdown",
				"heading" => __("Number Of Stars", "jevelinchild"),
				"param_name" => "testimonial_stars",
				"value" => range(1, 5),
				"group" => "Data",
			),
            array(
                "type" => "textarea",
                "heading" => __("Quote", "jevelinchild"),
                "param_name" => "testimonial_quote",
                "value" => '',
                "group" => "Data",
            ),
			array(
				"type" => "attach_image",
				"heading" => __("Quote Watermark", "jevelinchild"),
				"param_name" => "testimonial_quote_watermark_id",
				"group" => "Data",
			),
            array(
                "type" => "textfield",
                "heading" => __("Extra Classes", "jevelinchild"),
                "param_name" => "extra_classes",
                "value" => "testimonial-item",
                "description" => __("Extra Classes to be Added to The Component, Separated with spaces ' '", "jevelinchild"),
                "group" => "Structure",
            ),
        ),
    ));
}