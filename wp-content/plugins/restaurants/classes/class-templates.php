<?php
/**
 * Template-related functions
 *
 * @link 		https://www.slushman.com
 * @since 		1.0.0
 *
 * @package		Restaurants
 * @subpackage 	Restaurants/classes
 * @author 		Slushman <chris@slushman.com>
 */

if ( ! function_exists( 'restaurants_templates' ) ) {

	/**
	 * Public API for adding and removing temmplates.
	 *
	 * @return 		object 			Instance of the templates class
	 */
	function restaurants_templates() {

		return Restaurants_Templates::this();

	} // restaurants_templates()

} // check

/**
 * The public-facing functionality of the plugin.
 *
 * @link 		https://www.slushman.com
 * @since 		1.0.0
 *
 * @package 	Restaurants
 * @subpackage 	Restaurants/classes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the methods for creating the templates.
 *
 * @package 	Restaurants
 * @subpackage 	Restaurants/classes
 *
 */
class Restaurants_Templates {

	/**
	 * Private static reference to this class
	 * Useful for removing actions declared here.
	 *
	 * @var 	object 		$_this
 	 */
	private static $_this;

	/**
	 * The plugin options.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$options    The plugin options.
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {

		self::$_this = $this;

		$this->set_options();

	} // __construct()

	/**
	 * Returns an array of the featured image details
	 *
	 * @param 	int 	$postID 		Post ID
	 * @return 	array 					Array of info about the featured image
	 */
	public function get_featured_images( $postID ) {

		if ( empty( $postID ) ) { return FALSE; }

		$imageID = get_post_thumbnail_id( $postID );

		if ( empty( $imageID ) ) { return FALSE; }

		return wp_prepare_attachment_for_js( $imageID );

	} // get_featured_images()

	/**
	 * Includes the link start template file
	 *
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_link_begin( $item, $meta = array() ) {

		include restaurants_get_template( 'content-link-begin', 'loop' );

	} // loop_content_link_begin()

	/**
	 * Includes the link end template file
	 *
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_link_end( $item, $meta = array() ) {

		include restaurants_get_template( 'content-link-end', 'loop' );

	} // loop_content_link_end()

	/**
	 * Includes the featured image template
	 *
	 * @hooked 		restaurants-loop-content 		10
	 *
	 * @param 		object 		$item 		A post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_image( $item, $meta = array() ) {

		include restaurants_get_template( 'content-image', 'loop' );

	} // loop_content_image()

	/**
	 * Includes the meta field template file
	 */
	public function loop_content_meta_field( $item, $meta = array() ) {

		include restaurants_get_template( 'content-meta-field', 'loop' );

	} // loop_content_meta_field()

	/**
	 * Includes the restaurants-subtitle template
	 *
	 * @hooked 		restaurants-loop-content 		30
	 *
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_subtitle( $item, $meta = array() ) {

		include restaurants_get_template( 'content-subtitle', 'loop' );

	} // loop_content_subtitle()

	/**
	 * Includes the restaurants-title template
	 *
	 * @hooked 		restaurants-loop-content 		20
	 *
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_title( $item, $meta = array() ) {

		include restaurants_get_template( 'content-title', 'loop' );

	} // loop_content_title()

	/**
	 * Includes the content wrap start template file
	 *
	 * @hooked 		restaurants-before-loop-content 		10
	 *
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_wrap_begin( $item, $meta = array() ) {

		include restaurants_get_template( 'content-wrap-begin', 'loop' );

	} // loop_content_wrap_begin()

	/**
	 * Includes the content wrap end template file
	 *
	 * @param 		object 		$item 		Post object
	 * @param 		array 		$meta 		The post metadata
	 */
	public function loop_content_wrap_end( $item, $meta = array() ) {

		include restaurants_get_template( 'content-wrap-end', 'loop' );

	} // loop_content_wrap_end()

	/**
	 * Includes the list wrap start template file and sets the value of $class.
	 *
	 * If the taxonomyname shortcode attribute is used, it sets $class as the
	 * taxonomyname or taxonomynames. Otherwise, $class is blank.
	 *
	 * @param 		array 		$args 		The shortcode attributes
	 */
	public function loop_wrap_begin( $args ) {

		if ( empty( $args['taxonomyname'] ) ) {

			$class = '';

		} elseif ( is_array( $args['taxonomyname'] ) ) {

			$class = str_replace( ',', ' ', $args['taxonomyname'] );

		} else {

			$class = $args['taxonomyname'];

		}

		include restaurants_get_template( 'wrap-begin', 'loop' );

	} // list_wrap_begin()

	/**
	 * Includes the list wrap end template file
	 *
	 * @param 		array 		$args 		The shortcode attributes
	 */
	public function loop_wrap_end( $args ) {

		include restaurants_get_template( 'wrap-end', 'loop' );

	} // list_wrap_end()

	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( RESTAURANTS_SLUG . '-options' );

	} // set_options()

	/**
	 * Includes the single restaurant meta field
	 *
	 * @param 		array 		$meta 		The post metadata
	 */
	public function single_restaurant_meta_field( $meta ) {

		include restaurants_get_template( 'restaurant-metafield', 'single' );

	} // single_restaurant_meta_field()

	/**
	 * Includes the single restaurant content
	 */
	public function single_restaurant_content() {

		include restaurants_get_template( 'restaurant-content', 'single' );

	} // single_restaurant_content()

	/**
	 * Includes the single restaurant post title
	 */
	public function single_restaurant_posttitle() {

		include restaurants_get_template( 'restaurant-posttitle', 'single' );

	} // single_restaurant_posttitle()

	/**
	 * Includes the single restaurant post title
	 */
	public function single_restaurant_subtitle( $meta ) {

		include restaurants_get_template( 'restaurant-subtitle', 'single' );

	} // single_restaurant_subtitle()

	/**
	 * Include the single restaurant thumbnail
	 */
	public function single_restaurant_thumbnail() {

		include restaurants_get_template( 'restaurant-thumbnail', 'single' );

	} // single_restaurant_thumbnail()

	/**
	 * Returns a reference to this class. Used for removing
	 * actions and/or filters declared here.
	 *
	 * @see  	http://hardcorewp.com/2012/enabling-action-and-filter-hook-removal-from-class-based-wordpress-plugins/
	 * @return 	object 		This class
	 */
	static function this() {

		return self::$_this;

	} // this()

} // class
