<?php
/**
 * The metabox-specific functionality of the plugin.
 *
 * @link 		https://www.mysafemenu.com
 * @since 		1.0.0
 *
 * @package 	Restaurants
 * @subpackage 	Restaurants/classes
 * @author 		Slushman <chris@slushman.com>
 */
class Restaurants_Metabox_Menufile extends Restaurants_Metabox {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {

		$this->post_type 	= 'restaurant';

		$this->fields[] 	= array( 'menu-file', 'url', '' );

		$this->nonces[] 	= 'nonce_restaurants_menufile';

	} // __construct()

	/**
	 * Registers metaboxes with WordPress
	 *
	 * @since 	1.0.0
	 * @access 	public
	 */
	public function add_metaboxes() {

		add_meta_box(
			'restaurants_menufile',
			apply_filters( RESTAURANTS_SLUG . '-menufile-title', esc_html__( 'Menu File', 'restaurants' ) ),
			array( $this, 'metabox' ),
			'restaurant',
			'side',
			'default',
			array(
				'file' => 'menufile'
			)
		);

	} // add_metaboxes()

} // class
