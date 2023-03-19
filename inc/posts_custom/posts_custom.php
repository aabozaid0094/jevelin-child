<?php
add_shortcode('posts_custom', 'posts_custom');
function posts_custom($atts)
{
    static $posts_custom_id = 0;
    $attributes = shortcode_atts( array(
        'post_type' => 'post',
		'taxonomy' => 'category',
		'terms' => '',
		'posts_per_page' => '-1',
		'orderby' => '',
		'offset' => '0',
		'section_title' => 'Posts',
		'container_fluid' => false,
		'columns' => '1',
		'extra_classes' => 'articles',
		'all_posts_link' => false,
		'style' => "columns",
		'slider' => false,
		'arrows' => false,
		'prev_icon' => 'fa fa-arrow-left',
		'next_icon' => 'fa fa-arrow-right',
		'dots' => false,
		'dot_icon' => 'fa fa-square',
	), $atts );
    $html = '';
    $post_type = $attributes['post_type'];
    $taxonomy = $attributes['taxonomy'];
    $terms = $attributes['terms'];
    $posts_per_page = intval($attributes['posts_per_page']);
    $orderby = $attributes['orderby'];
    $offset = intval($attributes['offset']);
    $section_title = $attributes['section_title'];
    $container_fluid = filter_var( $attributes['container_fluid'], FILTER_VALIDATE_BOOLEAN );
    $columns = intval( $attributes['columns'] );
    $all_posts_link = filter_var( $attributes['all_posts_link'], FILTER_VALIDATE_BOOLEAN );
    $style = $attributes['style'];
    $slider = filter_var( $attributes['slider'], FILTER_VALIDATE_BOOLEAN );
    $arrows = filter_var( $attributes['arrows'], FILTER_VALIDATE_BOOLEAN );
    $prev_icon = '<i class="' . $attributes['prev_icon'] . '"></i>';
    $next_icon = '<i class="' . $attributes['next_icon'] . '"></i>';
    $dots = filter_var( $attributes['dots'], FILTER_VALIDATE_BOOLEAN );
    $dot_icon = '<i class="' . $attributes['dot_icon'] . '"></i>';
    $query_terms = explode(",", $terms);
    $tax_query = array();
    if (!empty($terms)) {
        $tax_query = array(array('taxonomy' => $taxonomy, 'field' => 'slug', 'terms' => $query_terms,),);
    }
    $container_class = ($container_fluid) ? 'container-fluid' : 'container' ;
    $columns_class = 'col-lg-12' ;
    $min_columns = 1; $max_columns = 4; $columns_options = array( "options" => array("min_range" => $min_columns, "max_range" => $max_columns));
    if (!(filter_var($columns, FILTER_VALIDATE_INT, $columns_options) === false)) {
        $columns_class = 'col-lg-' . 12/$columns;
    }
    $columns_class .= ($columns>2)?' col-md-6':'';
    $extra_classes = ' ' . $attributes['extra_classes'];
    $more_icon = '<i class="button-icon fa fa-plus" aria-hidden="true"></i>';
    $title_tag = 'h3';
    $image_size = 'medium_large';
    $args = array('ignore_sticky_posts' => true, 'post_type' => $post_type, 'posts_per_page' => $posts_per_page, 'offset' => $offset,);
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }
    $orderby_query = array();
    if ($orderby == 'Views') {
        $orderby_query['meta_value_num'] = 'DESC';
    }
    elseif (in_array($orderby, array('content_in_minutes','time_to_read'), true)) {
        $orderby_query['meta_value_num'] = 'ASC';
    }
    else {
        $orderby_query['date'] = 'DESC';
    }
    if (!empty($orderby_query)) {
        $args['orderby'] = $orderby_query;
    }
    if (in_array($orderby, array('content_in_minutes', 'time_to_read', 'Views'), true)) {
        $args['meta_key'] = $orderby;
    }
    $posts = new WP_Query( $args );
    ob_start();
    if( $posts -> have_posts() ){
        $template_args = array(
            'image_size' => $image_size,
            'title_tag' => $title_tag,
            'more_icon' => $more_icon,
            'columns' => $columns,
        );
        echo '<section class="posts-custom posts-custom-' . $posts_custom_id . $extra_classes . '">';
            echo ($section_title && $style != "tabs") ? '<h2 class="posts-custom-title">' . $section_title . '</h2>':'';
            echo '<div class="' . $container_class . '">';
                if ($slider) {
                    echo '<div class="posts-custom-slider-' . $posts_custom_id . '">';
                    $i = 0;
                    while( $posts -> have_posts() ){ $posts -> the_post(); 
                        
                        if ($style == "flipbox") {
                            require __DIR__ . '/posts_custom_view_flipbox.php';
                        } elseif ($style == "list") {
                            require __DIR__ . '/posts_custom_view_list.php';
                        } else {
                            // require __DIR__ . '/posts_custom_view_column.php';
                            get_template_part( 'content', 'item-'.$post_type, $template_args );
                        }
                        $i++;
                    }
                    echo '</div>';
                } elseif($style == "tabs") {
                    echo '<div class="posts-custom-tabs-' . $posts_custom_id . '">';
                        echo '<div class="posts-custom-tabs-container d-flex align-items-center">';
                            echo '<div class="col">';
                                echo '<div class="tabs-title-nav">';
                                    echo '<div class="section-title text-center">' . $section_title . '</div>';
                                    $i = 0;
                                    echo '<ul class="nav nav-tabs" role="tablist">';
                                        while( $posts -> have_posts() ){ $posts -> the_post();
                                            require __DIR__ . '/posts_custom_view_tabs_nav.php';
                                            $i++;
                                        }
                                    echo '</ul>';
                                echo '</div>';
                            echo '</div>';
                            echo '<div class="col">';
                                $i = 0;
                                echo '<div class="tab-content">';
                                    while( $posts -> have_posts() ){ $posts -> the_post();
                                        require __DIR__ . '/posts_custom_view_tabs_content.php';
                                        $i++;
                                    }
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                } else {
                    echo '<div class="row">';
                    if ($style == "list") { echo '<ul class="posts-list">'; }
                    $i = 0;
                    while( $posts -> have_posts() ){ $posts -> the_post(); 
                        echo '<div class="' . $columns_class . '">';
                        if ($style == "flipbox") {
                            require __DIR__ . '/posts_custom_view_flipbox.php';
                        } elseif ($style == "list") {
                            require __DIR__ . '/posts_custom_view_list.php';
                        } else {
                            // require __DIR__ . '/posts_custom_view_column.php';
                            get_template_part( 'content', 'item-'.$post_type, $template_args );
                        }
                        echo '</div>';
                        $i++;
                    }
                    if ($style == "list") { echo '</ul>'; }
                    echo '</div>';
                }
                if (($posts_per_page != -1) && (get_post_type_archive_link($post_type)) && ($all_posts_link)) {
                    echo '<div class="row text-center">';
                        echo '<a class="all-posts" href="' . get_post_type_archive_link($post_type) . '">' . __("All Posts", "jevelinchild") . '</a>';
                    echo '</div>';
                }
            echo '</div>';
        echo '</section>';
    } else {
        echo __("No Posts To Show", "jevelinchild");
    }
    wp_reset_postdata();
    $html = ob_get_clean();
    
    static $slick_options;
    $slick_options[] = array(
        'rtl' => is_rtl(),
        'desktop_slidesToShow' => $columns,
        'slidesToScroll' => 'one',
        'arrows' => $arrows,
        'prevArrow' => $prev_icon,
        'nextArrow' => $next_icon,
        'dots' => $dots,
        'dotIcon' => $dot_icon,
    );
    $inline_js = '';
    if ($posts_custom_id>0) {
        $inline_js = $inline_js . 'posts_slick_options = ' . json_encode($slick_options);
    } else {
        $inline_js = $inline_js . 'let posts_slick_options = ' . json_encode($slick_options);
    }

    wp_enqueue_style('posts-custom-css', get_stylesheet_directory_uri() . '/css/posts-custom.css');
    wp_enqueue_script(
        'posts-custom-script',
        get_stylesheet_directory_uri() . '/js/posts-custom.js',
        array('jquery', 'jevelin-plugins'),
        filemtime(get_stylesheet_directory() . '/js/posts-custom.js'),
        true
    );
    wp_add_inline_script('posts-custom-script', $inline_js, 'before');
    $posts_custom_id++;
    
    return $html;
}

