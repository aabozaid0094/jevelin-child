<?php
//Generic Function To Add Column To Admin CPT Page
function add_admin_column($column_title, $post_type, $cb){
	// Column Header
    add_filter( 'manage_' . $post_type . '_posts_columns', function($columns) use ($column_title) {
		$columns[ sanitize_title($column_title) ] = $column_title;
        return $columns;
    } );
    // Column Content
    add_action( 'manage_' . $post_type . '_posts_custom_column' , function( $column, $post_id ) use ($column_title, $cb) {
		if(sanitize_title($column_title) === $column){
			$cb($post_id);
        }
    }, 10, 2 );
}

//Hundle Admin Posts Column
add_admin_column(__('Post Views', 'jevelinchild'), 'post', function($post_id){
	echo getPostViews($post_id); 
});

//Hundle Admin Testimonials Column
add_admin_column(__('Testimonial Info', 'jevelinchild'), 'testimonial', function($post_id){
	echo get_post_meta($post_id, 'info', true); 
});
add_admin_column(__('Testimonial Quote', 'jevelinchild'), 'testimonial', function($post_id){
	echo substr( get_post_meta($post_id, 'quote', true), 0, 100).'...'; 
});
add_admin_column(__('Testimonial Image', 'jevelinchild'), 'testimonial', function($post_id){
	echo get_the_post_thumbnail($post_id, array(100, 100)); 
});