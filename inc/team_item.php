<?php
add_shortcode('team_item', 'team_item');
function team_item($atts)
{
    static $team_item_id = 0;
    $attributes = shortcode_atts( array(
		'team_image_id' => '',
		'team_pre_title' => '',
		'team_title' => '',
		'team_info' => '',
		'team_link' => '',
		'team_link_icon' => 'fa fa-circle-left',
		'extra_classes' => 'team-item',
	), $atts );
    $html = '';
    $team_image_id = intval($attributes['team_image_id']);
    $image_size = 'medium';
    $team_image = wp_get_attachment_image( $team_image_id, $image_size);
    $team_pre_title = $attributes['team_pre_title'];
    $team_title = $attributes['team_title'];
    $team_info = $attributes['team_info'];
    $team_link = $attributes['team_link'];
    $team_link = (!empty($team_link))?vc_build_link($team_link):'';
    $team_link_icon = $attributes['team_link_icon'];
    $extra_classes = ' ' . $attributes['extra_classes'];
    ob_start();
	echo '<div class="team-item team-item-' . $team_item_id . $extra_classes . '">';
        echo '<div class="team-image">' . $team_image . '</div>';
        echo '<div class="team-info-box">';
            echo '<div class="team-pre-title">' . $team_pre_title . '</div>';
            echo '<h3 class="team-title equalized-item">' . $team_title . '</h3>';
            echo '<div class="team-info equalized-item-alt">' . $team_info . '</div>';
            echo '<a class="team-link" href="' . $team_link['url'] .'" title="' . $team_link['title'] . '" target="' . $team_link['target'] .'" rel="' . $team_link['rel'] . '">' . $team_link['title'] . "<span class='line'></span>" . '<i class="' . $team_link_icon . '"></i>' . '</a>';
        echo '</div>';
	echo '</div>';
    $html = ob_get_clean();
    
    $team_item_id++;
    
    return $html;
}

//Integrate With VC
add_action('vc_before_init', 'team_item_integrateWithVC');
function team_item_integrateWithVC()
{
	vc_map(array(
        "name" => __("Team Item", "jevelinchild"),
        "base" => "team_item",
        "description" => __("Team Item", "jevelinchild"),
        "show_settings_on_create" => true,
        "category" => __("Content", "jevelinchild"),
        
        "params" => array(
			array(
				"type" => "attach_image",
				"heading" => __("Image", "jevelinchild"),
				"param_name" => "team_image_id",
				"group" => "Data",
			),
			array(
				"type" => "textfield",
                "heading" => __("Pre Title", "jevelinchild"),
                "param_name" => "team_pre_title",
                "value" => "",
                "group" => "Data",
            ),
			array(
				"type" => "textfield",
                "heading" => __("Title", "jevelinchild"),
                "param_name" => "team_title",
                "value" => "",
                "group" => "Data",
            ),
			array(
				"type" => "textfield",
                "heading" => __("Info", "jevelinchild"),
                "param_name" => "team_info",
                "value" => "",
                "group" => "Data",
            ),
            array(
                "type" => "vc_link",
                "heading" => __("Link", "jevelinchild"),
                "param_name" => "team_link",
                "group" => "Data",
            ),
			array(
				"type" => "iconpicker",
				"heading" => __("Icon", "jevelinchild"),
				"param_name" => "team_link_icon",
                "value" => "fa fa-circle-left",
                "group" => "Data",
                'dependency'  => array(
                    'element' => 'iconbox_type',
                    'value'   => array( 'icon' ),
                ),
                'admin_label' => true,
			),
            array(
                "type" => "textfield",
                "heading" => __("Extra Classes", "jevelinchild"),
                "param_name" => "extra_classes",
                "value" => "team-item",
                "description" => __("Extra Classes to be Added to The Component, Separated with spaces ' '", "jevelinchild"),
                "group" => "Structure",
            ),
        ),
    ));
}