<?php
add_shortcode('iconbox_item', 'iconbox_item');
function iconbox_item($atts, $content)
{
    static $iconbox_item_id = 0;
    $attributes = shortcode_atts( array(
		'iconbox_type' => 'icon',
		'iconbox_icon' => 'fa fa-map-marker',
		'iconbox_image_id' => '',
		'iconbox_hover_image_id' => '',
		'iconbox_image_size' => 'thumbnail',
		'iconbox_bg_id' => '',
		'iconbox_bg_size' => 'medium',
		'iconbox_count' => '',
		'iconbox_title' => '',
		'iconbox_link' => '',
		'full_item_link' => false,
		'extra_classes' => 'iconbox-item',
		'wrapper_classes' => 'iconbox-wrapper',
	), $atts );
    $html = '';
    $iconbox_type = $attributes['iconbox_type'];
    $iconbox_icon = $attributes['iconbox_icon'];
    $iconbox_image_id = intval($attributes['iconbox_image_id']);
    $iconbox_hover_image_id = intval($attributes['iconbox_hover_image_id']);
    $iconbox_image_size = $attributes['iconbox_Image_size'];
    $iconbox_image = wp_get_attachment_image( $iconbox_image_id, $iconbox_image_size, false, array('class' => 'iconbox-original-image' ) );
    $iconbox_hover_image = wp_get_attachment_image( $iconbox_hover_image_id, $iconbox_image_size, false, array('class' => 'iconbox-hover-image' ) );
    $iconbox_bg_id = intval($attributes['iconbox_bg_id']);
    $iconbox_bg = wp_get_attachment_image_url( $iconbox_bg_id, $iconbox_bg_size, false,  );
    $iconbox_bg_size = $attributes['iconbox_bg_size'];
    $iconbox_count = $attributes['iconbox_count'];
    $iconbox_title = $attributes['iconbox_title'];
    $iconbox_info = $content;
    $iconbox_link = $attributes['iconbox_link'];
    $iconbox_link = (!empty($iconbox_link))?vc_build_link($iconbox_link):'';
    if(!empty($iconbox_link)){
        $iconbox_link_href = (($iconbox_link['url']) ? ' href="' . $iconbox_link['url'] . '"' : '' );
        $iconbox_link_title = (($iconbox_link['title']) ? ' title="' . $iconbox_link['title'] . '"' : '' );
        $iconbox_link_target = (($iconbox_link['target']) ? ' target="' . $iconbox_link['target'] . '"' : '' );
        $iconbox_link_rel = (($iconbox_link['rel']) ? ' rel="' . $iconbox_link['rel'] . '"' : '' );
    }
    $full_item_link = filter_var( $attributes['full_item_link'], FILTER_VALIDATE_BOOLEAN );
    $iconbox_tag = ($full_item_link) ? 'a' : 'div' ;
    $extra_classes = ' ' . $attributes['extra_classes'];
    $wrapper_classes = $attributes['wrapper_classes'];
    ob_start();
    echo '<div'.(($wrapper_classes) ? ' class="' . $wrapper_classes . '"' : '').'>';
        echo '<' . $iconbox_tag 
            . (($full_item_link) ? $iconbox_link_href . $iconbox_link_title . $iconbox_link_target . $iconbox_link_rel : '' )
            . ' id="iconbox_item_' . $iconbox_item_id . '"' 
            . ' class="iconbox-item iconbox-item-' . $iconbox_item_id . $extra_classes . '"' 
            . (($iconbox_bg) ? ' style="background-image:url(' . $iconbox_bg . ')"' : '') 
            . '>';
            echo '<div class="iconbox-count-icon">';
                if($iconbox_count){
                    echo '<h3 class="iconbox-count">' . $iconbox_count . '</h3>';
                }
                echo '<div class="iconbox-icon">';
                if ($iconbox_type == "icon" && $iconbox_icon) {
                    echo '<i class="' . $iconbox_icon . '"></i>';
                }
                elseif ($iconbox_type == "image" && $iconbox_image) {
                    echo $iconbox_image;
                    echo $iconbox_hover_image;
                }
                echo '</div>';
            echo '</div>';
            echo '<div class="iconbox-title-info">';
                if($iconbox_title){
                    echo '<h4 class="iconbox-title">' . $iconbox_title . '</h4>';
                }
                if($iconbox_info){
                    echo '<div class="iconbox-info">' . do_shortcode($iconbox_info) . '</div>';
                }
                if ($iconbox_link_href && !$full_item_link) {
                    echo '<div class="iconbox-link"><a ' . $iconbox_link_href . $iconbox_link_title . $iconbox_link_target . $iconbox_link_rel . '>' . $iconbox_link['title'] . '</a></div>';
                }
            echo '</div>';
        echo '</' . $iconbox_tag . '>';
    echo '</div>';
    $html = ob_get_clean();
    
    $iconbox_item_id++;
    
    return $html;
}

