<?php
add_shortcode('jevelin_social', 'jevelin_social');
function jevelin_social(){
    $html = '<div class="jevelin-social">' . jevelin_social_media() . '</div>';
    return $html;
}

//Integrate With VC
add_action('vc_before_init', 'jevelin_social_integrateWithVC');
function jevelin_social_integrateWithVC()
{
    vc_map(array(
        "name" => __("Jevelin Social", "jevelinchild"),
        "base" => "jevelin_social",
        "description" => "Options are in jevelin-settings->social-media",
        "show_settings_on_create" => false,
        "category" => __("Content", "jevelinchild"),
        "custom_markup" => __("<h4 class='wpb_element_title'> <i class='vc_general vc_element-icon'></i> Jevelin Social</h4>Options are in jevelin-settings->social-media", "jevelinchild"),
    ));
}