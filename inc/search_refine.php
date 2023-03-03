<?php
/**
 * Add HTML5 theme support.
 */
function jc_after_setup_theme() {
	add_theme_support( 'html5', array( 'search-form' ) );
}
add_action( 'after_setup_theme', 'jc_after_setup_theme' );

/**
 * Generate custom search form
 *
 * @param string $form Form HTML.
 * @return string Modified form HTML.
 */
function jc_my_search_form( $form ) {
    ob_start();

	?>
	<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
		<label class="search_input">
			<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'jevelinchild' ) ?></span>
			<input type="search" class="search-field"
				placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder', 'jevelinchild' ) ?>"
				value="<?php echo get_search_query() ?>" name="s"
				title="<?php echo esc_attr_x( 'Search for:', 'label', 'jevelinchild' ) ?>" />
		</label>
		<label class="search_sort_select">
			<span class="screen-reader-text"><?php echo _x( 'Sort by:', 'label', 'jevelinchild' ) ?></span>
			<select name="meta_orderby">
				<option value="">Date</option>
				<option value="Views" <?php echo ($_GET['meta_orderby']=='Views')?'selected':'' ?>>
					<?php echo esc_attr_x( 'Views', 'sort option', 'jevelinchild' ) ?>
				</option>
				<option value="content_in_minutes" <?php echo ($_GET['meta_orderby']=='content_in_minutes')?'selected':'' ?>>
					<?php echo esc_attr_x( 'Read Time', 'sort option', 'jevelinchild' ) ?>
				</option>
			</select>
		</label>
		<input type="hidden" value="post" name="post_type" id="post_type" />
		<input type="submit" class="search-submit"
			value="<?php echo esc_attr_x( 'Search', 'submit button', 'jevelinchild' ) ?>" />
	</form>
	<?php
	
    $form = ob_get_clean();
	return $form;
}
add_filter( 'get_search_form', 'jc_my_search_form', 11 );

add_action( 'pre_get_posts', 'pre_get_posts_with_order');
function pre_get_posts_with_order($q)
{
    if (    !is_admin() // Target only front end queries
         && $q->is_main_query() // Target the main query only
         && ( $q->is_search() || $q->is_archive() )
    ) {
		$orderby = $_GET['meta_orderby'];
		if ($orderby == 'Views') {
			$q->set('meta_key', $orderby);
			$q->set('orderby', 'meta_value_num');
		}
		elseif (in_array($orderby, array('content_in_minutes','time_to_read'), true)) {
			$q->set('meta_key', $orderby);
			$q->set('order', 'ASC');
			$q->set('orderby', 'meta_value_num');
		}
    }
}