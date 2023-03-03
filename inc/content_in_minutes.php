<?php
// old meta key: time_to_read
function content_in_minutes($post_id){
    $post_id = ($post_id) ? $post_id : get_the_ID() ;
    $cim = ceil(str_word_count(get_the_content( null, false, $post_id )) / 130);
    $cim_key = 'content_in_minutes';
    update_post_meta($post_id, $cim_key, $cim);
    return $cim;
}
function content_in_minutes_text($post_id){
	return content_in_minutes($post_id) . " " . __("min reading", "jevelinchild");
}