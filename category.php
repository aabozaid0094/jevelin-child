<?php 
$current_cat = get_category( get_query_var( 'cat' ) );
$current_cat_id = $current_cat->cat_ID;

$cat_columns = get_term_meta($current_cat_id, 'archive_columns', true);
$columns = intval( $cat_columns );
$columns_class = 'col-lg-12' ;
$min_columns = 1; $max_columns = 4; $columns_options = array( "options" => array("min_range" => $min_columns, "max_range" => $max_columns));
if (!(filter_var($columns, FILTER_VALIDATE_INT, $columns_options) === false)) {
	$columns_class = 'col-lg-' . 12/$columns;
}
$columns_class .= ($columns>2)?' col-md-6':'';

$cat_class = "articles";
$item_name = "article";
if(is_category(array('services','الخدمات','خدمات')) || cat_is_ancestor_of(get_category_by_slug('services'), $current_cat_id) || cat_is_ancestor_of(get_category_by_slug('الخدمات'), $current_cat_id) || cat_is_ancestor_of(get_category_by_slug('خدمات'), $current_cat_id)){
    $cat_class = "services";
    $item_name = "service";
}
wp_enqueue_style('posts-custom-css', get_stylesheet_directory_uri() . '/css/posts-custom.css');
get_header();
?>

	<div id="content">
		<div class="posts-custom<?php echo ($cat_class) ? ' '.$cat_class : ''; ?>">

			<?php
				if ( have_posts() ) {
                    echo '<div class="row">';
					while ( have_posts() ) : the_post();
                        echo '<div class="' . $columns_class . '">';
                        if( locate_template( 'content-item-'.$item_name.'.php' ) != '' ){
                            get_template_part( 'content', 'item-'.$item_name );
                        } else {
                            get_template_part( 'content' );
                        }
						echo '</div>';
					endwhile;
					echo '</div>';
				} else {
					get_template_part( 'content', 'none' );
                }
			?>

		</div>

	</div>

<?php get_footer(); ?>