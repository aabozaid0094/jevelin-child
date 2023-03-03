<?php
function unset_url_form_field($fields){
    unset($fields['url']);
    return $fields;
}
add_filter('comment_form_default_fields', 'unset_url_form_field');

function comment_phone_form_field($fields){
    $fields['comment_phone'] = '<label>' . __('Phone', 'jevelinchild') . ' <i class="icon-check sh-accent-color"></i> </label><p class="comment-form-comment_phone"> <input id="comment_phone" name="comment_phone" type="tel" required></p>';
    return $fields;
}
add_filter('comment_form_default_fields', 'comment_phone_form_field');

function verify_comment_phone_data($commentdata){
    if (!isset($_POST['comment_phone'])) {
        wp_die(__('Error: please fill the required field (Phone).'));
    }
    return $commentdata;
}
add_filter('preprocess_comment', 'verify_comment_phone_data');

function save_comment_phone_field($comment_id){
    if (isset($_POST['comment_phone'])) {
        update_comment_meta($comment_id, 'comment_phone', esc_attr($_POST['comment_phone']));
    }
}
add_action('comment_post', 'save_comment_phone_field');

function add_comments_columns( $columns ){
    $new_columns = array(
        'comment_phone' => __('Phone', 'jevelinchild'),
    );
    
    return array_merge($columns, $new_columns);
}
add_filter( 'manage_edit-comments_columns', 'add_comments_columns' );

function add_comments_columns_content( $column, $comment_ID ) {
	switch ( $column ) :
		case 'comment_phone' : {
            echo get_comment_meta( $comment_ID, "comment_phone", true );
			break;
		}
	endswitch;
}
add_action( 'manage_comments_custom_column', 'add_comments_columns_content', 10, 2 );

function comment_columns_too_wide(){
    echo '<style>#comment_phone{width:150px;}</style>';
}
add_action( 'admin_head', 'comment_columns_too_wide' );

/**
 * Filter to move comment field to the last
 */
add_filter( 'comment_form_fields', 'reorder_comment_form_fields', 10, 1 );
/**
 * Move comment field to the last
 * @param $comment_fields
 * @return mixed
 */
function reorder_comment_form_fields($comment_fields) {
    if (isset($comment_fields['comment'])) {
        $comment_field = $comment_fields['comment'];
        unset($comment_fields['comment']);
        $comment_fields['comment'] = $comment_field;
        if (isset($comment_fields['cookies'])) {
            $consent_field = $comment_fields['cookies'];
            unset($comment_fields['cookies']);
            $comment_fields['cookies'] = $consent_field;
        }
    }

    return $comment_fields;
}
    