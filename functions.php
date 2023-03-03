<?php

/**
 * Theme functions file
 */

 
// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value
function CallAPI($method, $url, $username = '', $password = '', $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
	if (!empty($username) && !empty($password)) {
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, "${username}:${password}");
	}

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

/**
 * Enqueue parent theme styles first
 * Replaces previous method using @import
 * <http://codex.wordpress.org/Child_Themes>
 */

add_action('wp_enqueue_scripts', 'jevelin_child_enqueue', 99);

function jevelin_child_enqueue()
{
	wp_enqueue_style('jevelin-child-style', get_stylesheet_directory_uri() . '/style.css');
	wp_enqueue_style('child-style-overwrite', get_stylesheet_directory_uri() . '/style-overwrite.css');
	wp_enqueue_script('fontawesome-kit', 'https://kit.fontawesome.com/ce4452f79c.js', array(), null, true);
	wp_enqueue_script('equalizer-script', get_stylesheet_directory_uri() . '/js/equalizer.js', array(), null, true);
	wp_enqueue_script('jevelin-child-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'),
	filemtime( get_stylesheet_directory() . '/js/scripts.js' ), true
	);
}

/**
 * Add your custom functions below
 */

function add_font_awesome_attributes( $html, $handle ) {
    if ( 'fontawesome-kit' === $handle ) {
        return str_replace( "ce4452f79c.js'", "ce4452f79c.js' crossorigin='anonymous'", $html );
    }
    return $html;
}
add_filter( 'script_loader_tag', 'add_font_awesome_attributes', 10, 2 );

load_theme_textdomain('jevelinchild');

//Unyson Unclosed Session
if (!function_exists('_disable_fw_use_sessions')) {
	add_filter('fw_use_sessions', '_disable_fw_use_sessions');
	function _disable_fw_use_sessions(){ return false; }
}

// Remove Website From Comment Form
add_filter('comment_form_default_fields', 'unset_url_field');
function unset_url_field($fields){
	if(isset($fields['url']))
		unset($fields['url']);
	return $fields;
}

// Update CSS within in Admin
function custom_admin_style()
{
	wp_enqueue_style('custom-admin-styles', get_stylesheet_directory_uri() . '/custom-admin.css');
}
add_action('admin_enqueue_scripts', 'custom_admin_style');

// Add support of excerpt, categories and tags to pages, to use them as services
add_post_type_support('page', 'excerpt');
function add_taxonomies_to_pages()
{
	register_taxonomy_for_object_type('post_tag', 'page');
	register_taxonomy_for_object_type('category', 'page');
}
add_action('init', 'add_taxonomies_to_pages');
function category_and_tag_archives($wp_query)
{
	$my_post_array = array('post', 'page');

	if ($wp_query->get('category_name') || $wp_query->get('cat'))
		$wp_query->set('post_type', $my_post_array);

	if ($wp_query->get('tag'))
		$wp_query->set('post_type', $my_post_array);
}
if (!is_admin()) {
	add_action('pre_get_posts', 'category_and_tag_archives');
}

//Remove Pre-Title From Archive Pages
function custom_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    }
  
    return $title;
}
add_filter( 'get_the_archive_title', 'custom_archive_title' );

add_action( 'admin_init', 'post_page_attributes' );
function post_page_attributes(){ add_post_type_support( 'post', 'page-attributes' ); }

//Comments Customization
include get_theme_file_path('/inc/comment-customization.php');

//WPBakery Buttons
include get_theme_file_path('/inc/vc-buttons.php');

//Posts Views
include get_theme_file_path('/inc/post_views.php');

//Content in Minutes
include get_theme_file_path('/inc/content_in_minutes.php');

//Posts Custom
include get_theme_file_path('/inc/posts_custom/posts_custom.php');

//Post Terms
include get_theme_file_path('/inc/post_terms.php');

//Search Refine
include get_theme_file_path('/inc/search_refine.php');

//Team Item
include get_theme_file_path('/inc/team_item.php');

//Testimonial Item
include get_theme_file_path('/inc/testimonial_item.php');

//Iconbox
include get_theme_file_path('/inc/iconbox.php');

//Featurebox
include get_theme_file_path('/inc/featurebox.php');

//Custom Button
include get_theme_file_path('/inc/button_custom.php');

//Featured Post
include get_theme_file_path('/inc/featured_post.php');

//Admin Columns
include get_theme_file_path('/inc/admin_columns.php');

//Jevelin Social
include get_theme_file_path('/inc/jevelin_social.php');

//ACF Options
if( class_exists('ACF') ){
	//Options Pages
	include get_theme_file_path('/inc/acf-options/options-pages.php');
	//Post Sticky Buttons Code To Website
	include get_theme_file_path('/inc/acf-options/sticky-buttons.php');
	//Custom Testimonials
	include get_theme_file_path('/inc/acf-options/testimonials.php');
	//Post Head Scripts Code To Website
	include get_theme_file_path('/inc/acf-options/head-scripts.php');
	//Post Footer Scripts Code To Website
	include get_theme_file_path('/inc/acf-options/footer-scripts.php');
	//Register Widget Areas
	include get_theme_file_path('/inc/acf-options/widget-areas.php');
	//Add All Post Types Dynamically To Option Field
	add_filter('acf/load_field/name=testimonials_post_type', 'acf_load_post_types');
	function acf_load_post_types($field)
	{
		foreach ( get_post_types( array('public' => true,), 'objects' ) as $post_type ) {
			$field['choices'][$post_type->name] = $post_type->label;
		}
		return $field;
	}
	function post_schema() {
		echo (get_field('schema')) ? get_field('schema') : '';
	}
	add_action('wp_head', 'post_schema');
}

function register_services_widget_area(){
	register_sidebar(
		array(
			'name'				=> esc_html__('Services Widgets', 'jevelinchild'),
			'id'				=> 'services-widgets',
			'description'		=> esc_html__( 'Services Widgets', 'jevelinchild' ),
			'class'				=> 'services_widgets',
			'before_widget'		=> '<div id="%1$s" class="widget-item %2$s">',
			'after_widget'		=> '</div>',
			'before_title'		=> '<h3 class="widget-title services-widget-title">',
			'after_title'		=> '</h3>',
			'before_sidebar'	=> '<div id="%1$s" class="widget-area %2$s">',
			'after_sidebar'		=> '</div>',
		)
	);
}
add_action('widgets_init', 'register_services_widget_area');

function shortNumber($num) 
{
    $units = ['', 'K', 'M', 'B', 'T'];
    for ($i = 0; $num >= 1000; $i++) {
        $num /= 1000;
    }
    return round($num, 1) . $units[$i];
}