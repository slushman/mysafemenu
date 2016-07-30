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
class Restaurants_Metabox_RestaurantInfo extends Restaurants_Metabox {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {

		$this->post_type 	= 'restaurant';

		$this->fields[] 	= array( 'restaurant-url', 'url', '' );
		$this->fields[] 	= array( 'menu-instructions', 'editor', '' );

		$this->nonces[] 	= 'nonce_restaurants_restaurantinfo';

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
			'restaurants_restaurantinfo',
			apply_filters( RESTAURANTS_SLUG . '-restaurantinfo-title', esc_html__( 'Restaurant Info', 'restaurants' ) ),
			array( $this, 'metabox' ),
			'restaurant',
			'normal',
			'default',
			array(
				'file' => 'restaurantinfo'
			)
		);

	} // add_metaboxes()

} // class
