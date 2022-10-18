<?php
function register_widget_areas()
{
	$widget_areas = get_field('widget_areas', 'option');
	if ($widget_areas) {
		foreach ($widget_areas as $index => $widget_area) {
			$widget_area_name = ( $widget_area['name'] ) ? $widget_area['name'] . ' Widgets' : 'Widget ' . $index . ' Widgets';
			$widget_area_id = ( $widget_area['name'] ) ? sanitize_title( $widget_area['name'] ) . '-widgets' : 'widget-' . $index . '-widgets';
			$widget_area_description = ( $widget_area['description'] ) ? $widget_area['description'] : $widget_area_name;
			$widget_area_class = ( $widget_area['classes'] ) ? $widget_area['classes'] : '';
			$widget_title_classes = ( $widget_area['title_classes'] ) ? ' ' . $widget_area['title_classes'] : '';
			register_sidebar(
				array(
					'name'				=> esc_html__($widget_area_name, 'jevelinchild'),
					'id'				=> $widget_area_id,
					'description'		=> esc_html__( $widget_area_description, 'jevelinchild' ),
					'class'				=> $widget_area_class,
					'before_widget'		=> '<div id="%1$s" class="widget-item %2$s">',
					'after_widget'		=> '</div>',
					'before_title'		=> '<h3 class="widget-title' . $widget_title_classes . '">',
					'after_title'		=> '</h3>',
					'before_sidebar'	=> '<div id="%1$s" class="widget-area %2$s">',
					'after_sidebar'		=> '</div>',
				)
			);
		}
	}
}
add_action('widgets_init', 'register_widget_areas');