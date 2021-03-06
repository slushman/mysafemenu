<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link 		https://www.mysafemenu.com
 * @since 		1.0.0
 *
 * @package 	Restaurants
 * @subpackage 	Restaurants/classes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package 	Restaurants
 * @subpackage 	Restaurants/classes
 * @author 		Slushman <chris@slushman.com>
 */
class Restaurants_Public {

	/**
	 * The post meta data
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$meta    			The post meta data.
	 */
	private $meta;

	/**
	 * The plugin options.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$options 		The plugin options.
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->set_options();
		$this->set_meta();

	} // __construct()

	/**
	 * Creates a new column to sort SQL queries by.
	 *
	 * @param 		string 		$fields 		The current fields statement.
	 * @return 		string 						The modified fields statement.
	 */
	public function create_temp_column( $fields, $query ) {

		if ( 'restaurant' !== $query->query['post_type'] ) { return $fields; }

		global $wpdb;

		$matches = 'The';
		$has_the = " CASE
			WHEN $wpdb->posts.post_title regexp( '^($matches)[[:space:]]' )
				THEN trim(substr($wpdb->posts.post_title from 4))
			ELSE $wpdb->posts.post_title
				END AS title2";

		if ( $has_the ) {

			$fields .= ( preg_match( '/^(\s+)?,/', $has_the ) ) ? $has_the : ", $has_the";

		}

		return $fields;

	} // create_temp_column()

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( RESTAURANTS_SLUG, plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/restaurants-public.css', array(), RESTAURANTS_VERSION, 'all' );

	} // enqueue_styles()

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( RESTAURANTS_SLUG, plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/restaurants-public.min.js', array( 'jquery' ), RESTAURANTS_VERSION, true );

	} // enqueue_scripts()

	/**
	 * Sets the class variable $options
	 */
	public function set_meta() {

		global $post;

		if ( empty( $post ) ) { return; }
		if ( 'restaurant' !== $post->post_type ) { return; }

		$this->meta = get_post_custom( $post->ID );

	} // set_meta()

	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( RESTAURANTS_SLUG . '-options' );

	} // set_options()

	/**
	 * Sorts the orderby parameter for WP_Query by the temp column.
	 *
	 * @param 		string 		$orderby 		The current orderby statement.
	 * @return 		string 						The modified orderby statement.
	 */
	public function sort_by_temp_column( $orderby, $query ) {

		if ( 'restaurant' !== $query->query['post_type'] ) { return $orderby; }

		$custom_orderby = " UPPER(title2) ASC";

		if ( $custom_orderby ) {

			$orderby = $custom_orderby;

		}

		return $orderby;

	} // sort_by_temp_column()

	/**
	 * Processes shortcode listrestaurants
	 *
	 * @param 	array 	$atts 		Shortcode attributes
	 *
	 * @return	mixed	$output		Output of the buffer
	 */
	public function shortcode_listrestaurants( $atts = array() ) {

		ob_start();

		$defaults['taxonomyname'] 	= '';
		$defaults['loop-template'] 	= RESTAURANTS_SLUG . '-loop';
		$defaults['order'] 			= 'ASC';
		$defaults['orderby'] 		= 'title';
		$defaults['quantity'] 		= 300;
		$defaults['show'] 			= '';
		$args						= shortcode_atts( $defaults, $atts, 'listrestaurants' );
		$shared 					= new Restaurants_Shared( RESTAURANTS_SLUG, RESTAURANTS_VERSION );
		$items 						= $shared->query( $args );
		$items 						= apply_filters( 'after_get_restaurants', $items );

		if ( is_array( $items ) || is_object( $items ) ) {

			include restaurants_get_template( 'restaurants-loop', 'loop' );

		} else {

			echo $items;

		}

		$output = ob_get_contents();

		ob_end_clean();

		return $output;

	} // shortcode_listrestaurants()

} // class
