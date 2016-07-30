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
class Restaurants_Metabox_Menufiles extends Restaurants_Metabox {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {

		$this->post_type 	= 'restaurant';

		$subfields[] 		= array( 'menu-name', 'text', '' );
		$subfields[] 		= array( 'menu-url', 'url', '' ) ;
		$this->fields[] 	= array( 'menu-files', 'repeater', $subfields );

		$this->nonces[] 	= 'nonce_restaurants_menufiles';

	} // __construct()

	/**
	 * Registers metaboxes with WordPress
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @param 		object 			$post 			The post object.
	 */
	public function add_metaboxes( $post ) {

		add_meta_box(
			'restaurants_menufiles',
			apply_filters( RESTAURANTS_SLUG . '-menufiles-title', esc_html__( 'Menu Files', 'restaurants' ) ),
			array( $this, 'metabox' ),
			'restaurant',
			'side',
			'default',
			array(
				'file' => 'menufiles'
			)
		);

	} // add_metaboxes()

} // class
