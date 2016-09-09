<?php
/**
 * The metabox-specific functionality of the theme.
 *
 * @link 		https://www.mysafemenu.com
 * @since 		1.0.0
 * @package 	Restaurants
 * @subpackage 	Restaurants/classes
 * @author 		Slushman <chris@slushman.com>
 */
class Restaurants_Metabox {

	/**
	 * The capabilities required for saving these metaboxes.
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		string 			$caps 			The capability.
	 */
	protected $caps = 'edit_post';

	/**
	 * The post type for this set of metaboxes.
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		string 			$post_type 			This post type.
	 */
	protected $post_type = '';

	/**
	 * Array of fields used in these metaboxes.
	 *
	 * @since 		1.0.0
	 *
	 * @var [type]
	 */
	protected $fields = array();

	/**
	 * The post meta data
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		string 			$meta    			The post meta data.
	 */
	protected $meta = array();

	/**
	 * The ID of this theme.
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		string 			$theme_name 		The ID of this theme.
	 */
	protected $theme_name = '';

	/**
	 * The version of this theme.
	 *
	 * @since 		1.0.0
	 * @access 		protected
	 * @var 		string 			$version 			The current version of this theme.
	 */
	protected $version = '';

	/**
	 * Constructor. Defined in child class.
	 *
	 * Should set things like:
	 * 		$this->post_type: limits metabox(es) to particular post type screens
	 * 		$this->fields: for saving metabox data. An array of the field IDs.
	 * 		$this->nonces: for saving metabox data. An array of the nonce IDs.
	 */
	public function __construct() {

		// Define in child class

	} // __construct()

	/**
	 * Registers metaboxes with WordPress
	 *
	 * Use the standard add_meta_box function to define a box.
	 * 		In the callback_args, use "file" to define the file in
	 * 			template-parts/metaboxes containing the metabox view.
	 *
	 * @hooked 		add_meta_boxes
	 * @since 		1.0.0
	 * @access 		public
	 * @param 		object 			$post 			The post object.
	 */
	public function add_metaboxes( $post ) {

		// Define in child class.

	} // add_metaboxes()

	/**
	 * Check each nonce. If any don't verify, $nonce_check is increased.
	 * If all nonces verify, returns 0.
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @return 		int 		The value of $nonce_check
	 */
	private function check_nonces( $posted ) {

		foreach ( $this->nonces as $nonce ) {

			if ( ! isset( $posted[$nonce] ) ) { return FALSE; }
			if ( isset( $posted[$nonce] ) && ! wp_verify_nonce( $posted[$nonce], $this->theme_name ) ) { return FALSE; }

		}

		return TRUE;

	} // check_nonces()

	/**
	 * Returns TRUE if the post type is correct.
	 *
	 * @exits 		If not the correct post type.
	 * @exits 		If $check is empty / no post type to check was passed.
	 * @param 		string 		$check 		The post type to check for.
	 * @return 		bool 					TRUE if the post type is correct, otherwise FALSE.
	 */
	private function check_post_type( $check ) {

		if ( empty( $this->post_type ) ) { return FALSE; }
		if ( empty( $check) ) { return FALSE; }

		if ( is_array( $this->post_type ) ) {

			return in_array( $this->post_type, $check );

		}

		return $this->post_type == $check;

	} // check_post_type()

	/**
	 * Calls a metabox file specified in the add_meta_box args.
	 *
	 * @exits 		Not in the admin.
	 * @exits 		Not on the correct post type.
	 * @since 		1.0.0
	 * @access 		public
	 */
	public function metabox( $post, $params ) {

		if ( ! is_admin() ) { return; }
		if ( ! $this->check_post_type( $post->post_type ) ) { return FALSE; }

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/metaboxes/' . $params['args']['file'] . '.php' );

	} // metabox()

	/**
	 * Checks conditions before validating metabox submissions.
	 *
	 * Returns FALSE under these conditions:
	 * 		Doing autosave.
	 * 		User doesn't have the capabilities.
	 * 		Not on the correct post type.
	 * 		Nonces don't validate.
	 *
	 * @param 		object 		$posted 		The submitted data.
	 * @param 		int 		$post_id 		The post ID.
	 * @param 		object 		$post 			The post object.
	 * @return 		int 						0 if any conditions are met, otherwise 1.
	 */
	private function pre_validation_checks( $posted, $post_id, $post ) {

		if ( FALSE !== wp_is_post_autosave( $post_id ) ) { return FALSE; }
		if ( FALSE !== wp_is_post_revision( $post_id ) ) { return FALSE; }
		if ( ! current_user_can( $this->caps, $post_id ) ) { return FALSE; }
		if ( ! $this->check_post_type( $post->post_type ) ) { return FALSE; }

		$nonce_check = $this->check_nonces( $posted );

		if ( 0 < $nonce_check ) { return FALSE; }

		return TRUE;

	} // pre_validation_checks()

	/**
	 * Adds all metaboxes in the "top" priority to just under the title field.
	 *
	 * @exits 		If not on the correct post type.
	 * @hooked 		edit_form_after_title
	 * @param `		object 		$post_obj 		The post object.`
	 */
	public function promote_metaboxes( $post_obj ) {

		if ( ! $this->check_post_type( $post_obj->post_type ) ) { return FALSE; }

		global $wp_meta_boxes;

		do_meta_boxes( get_current_screen(), 'top', $post_obj );

		unset( $wp_meta_boxes[$this->post_type]['top'] );

	} // promote_metaboxes()

	/**
	 * Sets the class variable $options
	 *
	 * @exits 		Post is empty.
	 * @exits 		Not on the correct post type.
	 * @hooked 		add_meta_boxes
	 * @param 		object 			$post 			The post object.
	 */
	public function set_meta( $post ) {

		if ( empty( $post ) ) { return; }
		if ( ! $this->check_post_type( $post->post_type ) ) { return FALSE; }

		$this->meta = get_post_custom( $post->ID );

	} // set_meta()

	/**
	 * Saves metabox data
	 *
	 * @hooked 		save_post 		10
	 * @since 		1.0.0
	 * @access 		public
	 * @param 		int 			$post_id 		The post ID
	 * @param 		object 			$post 			The post object
	 */
	public function validate_meta( $post_id, $post ) {

		$validate = $this->pre_validation_checks( $_POST, $post_id, $post );

		if ( ! $validate ) { return $post_id; }

		foreach ( $this->fields as $meta ) {

			$value 		= ( empty( $this->meta[$meta[0]][0] ) ? '' : $this->meta[$meta[0]][0] );
			$sanitizer 	= new Restaurants_Sanitize();
			$new_value 	= $sanitizer->clean( $_POST[$meta[0]], $meta[1] );

			update_post_meta( $post_id, $meta[0], $new_value );

			unset( $value );
			unset( $sanitizer );
			unset( $new_value );

		} // foreach

	} // validate_meta()

} // class
