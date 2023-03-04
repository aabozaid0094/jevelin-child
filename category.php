<?php 
$current_cat = get_category( get_query_var( 'cat' ) );
$current_cat_id = $current_cat->cat_ID;

$archive_columns = get_term_meta($current_cat_id, 'archive_columns', true);
$columns = intval( $archive_columns );
$columns_class = 'col-lg-12' ;
$min_columns = 1; $max_columns = 4; $columns_options = array( "options" => array("min_range" => $min_columns, "max_range" => $max_columns));
if (!(filter_var($columns, FILTER_VALIDATE_INT, $columns_options) === false)) {
	$columns_class = 'col-lg-' . 12/$columns;
}
$columns_class .= ($columns>2)?' col-md-6':'';

$archive_classes = get_term_meta($current_cat_id, 'archive_classes', true) ? get_term_meta($current_cat_id, 'archive_classes', true) : "articles";
$item_slug = get_term_meta($current_cat_id, 'item_slug', true) ? get_term_meta($current_cat_id, 'item_slug', true) : "post";
$content_before = get_term_meta($current_cat_id, 'content_before', true) ? get_term_meta($current_cat_id, 'content_before', true) : "";
$content_after = get_term_meta($current_cat_id, 'content_after', true) ? get_term_meta($current_cat_id, 'content_after', true) : "";

wp_enqueue_style('posts-custom-css', get_stylesheet_directory_uri() . '/css/posts-custom.css');
get_header();
?>
	<div id="content">
		<?php echo ($content_before) ? '<div class="content-before">' . do_shortcode( $content_before ) . '</div>' : ''; ?>

		<div class="posts-custom<?php echo ($archive_classes) ? ' '.$archive_classes : ''; ?>">

			<?php
				if ( have_posts() ) {
                    echo '<div class="row">';
					while ( have_posts() ) : the_post();
                        echo '<div class="' . $columns_class . '">';
                        if( locate_template( 'content-item-'.$item_slug.'.php' ) != '' ){
                            get_template_part( 'content', 'item-'.$item_slug, array('favicon_link' => $favicon_link, 'columns' => $columns, ) );
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
				<?php jevelin_pagination(); ?>
			</div>

		</div>
		
		<?php echo ($content_after) ? '<div class="content-after">' . do_shortcode( $content_after ) . '</div>' : ''; ?>
	</div>

<?php get_footer(); ?>