<?php
add_shortcode('featured_post', 'featured_post');
function featured_post($atts)
{
    static $featured_post_id = 0;
    $attributes = shortcode_atts( array(
		'post_id' => '',
		'show_meta' => true,
		'extra_classes' => 'featured-post-item',
	), $atts );
    $html = '';
    $post_id = intval($attributes['post_id']);
    $show_meta = filter_var( $attributes['show_meta'], FILTER_VALIDATE_BOOLEAN );
    $extra_classes = ' ' . $attributes['extra_classes'];
    $views_icon = '<svg width="14" height="10" viewBox="0 0 14 10" fill="#fff" xmlns="http://www.w3.org/2000/svg"><path d="M6.84295 0C3.73252 0 1.07621 2.07333 0 5C1.07621 7.92667 3.73252 10 6.84295 10C9.95338 10 12.6097 7.92667 13.6859 5C12.6097 2.07333 9.95338 0 6.84295 0ZM6.84295 8.33333C5.12599 8.33333 3.73252 6.84 3.73252 5C3.73252 3.16 5.12599 1.66667 6.84295 1.66667C8.55991 1.66667 9.95338 3.16 9.95338 5C9.95338 6.84 8.55991 8.33333 6.84295 8.33333ZM6.84295 3C5.81029 3 4.97669 3.89333 4.97669 5C4.97669 6.10667 5.81029 7 6.84295 7C7.87561 7 8.70921 6.10667 8.70921 5C8.70921 3.89333 7.87561 3 6.84295 3Z"/></svg>';
    $read_icon = '<svg width="14" height="11" viewBox="0 0 14 11" fill="#fff" xmlns="http://www.w3.org/2000/svg"><path d="M12.3677 0.916667C11.714 0.7125 10.9955 0.625 10.3064 0.625C9.15798 0.625 7.9212 0.858333 7.06723 1.5C6.21327 0.858333 4.97649 0.625 3.82805 0.625C2.67961 0.625 1.44283 0.858333 0.588867 1.5V10.0458C0.588867 10.1917 0.736103 10.3375 0.883338 10.3375C0.942233 10.3375 0.97168 10.3083 1.03057 10.3083C1.82565 9.92917 2.97408 9.66667 3.82805 9.66667C4.97649 9.66667 6.21327 9.9 7.06723 10.5417C7.8623 10.0458 9.30521 9.66667 10.3064 9.66667C11.2782 9.66667 12.2794 9.84167 13.1039 10.2792C13.1628 10.3083 13.1922 10.3083 13.2511 10.3083C13.3984 10.3083 13.5456 10.1625 13.5456 10.0167V1.5C13.1922 1.2375 12.8094 1.0625 12.3677 0.916667ZM12.3677 8.79167C11.7199 8.5875 11.0131 8.5 10.3064 8.5C9.30521 8.5 7.8623 8.87917 7.06723 9.375V2.66667C7.8623 2.17083 9.30521 1.79167 10.3064 1.79167C11.0131 1.79167 11.7199 1.87917 12.3677 2.08333V8.79167Z"/><path d="M10.3065 4.125C10.8248 4.125 11.3254 4.1775 11.7788 4.27667V3.39C11.3136 3.3025 10.813 3.25 10.3065 3.25C9.30529 3.25 8.39832 3.41917 7.65625 3.73417V4.7025C8.32175 4.32917 9.24639 4.125 10.3065 4.125Z"/><path d="M7.65625 5.2858V6.25414C8.32175 5.8808 9.24639 5.67664 10.3065 5.67664C10.8248 5.67664 11.3254 5.72914 11.7788 5.8283V4.94164C11.3136 4.85414 10.813 4.80164 10.3065 4.80164C9.30529 4.80164 8.39832 4.97664 7.65625 5.2858Z"/><path d="M10.3065 6.35913C9.30529 6.35913 8.39832 6.5283 7.65625 6.8433V7.81163C8.32175 7.4383 9.24639 7.23413 10.3065 7.23413C10.8248 7.23413 11.3254 7.28663 11.7788 7.3858V6.49913C11.3136 6.4058 10.813 6.35913 10.3065 6.35913Z"/></svg>';
    $post_object_check = false;
    if ($post_id>0) {
        $post_object = get_post($post_id, 'ARRAY_A');
        $post_object_check = isset($post_object) && !empty($post_object);
        if ($post_object_check) {
            $featured_id = $post_object['ID'];
            $featured_title = $post_object['post_title'];
            $featured_excerpt = $post_object['post_excerpt'];
            $featured_date = $post_object['post_date'];
            $featured_views_count = getPostViews($featured_id);
            $featured_content_in_minutes = content_in_minutes_text($featured_id);
            $featured_thumbnail = get_the_post_thumbnail( $featured_thumbnail_id, 'full', array('class'=>'featured-background') );
            $featured_image_id = get_post_meta($featured_id, 'featured_image', true);
            // $featured_image = wp_get_attachment_image( $featured_image_id, 'full', false, array('class'=>'featured-background') );
            $featured_image_url = wp_get_attachment_image_url($featured_image_id, 'full', false);
            $featured_responsive_image_id = get_post_meta($featured_id, 'featured_responsive_image', true);
            // $featured_responsive_image = wp_get_attachment_image( $featured_responsive_image_id, 'full', false, array('class'=>'featured-responsive-image') );
            $featured_responsive_image_url = wp_get_attachment_image_url($featured_responsive_image_id, 'full', false);
        }
    }
    ob_start();
    if ($post_object_check) {
        echo '<div class="featured_post'. $extra_classes .'" wide-background="' . $featured_image_url . '" responsive-background="' . $featured_responsive_image_url . '">';
            echo '<div class="container">';
                echo '<h2 class="featured_post_title">' . $featured_title . '</h2>';
                echo '<div class="featured_post_excerpt">' . $featured_excerpt . '</div>';
                echo '<div class="featured_post_meta_link">';
                    if ($show_meta) {
                        echo '<div class="featured_post_meta">';
                            echo '<div class="featured_post_date"><time datetime="' . get_the_date('c') . '" itemprop="datePublished">' . get_the_date() . '</time></div>';
                            echo (intval($featured_views_count)>0) ? '<div class="featured_views_count">' . $views_icon . '<span>' . $featured_views_count . " " . __("Views", "jevelinchild") . '</span></div>' : '' ;
                            echo ($featured_content_in_minutes) ? '<div class="featured_content_in_minutes">' . $read_icon . '<span>' . $featured_content_in_minutes . '</span></div>' : '' ;
                        echo '</div>';
                    }
                    echo '<a class="featured_post_link" href="' . get_permalink($featured_id) . '">' . __("Read Article", "jevelinchild") . '</a>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
    else {
        echo __("No Featured Post To Show", "jevelinchild");
    }
    $html = ob_get_clean();
    
    wp_enqueue_style('featured-post-css', get_stylesheet_directory_uri() . '/css/featured-post.css');
    wp_enqueue_script(
        'featured-post-script',
        get_stylesheet_directory_uri() . '/js/featured-post.js',
        array(),
        filemtime(get_stylesheet_directory() . '/js/featured-post.js'),
        true
    );

    $featured_post_id++;
    
    return $html;
}

//Integrate With VC
add_action('vc_before_init', 'featured_post_integrateWithVC');
function featured_post_integrateWithVC()
{
    $featured_posts = get_posts(array('meta_key' => 'is_featured', 'meta_value' => 1, 'post_type' => 'post',));
    $included_featured_posts = array();
    if (is_array($featured_posts) && !empty($featured_posts)) {
        foreach ($featured_posts as $featured_post) {
            $included_featured_posts[] = array($featured_post->ID, $featured_post->post_title);
        }
    }
	vc_map(array(
        "name" => __("Featured Post", "jevelinchild"),
        "base" => "featured_post",
        "description" => __("Featured Post", "jevelinchild"),
        // "custom_markup" => '<h4 class="wpb_element_title"> <i class="vc_general vc_element-count"></i> {{name}}</h4><div>"{{ params.featurebox_count }}"</div>',
        "show_settings_on_create" => true,
        "category" => __("Content", "jevelinchild"),
        
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => __("Choose Featured Post", "jevelinchild"),
                "param_name" => "post_id",
                "value" => $included_featured_posts,
                'admin_label' => true,
            ),
            array(
                "type" => "checkbox",
                "heading" => __("Show Meta Data", "jevelinchild"),
                "param_name" => "show_meta",
                "value" => true,
                "description" => __("Whether to show date, post views, time to read, ...etc", "jevelinchild"),
                'admin_label' => true,
            ),
            array(
                "type" => "textfield",
                "heading" => __("Extra Classes", "jevelinchild"),
                "param_name" => "extra_classes",
                "value" => "featured-post-item",
                "description" => __("Extra Classes to be Added to The Component, Separated with spaces ' '", "jevelinchild"),
            ),
        ),
    ));
}