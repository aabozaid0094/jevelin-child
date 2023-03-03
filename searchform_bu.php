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