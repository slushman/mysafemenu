<?php

/**
 * Displays a metabox
 *
 * @link 		https://www.mysafemenu.com
 * @since      1.0.0
 *
 * @package    Restaurants
 * @subpackage Restaurants/classes/views
 */

wp_nonce_field( RESTAURANTS_SLUG, 'nonce_restaurants_menufile' );

$atts 					= array();
$atts['class'] 			= 'text widefat';
$atts['description'] 	= esc_html__( '', 'restaurants' );
$atts['id'] 			= 'menu-file';
$atts['label'] 			= esc_html__( '', 'restaurants' );
$atts['label-remove'] 	= esc_html__( 'Remove File', 'restaurants' );
$atts['label-upload'] 	= esc_html__( 'Upload/Choose File', 'restaurants' );
$atts['name'] 			= 'menu-file';
$atts['placeholder'] 	= esc_html__( '', 'restaurants' );
$atts['type'] 			= 'url';
$atts['value'] 			= '';

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];

}

$atts = apply_filters( RESTAURANTS_SLUG . '-field-' . $atts['id'], $atts );

?><p><?php

include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/file-upload.php' );

?></p>
