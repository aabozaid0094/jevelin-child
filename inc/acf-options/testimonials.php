<?php
add_shortcode('testimonials_custom', 'testimonials_custom');
function testimonials_custom()
{
    static $testimonials_custom_id = 0;
    $html = '';
    $source = (get_field('testimonials_source', 'option')) ? get_field('testimonials_source', 'option') : "posts";
    $post_type = (get_field('testimonials_post_type', 'option')) ? get_field('testimonials_post_type', 'option') : "post";
    $image_size = (get_field('testimonials_image_size', 'option')) ? get_field('testimonials_image_size', 'option') : "thumb";
    $name_tag = (get_field('testimonials_name_tag', 'option')) ? get_field('testimonials_name_tag', 'option') : "h4";
    $info_tag = (get_field('testimonials_info_tag', 'option')) ? get_field('testimonials_info_tag', 'option') : "h5";
    $rtl = get_field('testimonials_rtl', 'option');
    $start_quote = ($rtl) ? '<i class="fa fa-quote-right" aria-hidden="true"></i>' : '<i class="fa fa-quote-left" aria-hidden="true"></i>' ;
    $end_quote = ($rtl) ? '<i class="fa fa-quote-left" aria-hidden="true"></i>' : '<i class="fa fa-quote-right" aria-hidden="true"></i>' ;
    if ($source == "posts") {
        $args = array( 'post_type' => $post_type, );
        $testimonials = new WP_Query( $args );
        ob_start();
        if( $testimonials -> have_posts() ){
        echo '<div class="testimonials-custom testimonials-custom-'. $testimonials_custom_id . '">';
            while( $testimonials -> have_posts() ){ $testimonials -> the_post(); 
                echo '<div class="testimonial-item">';
                if (get_the_post_thumbnail()) {
                    echo '<div class="testimonial-image">' . get_the_post_thumbnail(get_the_ID(), $image_size) . '</div>';
                }
                echo '<div class="testimonial-quote-info">';
                if (get_field('quote')) {
                    echo '<div class="testimonial-quote">' . $start_quote . get_field('quote') . $end_quote . '</div>';
                }
                if (get_the_title()) {
                    echo '<' . $name_tag . ' class="testimonial-name">' . get_the_title() . '</' . $name_tag . '>';
                }
                if (get_field('info')) {
                    echo '<' . $info_tag . ' class="testimonial-info">' . get_field('info') . '</' . $info_tag . '>';
                }
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo __("No Testimonials To Show", "jevelin");
        }
        wp_reset_postdata();
        $html = ob_get_clean();
    } elseif($source == "options") {
        $testimonials = get_field('testimonials', 'option');
        ob_start();
        if ($testimonials) {
            echo '<div class="testimonials-custom">';
            foreach ($testimonials as $index => $testimonial) {
                echo '<div class="testimonial-item">';
                if ($testimonial['image']) {
                    echo '<div class="testimonial-image">' . wp_get_attachment_image($testimonial['image'], $image_size) . '</div>';
                }
                echo '<div class="testimonial-quote-info">';
                if ($testimonial['quote']) {
                    echo '<div class="testimonial-quote">' . $start_quote . $testimonial['quote'] . $end_quote . '</div>';
                }
                if ($testimonial['name']) {
                    echo '<' . $name_tag . ' class="testimonial-name">' . $testimonial['name'] . '</' . $name_tag . '>';
                }
                if ($testimonial['info']) {
                    echo '<' . $info_tag . ' class="testimonial-info">' . $testimonial['info'] . '</' . $info_tag . '>';
                }
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo __("No Testimonials To Show", "jevelin");
        }
        $html = ob_get_clean();
    }

    $item_layout = (get_field('testimonials_item_layout', 'option')) ? get_field('testimonials_item_layout', 'option') : "column";
    $mobile_item_layout = (get_field('testimonials_mobile_item_layout', 'option')) ? get_field('testimonials_mobile_item_layout', 'option') : "column";
    $horizontal_alignment = (get_field('testimonials_horizontal_alignment', 'option')) ? get_field('testimonials_horizontal_alignment', 'option') : "default";
    $item_margin = (get_field('testimonials_item_margin', 'option')) ? get_field('testimonials_item_margin', 'option') : "15px";
    $item_padding = (get_field('testimonials_item_padding', 'option')) ? get_field('testimonials_item_padding', 'option') : "15px";
    $item_bg_color = (get_field('testimonials_item_bg_color', 'option')) ? get_field('testimonials_item_bg_color', 'option') : "rgba(71,201,229,.3)";
    $item_border_radius = (null !== (get_field('testimonials_item_border_radius', 'option'))) ? intval(get_field('testimonials_item_border_radius', 'option')) : 5;
    $arrows_color = (get_field('testimonials_arrows_color', 'option')) ? get_field('testimonials_arrows_color', 'option') : "#47c9e5";
    $arrows_color_hover = (get_field('testimonials_arrows_color_hover', 'option')) ? get_field('testimonials_arrows_color_hover', 'option') : "#0789a5";
    $arrows_bg_color = (get_field('testimonials_arrows_bg_color', 'option')) ? get_field('testimonials_arrows_bg_color', 'option') : "rgba(71,201,229,.1)";
    $arrows_bg_color_hover = (get_field('testimonials_arrows_bg_color_hover', 'option')) ? get_field('testimonials_arrows_bg_color_hover', 'option') : "rgba(71,201,229,.3)";
    $arrows_border_radius = (null !== (get_field('testimonials_arrows_border_radius', 'option'))) ? intval(get_field('testimonials_arrows_border_radius', 'option')) : 5;
    $dots_color = (get_field('testimonials_dots_color', 'option')) ? get_field('testimonials_dots_color', 'option') : "#47c9e5";
    $dots_color_hover = (get_field('testimonials_dots_color_hover', 'option')) ? get_field('testimonials_dots_color_hover', 'option') : "#0789a5";

    $dots_color = get_field('testimonials_dots_color', 'option');
    $dots_color_hover = get_field('testimonials_dots_color_hover', 'option');
    $inline_css = '';
    if ($horizontal_alignment != "default") {
        $inline_css = $inline_css . '.testimonials-custom {text-align:' . $horizontal_alignment . ';}';
    }
    $inline_css = $inline_css . '.testimonials-custom .testimonial-item{'.
        'flex-direction:' . $item_layout . '; margin:' . $item_margin . '; padding:' . $item_padding . 
        '; background-color:' . $item_bg_color . '; border-radius:' . $item_border_radius . 'px;}' . 
        '@media(max-width:800px){ .testimonials-custom .testimonial-item{flex-direction:' . $mobile_item_layout . ';} }';
    $inline_css = $inline_css . '.testimonials-custom a.slick-arrow{color:' . $arrows_color . '; background-color:' . $arrows_bg_color . '; border-radius:' . $arrows_border_radius . 'px;}';
    $inline_css = $inline_css . '.testimonials-custom a.slick-arrow:hover{color:' . $arrows_color_hover . '; background-color:' . $arrows_bg_color_hover . ';}';
    $inline_css = $inline_css . '.testimonials-custom ul.slick-dots li>a{color:' . $dots_color . ';}';
    $inline_css = $inline_css . '.testimonials-custom ul.slick-dots li>a:hover, ul.slick-dots li.slick-active>a{color:' . $dots_color_hover . ';}';
    
    $autoplay = get_field('testimonials_autoplay', 'option');
    $autoplaySpeed = get_field('testimonials_autoplaySpeed', 'option');
    $arrows = get_field('testimonials_arrows', 'option');
    $prevArrow = get_field('testimonials_prevArrow', 'option');
    $nextArrow = get_field('testimonials_nextArrow', 'option');
    $dots = get_field('testimonials_dots', 'option');
    $dotIcon = get_field('testimonials_dotIcon', 'option');
    $centerMode = get_field('testimonials_centerMode', 'option');
    $desktop_slidesToShow = get_field('testimonials_desktop_slidesToShow', 'option');
    $tablet_slidesToShow = get_field('testimonials_tablet_slidesToShow', 'option');
    $mobile_slidesToShow = get_field('testimonials_mobile_slidesToShow', 'option');
    $slidesToScroll = get_field('testimonials_slidesToScroll', 'option');
    static $slick_options;
    $slick_options[] = array(
        'autoplay' => $autoplay,
        'autoplaySpeed' => $autoplaySpeed,
        'arrows' => $arrows,
        'prevArrow' => $prevArrow,
        'nextArrow' => $nextArrow,
        'dots' => $dots,
        'dotIcon' => $dotIcon,
        'rtl' => $rtl,
        'centerMode' => $centerMode,
        'desktop_slidesToShow' => $desktop_slidesToShow,
        'tablet_slidesToShow' => $tablet_slidesToShow,
        'mobile_slidesToShow' => $mobile_slidesToShow,
        'slidesToScroll' => $slidesToScroll,
    );

    $inline_js = '';
    if ($testimonials_custom_id>0) {
        $inline_js = $inline_js . 'testimonials_slick_options = ' . json_encode($slick_options);
    } else {
        $inline_js = $inline_js . 'let testimonials_slick_options = ' . json_encode($slick_options);
    }

    wp_enqueue_style('testimonials-custom-style', get_stylesheet_directory_uri() . '/css/testimonials-custom.css');
    wp_add_inline_style('testimonials-custom-style', $inline_css);

    wp_enqueue_script(
        'testimonials-custom-script',
        get_stylesheet_directory_uri() . '/js/testimonials-custom.js',
        array('jquery', 'jevelin-plugins'),
        filemtime(get_stylesheet_directory() . '/js/testimonials-custom.js'),
        true
    );
    wp_add_inline_script('testimonials-custom-script', $inline_js, 'before');
    $testimonials_custom_id++;
    return $html;
}

//Integrate With VC
add_action('vc_before_init', 'testimonials_custom_integrateWithVC');
function testimonials_custom_integrateWithVC()
{
    vc_map(array(
        "name" => __("Testimonials Custom", "jevelin"),
        "base" => "testimonials_custom",
        "description" => "Options are in custom-options->testimonials",
        "show_settings_on_create" => false,
        "category" => __("Content", "jevelin"),
        "custom_markup" => __("<h4 class='wpb_element_title'> <i class='vc_general vc_element-icon'></i> Testimonials Custom</h4>Options are in custom-options->testimonials", "jevelin"),
    ));
}
