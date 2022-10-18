<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

if( !class_exists('Widget_Recent_Posts_Category') ) :
	class Widget_Recent_Posts_Category extends WP_Widget {

		function __construct() {
			$widget_ops = array( 'description' => esc_html__( 'Recent Posts Category', 'jevelinchild' ) );

			parent::__construct( false, esc_html__( 'Shufflehound Recent Posts Category', 'jevelinchild' ), $widget_ops );
		}

		function widget( $args, $instance ) {
			extract( $args );
			$params = array();

			foreach ( $instance as $key => $value ) {
				$params[ $key ] = $value;
			}

			$title = $before_title . $params['widget-title'] . $after_title;
			unset( $params['widget-title'] );

			$filepath = get_stylesheet_directory() . '/inc/widgets/recent-posts-category/views/widget.php';

			$instance      = $params;
			$before_widget = str_replace( 'class="', 'class="widget_social_links ', $before_widget );

			if ( file_exists( $filepath ) ) {
				include $filepath;
			}
		}

		function update( $new_instance, $old_instance ) {
			$instance = wp_parse_args( (array) $new_instance, $old_instance );

			return $instance;
		}

		function form( $instance ) {

			$titles = array(
				'widget-title' => esc_html__( 'Recent Posts Title:', 'jevelinchild' ),
				'items_per_page'     => esc_html__( 'Items Per Page:', 'jevelinchild' ),
				'cat'     => esc_html__( 'Category ID:', 'jevelinchild' ),
			);

			$instance = wp_parse_args( (array) $instance, $titles );

			foreach ( $instance as $key => $value ) {
				?>
				<p>
					<label><?php echo esc_attr( $titles[ $key ] ); ?></label>
					<input class="widefat widget_social_link widget_link_field"
					       name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" type="text"
					       value="<?php echo ( $instance[ $key ] === $titles[ $key ] ) ? '' : esc_attr( $instance[ $key ] ); ?>"/>
				</p>
			<?php
			}
		}
	}
endif;