//Integrate With VC
add_action('vc_before_init', 'iconbox_item_integrateWithVC');
function iconbox_item_integrateWithVC()
{
	vc_map(array(
        "name" => __("Iconbox Item", "jevelinchild"),
        "base" => "iconbox_item",
        "description" => __("Iconbox Item", "jevelinchild"),
        // "custom_markup" => '<h4 class="wpb_element_title"> <i class="vc_general vc_element-icon"></i> {{name}}</h4><div>"{{ params.iconbox_icon }}"</div>',
        "show_settings_on_create" => true,
        "category" => __("Content", "jevelinchild"),
        
        "params" => array(
			array(
				"type" => "dropdown",
                "heading" => __("Type", "jevelinchild"),
                "param_name" => "iconbox_type",
                "value" => array("icon", "image"),
                "group" => "Data",
                'admin_label' => true,
            ),
			array(
				"type" => "iconpicker",
				"heading" => __("Icon", "jevelinchild"),
				"param_name" => "iconbox_icon",
                "value" => "fa fa-map-marker",
                "group" => "Data",
                'dependency'  => array(
                    'element' => 'iconbox_type',
                    'value'   => array( 'icon' ),
                ),
                'admin_label' => true,
			),
			array(
				"type" => "attach_image",
				"heading" => __("Image", "jevelinchild"),
				"param_name" => "iconbox_image_id",
				"group" => "Data",
                'dependency'  => array(
                    'element' => 'iconbox_type',
                    'value'   => array( 'image' ),
                ),
                'admin_label' => true,
			),
			array(
				"type" => "attach_image",
				"heading" => __("Hover Image", "jevelinchild"),
				"param_name" => "iconbox_hover_image_id",
				"group" => "Data",
                'dependency'  => array(
                    'element' => 'iconbox_type',
                    'value'   => array( 'image' ),
                ),
                'admin_label' => true,
			),
			array(
				"type" => "dropdown",
                "heading" => __("Image Size", "jevelinchild"),
                "param_name" => "iconbox_image_size",
                "value" => array("thumbnail", "medium", "medium_large", "large", "full"),
                "group" => "Data",
                'dependency'  => array(
                    'element' => 'iconbox_type',
                    'value'   => array( 'image' ),
                ),
                'admin_label' => true,
            ),
			array(
				"type" => "attach_image",
				"heading" => __("Background Image", "jevelinchild"),
				"param_name" => "iconbox_bg_id",
				"group" => "Data",
                'admin_label' => true,
			),
			array(
				"type" => "dropdown",
                "heading" => __("Background Size", "jevelinchild"),
                "param_name" => "iconbox_bg_size",
                "value" => array("thumbnail", "medium", "medium_large", "large", "full"),
                "group" => "Data",
                'admin_label' => true,
            ),
			array(
				"type" => "textfield",
                "heading" => __("Count", "jevelinchild"),
                "param_name" => "iconbox_count",
                "value" => "",
                "group" => "Data",
                'admin_label' => true,
            ),
			array(
				"type" => "textfield",
                "heading" => __("Title", "jevelinchild"),
                "param_name" => "iconbox_title",
                "value" => "",
                "group" => "Data",
                'admin_label' => true,
            ),
			array(
				"type" => "textarea_html",
				"holder" => "div",
                "heading" => __("Info", "jevelinchild"),
                "param_name" => "content",
                "value" => "",
                "group" => "Data",
            ),
            array(
                "type" => "vc_link",
                "heading" => __("Link", "jevelinchild"),
                "param_name" => "iconbox_link",
                "group" => "Data",
            ),
            array(
                "type" => "checkbox",
                "heading" => __("Full Item Link", "jevelinchild"),
                "param_name" => "full_item_link",
                "value" => false,
                "description" => __("Full Item Link or ordinary link", "jevelinchild"),
                "group" => "Structure",
            ),
            array(
                "type" => "textfield",
                "heading" => __("Extra Classes", "jevelinchild"),
                "param_name" => "extra_classes",
                "value" => "iconbox-item",
                "description" => __("Extra Classes to be Added to The Component, Separated with spaces ' '", "jevelinchild"),
                "group" => "Structure",
            ),
            array(
                "type" => "textfield",
                "heading" => __("Wrapper Classes", "jevelinchild"),
                "param_name" => "wrapper_classes",
                "value" => "iconbox-wrapper",
                "description" => __("Wrapper Classes to be Added to The Component Wrapper, Separated with spaces ' '", "jevelinchild"),
                "group" => "Structure",
            ),
        ),
    ));
}