<?php
add_shortcode('post_meta_item', 'post_meta_item');
function post_meta_item($atts)
{
    static $post_meta_item_id = 0;
    $attributes = shortcode_atts( array(
		'meta_post_id' => 0,
		'meta_key' => '',
		'meta_is_single' => false,
		'meta_is_image_id' => false,
		'meta_image_size' => 'thumbnail',
		'extra_classes' => 'meta-item',
	), $atts );
    $html = '';
    global $post;
    $meta_post_id = empty($attributes['meta_post_id']) ? $post->ID : intval($attributes['meta_post_id']);
    $meta_key = $attributes['meta_key'];
    $meta_is_single = filter_var( $attributes['meta_is_single'], FILTER_VALIDATE_BOOLEAN );
    $meta_is_image_id = filter_var( $attributes['meta_is_image_id'], FILTER_VALIDATE_BOOLEAN );
    $meta_image_size = $attributes['meta_image_size'];
    $meta_value = get_post_meta($meta_post_id, $meta_key, $meta_is_single);
    $extra_classes = ' ' . $attributes['extra_classes'];
    $meta_content = ($meta_is_image_id) ? 
    wp_get_attachment_image( intval($meta_value), $meta_image_size, false, array('class'=>'meta-item-image meta-item-' . $post_meta_item_id . $extra_classes) ) : 
    '<div class="meta-item meta-item-' . $post_meta_item_id . $extra_classes . '">' . $meta_value . '</div>';


    ob_start();
	echo $meta_content;
    $html = ob_get_clean();
    
    $post_meta_item_id++;
    
    return $html;
}

//Integrate With VC
add_action('vc_before_init', 'post_meta_item_integrateWithVC');
function post_meta_item_integrateWithVC()
{
	vc_map(array(
        "name" => __("Post Meta Item", "jevelinchild"),
        "base" => "post_meta_item",
        "description" => __("Post Meta Item", "jevelinchild"),
        "show_settings_on_create" => true,
        "category" => __("Content", "jevelinchild"),
        
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Post ID", "jevelinchild"),
                "param_name" => "meta_post_id",
                "value" => 0,
                "description" => __("Leave it blank to get current post ID", "jevelinchild"),
                "group" => "Data",
                'admin_label' => true,
            ),
			array(
				"type" => "textfield",
                "heading" => __("Meta Key", "jevelinchild"),
                "param_name" => "meta_key",
                "value" => "",
                "group" => "Data",
                'admin_label' => true,
            ),
            array(
                "type" => "checkbox",
                "heading" => __("Meta Is Single", "jevelinchild"),
                "param_name" => "meta_is_single",
                "value" => false,
                "description" => __("Toggle Arrows", "jevelinchild"),
                "group" => "Data",
                'admin_label' => true,
            ),
            array(
                "type" => "checkbox",
                "heading" => __("Meta Is Image", "jevelinchild"),
                "param_name" => "meta_is_image_id",
                "value" => false,
                "description" => __("Toggle Arrows", "jevelinchild"),
                "group" => "Data",
                'admin_label' => true,
            ),
			array(
				"type" => "dropdown",
                "heading" => __("Image Size", "jevelinchild"),
                "param_name" => "meta_image_size",
                "value" => array("thumbnail", "medium", "medium_large", "large", "full"),
                "group" => "Data",
                'dependency'  => array(
                    'element' => 'meta_is_image_id',
                    'value'   => 'true',
                ),
                'admin_label' => true,
            ),
            array(
                "type" => "textfield",
                "heading" => __("Extra Classes", "jevelinchild"),
                "param_name" => "extra_classes",
                "value" => "meta-item",
                "description" => __("Extra Classes to be Added to The Component, Separated with spaces ' '", "jevelinchild"),
                "group" => "Structure",
            ),
        ),
    ));
}