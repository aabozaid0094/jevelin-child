<?php 
/**
 * Search
 */

set_query_var( 'style', 'masonry masonry-shadow' );
wp_enqueue_style('posts-custom-css', get_stylesheet_directory_uri() . '/css/posts-custom.css');
get_header();
?>
	<div id="content">
		<?php
			echo '<div id="search_row">';
				echo get_search_form();
			echo '</div>';
		?>
		<div class="search_result posts-custom equalized-group">
			<?php
				if ( have_posts() ) :
					echo '<div class="row">';
						while ( have_posts() ) : the_post();
							echo '<div class="col-md-4 col-sm-6">';
								get_template_part( 'content', 'item-post' );
							echo '</div>';
						endwhile;
					echo '</div>';
				else :
					get_template_part( 'content', 'none' );
				endif;
			?>
			</div>
				<?php jevelin_pagination(); ?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>