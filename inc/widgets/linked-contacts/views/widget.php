<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

/**
 * @var $instance
 * @var $before_widget
 * @var $after_widget
 * @var $title
 */


?>

<?php if ( ! empty( $instance ) ) : ?>
<?php 
if (!function_exists('endsWith')){
	function endsWith($haystack, $needle)
	{
		$length = strlen($needle);
		if ($length == 0) { return true; }
		return (substr($haystack, -$length) === $needle);
	}
}

$mainKeys = array();
foreach ( $instance as $key => $value ) :
	if (!endsWith($key, '_link')) {
		array_push($mainKeys, $key);
	}
endforeach;

$formedInstance = array();
foreach ( $mainKeys as $value ) :
	$formedInstance[$value] = array($instance[$value.'_link'], $instance[$value], );
endforeach;

?>
	<?php echo wp_kses_post( $before_widget ); ?>
	<div class="wrap-social">
		<?php echo wp_kses_post( $title ); ?>
		<?php foreach ( $formedInstance as $key => $value ) : ?>
			<?php if ( empty( $value[1] ) ) { continue; } ?>
			<div class="sh-contacts-widget-item">
				<?php if(!empty( $value[0] )){?>
				<a href="<?php echo $value[0]; ?>">
				<?php } ?>
					<i class="<?php
						if( $key == 'address' ) :
							echo 'icon-map';
							elseif( $key == 'phone' ) :
							echo 'icon-phone';
							elseif( $key == 'email' ) :
							echo 'icon-envelope';
							elseif( $key == 'whatsapp' ) :
							echo 'fa fa-whatsapp';
							else :
								echo 'icon-clock';
							endif;
							?>"></i>
					<?php echo do_shortcode( wp_kses_post( $value[1] )); ?>
					<?php if(!empty( $value[0] )){?>
					</a>
					<?php } ?>
				</div>
		<?php endforeach; ?>

	</div>
	<?php echo wp_kses_post( $after_widget ); ?>
<?php endif; ?>
