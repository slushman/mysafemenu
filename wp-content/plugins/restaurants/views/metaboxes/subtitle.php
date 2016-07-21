<?php

/**
 * Displays a metabox
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Restaurants
 * @subpackage Restaurants/classes/views
 */

wp_nonce_field( RESTAURANTS_SLUG, 'nonce_restaurants_subtitle' );

$atts 					= array();
$atts['class'] 			= 'widefat';
$atts['description'] 	= '';
$atts['id'] 			= 'subtitle';
$atts['label'] 			= __( 'Subtitle', 'restaurants' );
$atts['name'] 			= 'subtitle';
$atts['placeholder'] 	= __( 'Enter the subtitle', 'restaurants' );
$atts['type'] 			= 'text';
$atts['value'] 			= '';

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];

}

$atts = apply_filters( RESTAURANTS_SLUG . '-field-subtitle', $atts );

?><p><?php

include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/text.php' );

?></p>