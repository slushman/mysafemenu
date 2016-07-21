<?php

/**
 * Provides the markup for an image upload field
 *
 * @link       https://www.slushman.com
 * @since      1.0.0
 *
 * @package    Restaurants
 * @subpackage Restaurants/classes/views
 */

if ( ! empty( $atts['label'] ) ) {

	?><label for="<?php echo esc_attr( $atts['id'] ); ?>"><?php echo wp_kses( $atts['label'], array( 'code' => array() ) ); ?>: </label><?php

}

?><input
	class="<?php echo esc_attr( $atts['class'] ); ?>"
	data-id="image-file"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"
	type="hidden"
	value="<?php echo esc_attr( $atts['value'] ); ?>" />
<div class="image-upload-preview"></div>
<a href="#" class="" id="upload-file"><?php echo wp_kses( $atts['label-upload'], array( 'code' => array() ) ); ?></a>
<a href="#" class="hide" id="remove-file"><?php echo wp_kses( $atts['label-remove'], array( 'code' => array() ) ); ?></a>