//Integrate With VC
add_action('vc_before_init', 'posts_custom_integrateWithVC');
function posts_custom_integrateWithVC()
{
    $post_types = get_post_types(array('public' => true,), 'objects');
    $included_post_types = array();
    $excluded_post_types = array(
        'attachment',
        'slider',
        'testimonial',
        'shufflehound_header',
        'shufflehound_titleb',
        'shufflehound_footer',
    );
    if (is_array($post_types) && !empty($post_types)) {
        foreach ($post_types as $post_type) {
            if (!in_array($post_type->name, $excluded_post_types, true)) {
                $included_post_types[] = array($post_type->name, $post_type->label);
            }
        }
    }
    
    $taxonomies = get_taxonomies(array('public' => true,), 'objects');
    $included_taxonomies = array();
    $included_taxonomies_slugs = array();
    $excluded_taxonomies = array();
    if (is_array($taxonomies) && !empty($taxonomies)) {
        foreach ($taxonomies as $taxonomy) {
            if (!in_array($taxonomy->name, $excluded_taxonomies, true)) {
                $included_taxonomies[] = array( 
                    $taxonomy->name,
                    $taxonomy->label,
                );
                $included_taxonomies_slugs[] = $taxonomy->name;
            }
        }
    }

    vc_map(array(
        "name" => __("Posts Custom", "jevelinchild"),
        "base" => "posts_custom",
        "description" => "Posts Custom",
        "show_settings_on_create" => true,
        "category" => __("Content", "jevelinchild"),
        
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => __("Choose Post Type", "jevelinchild"),
                "param_name" => "post_type",
                "value" => $included_post_types,
                "group" => "Data",
                'admin_label' => true,
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Choose Taxonomy", "jevelinchild"),
                "param_name" => "taxonomy",
                "value" => $included_taxonomies,
                "group" => "Data",
            ),
            array(
                "type" => "textfield",
                "heading" => __("Terms", "jevelinchild"),
                "param_name" => "terms",
                "description" => __("Comma separated terms of chosen taxonomy", "jevelinchild"),
                "group" => "Data",
                'admin_label' => true,
            ),
            array(
                "type" => "textfield",
                "heading" => __("Number Of Posts To View", "jevelinchild"),
                "param_name" => "posts_per_page",
                "value" => -1,
                "group" => "Data",
                'admin_label' => true,
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Order By", "jevelinchild"),
                "param_name" => "orderby",
                "value" => array(array('', 'Date'), array('Views', 'Views'), array('content_in_minutes', 'Read Time'),),
                "group" => "Data",
                'admin_label' => true,
            ),
            array(
                "type" => "textfield",
                "heading" => __("Offset", "jevelinchild"),
                "param_name" => "offset",
                "value" => 0,
                "description" => __("Number of posts to discard before posting remain posts", "jevelinchild"),
                "group" => "Data",
                'admin_label' => true,
            ),
            array(
                "type" => "textarea",
                "heading" => __("Section Title", "jevelinchild"),
                "param_name" => "section_title",
                "value" => "Posts",
                "group" => "Structure",
                'admin_label' => true,
            ),
            array(
                "type" => "checkbox",
                "heading" => __("Container Fluid", "jevelinchild"),
                "param_name" => "container_fluid",
                "value" => false,
                "description" => __("Full width container or stick to 1200px bootstrap 'container'", "jevelinchild"),
                "group" => "Structure",
            ),
            array(
                "type" => "textfield",
                "heading" => __("Columns", "jevelinchild"),
                "param_name" => "columns",
                "dependency" => array("element" => "style", "value" => array("columns", "list", "flipbox")),
                "value" => 1,
                "min" => 1,
                "max" => 4,
                "description" => __("Number of posts per row", "jevelinchild"),
                "group" => "Structure",
                'admin_label' => true,
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Style", "jevelinchild"),
                "param_name" => "style",
                "value" => array("columns", "list", "flipbox", "tabs"),
                "description" => __("Style, Examples are columns(default), list, flipbox, tabs", "jevelinchild"),
                "group" => "Structure",
                'admin_label' => true,
            ),
            array(
                "type" => "checkbox",
                "heading" => __("Slider", "jevelinchild"),
                "param_name" => "slider",
                "dependency" => array("element" => "style", "value" => array("columns", "list", "flipbox")),
                "value" => false,
                "description" => __("Wrap posts in slider", "jevelinchild"),
                "group" => "Structure",
                'admin_label' => true,
            ),
            array(
                "type" => "checkbox",
                "heading" => __("All Posts Link", "jevelinchild"),
                "param_name" => "all_posts_link",
                "value" => false,
                "group" => "Structure",
            ),
            array(
                "type" => "textfield",
                "heading" => __("Extra Classes", "jevelinchild"),
                "param_name" => "extra_classes",
                "value" => "articles",
                "description" => __("Extra Classes to be Added to The Component, Separated with spaces ' '", "jevelinchild"),
                "group" => "Structure",
            ),
            array(
                "type" => "checkbox",
                "heading" => __("Arrows", "jevelinchild"),
                "param_name" => "arrows",
                "dependency" => array("element" => "slider", "value" => "true"),
                "value" => false,
                "description" => __("Toggle Arrows", "jevelinchild"),
                "group" => "Slider",
            ),
            array(
                "type" => "iconpicker",
                "heading" => __("Previous Icon", "jevelinchild"),
                "param_name" => "prev_icon",
                "dependency" => array("element" => "arrows", "value" => "true"),
                "value" => 'fa fa-arrow-left',
                "group" => "Slider",
            ),
            array(
                "type" => "iconpicker",
                "heading" => __("Next Icon", "jevelinchild"),
                "param_name" => "next_icon",
                "dependency" => array("element" => "arrows", "value" => "true"),
                "value" => 'fa fa-arrow-right',
                "group" => "Slider",
            ),
            array(
                "type" => "checkbox",
                "heading" => __("Dots", "jevelinchild"),
                "param_name" => "dots",
                "dependency" => array("element" => "slider", "value" => "true"),
                "value" => false,
                "description" => __("Toggle Dots", "jevelinchild"),
                "group" => "Slider",
            ),
            array(
                "type" => "iconpicker",
                "heading" => __("Dot Icon", "jevelinchild"),
                "param_name" => "dot_icon",
                "dependency" => array("element" => "dots", "value" => "true"),
                "value" => 'fa fa-square',
                "group" => "Slider",
            ),
        ),
    ));
}