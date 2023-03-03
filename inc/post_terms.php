<?php
add_shortcode('post_terms', 'post_terms');
function post_terms($atts)
{
    static $post_terms_id = 0;
    $attributes = shortcode_atts( array(
		'taxonomy' => 'category',
        'exclude_terms_ids' => '',
		'offset' => '0',
		'parent' => '-1',
		'hide_empty' => false,
		'section_title' => 'Terms',
		'container_fluid' => false,
		'columns' => '1',
		'extra_classes' => 'terms',
		'element_id' => '',
		'slider' => false,
		'arrows' => false,
		'prev_icon' => 'fa fa-arrow-left',
		'next_icon' => 'fa fa-arrow-right',
		'dots' => false,
		'dot_icon' => 'fa fa-square',
	), $atts );
    $html = '';
    $taxonomy = $attributes['taxonomy'];
    $exclude_terms_ids = $attributes['exclude_terms_ids'];
    $offset = intval($attributes['offset']);
    $parent = intval($attributes['parent']);
    $hide_empty = filter_var( $attributes['hide_empty'], FILTER_VALIDATE_BOOLEAN );
    $section_title = $attributes['section_title'];
    $container_fluid = filter_var( $attributes['container_fluid'], FILTER_VALIDATE_BOOLEAN );
    $columns = intval( $attributes['columns'] );
    $slider = filter_var( $attributes['slider'], FILTER_VALIDATE_BOOLEAN );
    $arrows = filter_var( $attributes['arrows'], FILTER_VALIDATE_BOOLEAN );
    $prev_icon = '<i class="' . $attributes['prev_icon'] . '"></i>';
    $next_icon = '<i class="' . $attributes['next_icon'] . '"></i>';
    $dots = filter_var( $attributes['dots'], FILTER_VALIDATE_BOOLEAN );
    $dot_icon = '<i class="' . $attributes['dot_icon'] . '"></i>';
    $container_class = ($container_fluid) ? 'container-fluid' : 'container' ;
    $columns_class = 'col-lg-12' ;
    $min_columns = 1; $max_columns = 6; $columns_options = array( "options" => array("min_range" => $min_columns, "max_range" => $max_columns));
    if (!(filter_var($columns, FILTER_VALIDATE_INT, $columns_options) === false)) {
        $columns_class = 'col-lg-' . 12/$columns;
    }
    $columns_class .= ($columns>4)?' col-md-3':'';
    $columns_class .= ($columns>3)?' col-sm-4':'';
    $columns_class .= ($columns>2)?' col-xs-6':'';
    $extra_classes = ' ' . $attributes['extra_classes'];
    $extra_classes .= (!$slider) ? ' equalized-group' : '';
    $element_id = ($attributes['element_id']) ? $attributes['element_id'] : '' ;
    $more_icon = '<i class="button-icon fa fa-plus" aria-hidden="true"></i>';
    $title_tag = 'h3';
    $image_size = 'medium_large';
    $args = array( 'taxonomy' => $taxonomy, 'offset' => $offset, 'hide_empty' => $hide_empty,);
    if (-1 !== $parent){ $args['parent'] = $parent;}
    if (!empty($exclude_terms_ids)){ $args['exclude'] = $exclude_terms_ids; }
    $terms = get_terms( $args );
    ob_start();
    if( !empty($terms) ){
        $element_id_attribute = ($element_id) ? ' id='.$element_id : '' ;
        echo '<section' . $element_id_attribute . ' class="post-terms post-terms-' . $post_terms_id . ' post-terms-parent-' . $parent . $extra_classes . '">';
            echo '<h2 class="post-terms-title">' . $section_title . '</h2>';
            echo '<div class="' . $container_class . '">';
                $terms_wrapper_class = ($slider) ? 'post-terms-slider-' . $post_terms_id : 'row' ;
                $term_wrapper_class = ($slider) ? 'post-container-wrapper' : $columns_class ;
                    echo '<div class="' . $terms_wrapper_class . '">';
                    $i = 0;
                    foreach( $terms as $term ) {
                        $term_link = get_term_link($term);
                        $term_thumb_id = get_term_meta($term->term_id, 'image', true);
                        $term_thumb = wp_get_attachment_image( $term_thumb_id, $image_size, false, array('class'=>'term-item-image') );
                        $term_name = $term->name;
                        echo '<div class="' . $term_wrapper_class . '">';
                            echo '<a class="term-item" href="' . $term_link . '">';
                                echo ($term_thumb) ? '<div class="term-thumb equalized-item">' . $term_thumb . '</div>' : '';
                                echo ($term_name) ? '<' . $title_tag. ' class="term-name equalized-item-alt">' . $term_name . '</' . $title_tag . '>' : '';
                                echo (term_description($term->term_id))? '<div class="term-description">' . term_description($term->term_id) . '</div>' : '';
                            echo '</a>';
                        echo '</div>';
                        $i++;
                    }
                    echo '</div>';
            echo '</div>';
        echo '</section>';
    } else {
        echo __("No Terms To Show", "jevelinchild");
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
    if ($post_terms_id>0) {
        $inline_js = $inline_js . 'terms_slick_options = ' . json_encode($slick_options);
    } else {
        $inline_js = $inline_js . 'let terms_slick_options = ' . json_encode($slick_options);
    }

    wp_enqueue_style('post-terms-css', get_stylesheet_directory_uri() . '/css/post-terms.css');
    if (!empty($inline_css)) {
        wp_add_inline_style( 'post-terms-css', $inline_css );
    }

    wp_enqueue_script(
        'post-terms-script',
        get_stylesheet_directory_uri() . '/js/post-terms.js',
        array('jquery', 'jevelin-plugins'),
        filemtime(get_stylesheet_directory() . '/js/post-terms.js'),
        true
    );
    wp_add_inline_script('post-terms-script', $inline_js, 'before');
    if (!empty($inline_js_after)) {
        wp_add_inline_script('post-terms-script', $inline_js_after, 'after');
    }
    $post_terms_id++;
    
    return $html;
}

//Integrate With VC
add_action('vc_before_init', 'post_terms_integrateWithVC');
function post_terms_integrateWithVC()
{
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
        "name" => __("Post Terms", "jevelinchild"),
        "base" => "post_terms",
        "description" => "Post Terms",
        "show_settings_on_create" => true,
        "category" => __("Content", "jevelinchild"),
        
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => __("Choose Taxonomy", "jevelinchild"),
                "param_name" => "taxonomy",
                "value" => $included_taxonomies,
                "group" => "Data",
                'admin_label' => true,
            ),
            array(
                "type" => "textfield",
                "heading" => __("Offset", "jevelinchild"),
                "param_name" => "offset",
                "value" => 0,
                "description" => __("Number of terms to discard before posting remain terms", "jevelinchild"),
                "group" => "Data",
                'admin_label' => true,
            ),
            array(
                "type" => "textfield",
                "heading" => __("Parent Term", "jevelinchild"),
                "param_name" => "parent",
                "value" => '-1',
                "description" => __("Parent term id, 0 for first level terms only, -1 for no-parent-filteration-effect", "jevelinchild"),
                "group" => "Data",
                'admin_label' => true,
            ),
            array(
                "type" => "checkbox",
                "heading" => __("Hide Empty Terms", "jevelinchild"),
                "param_name" => "hide_empty",
                "value" => false,
                "description" => __("Whether to include empty terms", "jevelinchild"),
                "group" => "Data",
                'admin_label' => true,
            ),
            array(
                "type" => "textarea",
                "heading" => __("Section Title", "jevelinchild"),
                "param_name" => "section_title",
                "value" => "Terms",
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
                "value" => 1,
                "min" => 1,
                "max" => 4,
                "description" => __("Number of terms per row", "jevelinchild"),
                "group" => "Structure",
                'admin_label' => true,
            ),
            array(
                "type" => "checkbox",
                "heading" => __("Slider", "jevelinchild"),
                "param_name" => "slider",
                "value" => false,
                "description" => __("Wrap terms in slider", "jevelinchild"),
                "group" => "Structure",
                'admin_label' => true,
            ),
            array(
                "type" => "textfield",
                "heading" => __("Extra Classes", "jevelinchild"),
                "param_name" => "extra_classes",
                "value" => "terms",
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