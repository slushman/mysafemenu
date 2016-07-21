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

wp_nonce_field( RESTAURANTS_SLUG, 'nonce_restaurants_menufiles' );

$setatts 						= array();
$setatts['id'] 					= 'menu-files';
$setatts['labels']['add'] 		= __( 'Add Menu', 'restaurants' );
$setatts['labels']['edit'] 		= __( 'Edit Menu', 'restaurants' );
$setatts['labels']['header'] 	= __( 'Menu Name', 'restaurants' );
$setatts['labels']['remove'] 	= __( 'Remove Menu', 'restaurants' );

$field2 						= array();
$field2['description'] 			= __( '', 'restaurants' );
$field2['fieldtype'] 			= 'text';
$field2['id'] 					= 'menu-name-field';
$field2['label'] 				= __( 'Menu Name', 'restaurants' );
$field2['name'] 				= 'menu-name-field';

$field1 						= array();
$field1['data']['title'] 		= '';
$field1['fieldtype'] 			= 'text';
$field1['id'] 					= 'menu-url-field';
$field1['label'] 				= __( 'Menu File', 'restaurants' );
$field1['label-remove'] 		= __( 'Remove Menu', 'restaurants' );
$field1['label-upload'] 		= __( 'Upload/Choose Menu', 'restaurants' );
$field1['name'] 				= 'menu-url-field';
$field1['type'] 				= 'url';

$setatts['fields'] 				= array( $field1, $field2 );

$setatts 						= apply_filters( PLUGIN_NAME_SLUG . '-field-' . $setatts['id'], $setatts );

$count 							= 1;
$repeater 						= array();

if ( ! empty( $this->meta[$setatts['id']] ) ) {

	$repeater = maybe_unserialize( $this->meta[$setatts['id']][0] );

}

if ( ! empty( $repeater ) ) {

	$count = count( $repeater );

}

?><p><?php

include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/repeater.php' );

?></p>
