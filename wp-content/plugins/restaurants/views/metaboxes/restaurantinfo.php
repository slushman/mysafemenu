<?php

/**
 * Displays the menu files metabox
 *
 * @link       https://www.mysafemenu.com
 * @since      1.0.0
 *
 * @package    Restaurants
 * @subpackage Restaurants/classes/views
 */

wp_nonce_field( RESTAURANTS_SLUG, 'nonce_restaurants_restaurantinfo' );

$atts 					= array();
$atts['id'] 			= 'restaurant-url';
$atts['label'] 			= esc_html__( 'Restaurant Website', 'restaurants' );
$atts['name'] 			= 'restaurant-url';
$atts['type'] 			= 'url';

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];

}

$atts = apply_filters( RESTAURANTS_SLUG . '-field-' . $atts['id'], $atts );

?><p><?php

include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/text.php' );
unset( $atts );

?></p><?php



$atts['description'] 	= __( 'What if there is not a published allergen menu. "Ask at restaurant.", "No menu available.", etc', 'restaurants' );
$atts['id'] 			= 'menu-instructions';
$atts['label'] 			= __( 'Menu Instructions', 'restaurants' );
$atts['settings'] 		= array();

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];

}

$atts = apply_filters( RESTAURANTS_SLUG . '-field-' . $atts['id'], $atts );

?><p><?php

include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/editor.php' );
unset( $atts );

?></p><?php
