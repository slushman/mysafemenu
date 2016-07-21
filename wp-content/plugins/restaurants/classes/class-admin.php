<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link 		https://www.mysafemenu.com
 * @since 		1.0.0
 *
 * @package 	Restaurants
 * @subpackage 	Restaurants/classes
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package 	Restaurants
 * @subpackage 	Restaurants/classes
 * @author 		Slushman <chris@slushman.com>
 */
class Restaurants_Admin {

	/**
	 * The settings fields.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		array 			$fields 		The settings fields
	 */
	private $fields;

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
	 * @since 		1.0.0
	 */
	public function __construct() {

		$this->set_options();

	} // __construct()

	/**
	 * Adds a settings page link to a menu
	 *
	 * @link 		https://codex.wordpress.org/classesistration_Menus
	 * @since 		1.0.0
	 */
	public function add_menu() {

		// Top-level page
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

		// Submenu Page
		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);

		add_submenu_page(
			'edit.php?post_type=restaurant',
			esc_html__( 'Plugin Name Settings', 'restaurants' ),
			esc_html__( 'Settings', 'restaurants' ),
			'manage_options',
			RESTAURANTS_SLUG . '-settings',
			array( $this, 'page_options' )
		);

		add_submenu_page(
			'edit.php?post_type=restaurant',
			esc_html__( 'Plugin Name Help', 'restaurants' ),
			esc_html__( 'Help', 'restaurants' ),
			'manage_options',
			RESTAURANTS_SLUG . '-help',
			array( $this, 'page_help' )
		);

	} // add_menu()

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( RESTAURANTS_SLUG, plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/restaurants-admin.css', array(), RESTAURANTS_VERSION, 'all' );

	} // enqueue_styles()

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook_suffix ) {

		global $post;
		$screen = get_current_screen();

		wp_enqueue_media();

		wp_enqueue_script( RESTAURANTS_SLUG, plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/restaurants-admin.min.js', array( 'jquery' ), RESTAURANTS_VERSION, true );

	} // enqueue_scripts()

	/**
	 * Creates a checkbox field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 *
	 * @return 	string 						The HTML field
	 */
	public function field_checkbox( $args ) {

		$defaults['class'] 			= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= RESTAURANTS_SLUG . '-options[' . $args['id'] . ']';
		$defaults['value'] 			= 0;

		/**
		 * restaurants-field-checkbox-options-defaults filter
		 *
		 * @param 	array 	$defaults 		The default settings for the field
		 */
		$defaults 	= apply_filters( RESTAURANTS_SLUG . '-field-checkbox-options-defaults', $defaults );
		$atts 		= wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/fields/checkbox.php' );

	} // field_checkbox()

	/**
	 * Creates a text field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 *
	 * @return 	string 						The HTML field
	 */
	public function field_editor( $args ) {

		$defaults['description'] 	= '';
		$defaults['settings'] 		= array();
		$defaults['value']			= '';

		/**
		 * restaurants-field-text-options-defaults filter
		 *
		 * @param 	array 	$defaults 		The default settings for the field
		 */
		$defaults 	= apply_filters( RESTAURANTS_SLUG . '-field-editor-options-defaults', $defaults );
		$atts 		= wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/fields/editor.php' );

	} // field_editor()

	/**
	 * Creates a file uploader field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 *
	 * @return 	string 						The HTML field
	 */
	public function field_file_uploader( $args ) {

		$defaults['class'] 			= 'text widefat';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['label-remove'] 	= esc_html__( 'Remove File', 'restaurants' );
		$defaults['label-upload'] 	= esc_html__( 'Upload/Choose File', 'restaurants' );
		$defaults['name'] 			= RESTAURANTS_SLUG . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 	= '';
		$defaults['type'] 			= 'text';
		$defaults['value'] 			= '';

		/**
		 * restaurants-field-text-options-defaults filter
		 *
		 * @param 	array 	$defaults 		The default settings for the field
		 */
		$defaults 	= apply_filters( RESTAURANTS_SLUG . '-field-file-upload-options-defaults', $defaults );
		$atts 		= wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/fields/file-upload.php' );

	} // field_file_uploader()

	/**
	 * Creates a set of radios field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 *
	 * @return 	string 						The HTML field
	 */
	public function field_radios( $args ) {

		$defaults['class'] 			= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= RESTAURANTS_SLUG . '-options[' . $args['id'] . ']';
		$defaults['value'] 			= 0;

		/**
		 * restaurants-field-radios-options-defaults filter
		 *
		 * @param 	array 	$defaults 		The default settings for the field
		 */
		$defaults 	= apply_filters( RESTAURANTS_SLUG . '-field-radios-options-defaults', $defaults );
		$atts 		= wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/fields/radios.php' );

	} // field_radios()

	/**
	 * Creates a select field
	 *
	 * Note: label is blank since its created in the Settings API
	 *
	 * @param 	array 		$args 			The arguments for the field
	 *
	 * @return 	string 						The HTML field
	 */
	public function field_select( $args ) {

		$defaults['aria'] 			= '';
		$defaults['blank'] 			= '';
		$defaults['class'] 			= '';
		$defaults['context'] 		= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= RESTAURANTS_SLUG . '-options[' . $args['id'] . ']';
		$defaults['selections'] 	= array();
		$defaults['value'] 			= '';

		/**
		 * restaurants-field-select-options-defaults filter
		 *
		 * @param 	array 	$defaults 		The default settings for the field
		 */
		$defaults 	= apply_filters( RESTAURANTS_SLUG . '-field-select-options-defaults', $defaults );
		$atts 		= wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		if ( empty( $atts['aria'] ) && ! empty( $atts['description'] ) ) {

			$atts['aria'] = $atts['description'];

		} elseif ( empty( $atts['aria'] ) && ! empty( $atts['label'] ) ) {

			$atts['aria'] = $atts['label'];

		}

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/fields/select.php' );

	} // field_select()

	/**
	 * Creates a text field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 *
	 * @return 	string 						The HTML field
	 */
	public function field_text( $args ) {

		$defaults['class'] 			= 'text widefat';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= RESTAURANTS_SLUG . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 	= '';
		$defaults['type'] 			= 'text';
		$defaults['value'] 			= '';

		/**
		 * restaurants-field-text-options-defaults filter
		 *
		 * @param 	array 	$defaults 		The default settings for the field
		 */
		$defaults 	= apply_filters( RESTAURANTS_SLUG . '-field-text-options-defaults', $defaults );
		$atts 		= wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/fields/text.php' );

	} // field_text()

	/**
	 * Creates a textarea field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 *
	 * @return 	string 						The HTML field
	 */
	public function field_textarea( $args ) {

		$defaults['class'] 			= 'large-text';
		$defaults['cols'] 			= 50;
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= RESTAURANTS_SLUG . '-options[' . $args['id'] . ']';
		$defaults['rows'] 			= 10;
		$defaults['value'] 			= '';

		/**
		 * restaurants-field-textarea-options-defaults filter
		 *
		 * @param 	array 	$defaults 		The default settings for the field
		 */
		$defaults 	= apply_filters( RESTAURANTS_SLUG . '-field-textarea-options-defaults', $defaults );
		$atts 		= wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/fields/textarea.php' );

	} // field_textarea()

	/**
	 * Returns an array of options names, fields types, and default values
	 *
	 * @return 		array 			An array of options
	 */
	public static function get_options_list() {

		$options = array();

		$options[] = array( 'checkbox-field', 'checkbox', '' );
		$options[] = array( 'editor-field', 'editor', '' );
		$options[] = array( 'file-upload-field', 'file', '' );
		$options[] = array( 'radios-field', 'radio', '' );
		$options[] = array( 'select-field', 'select', '' );
		$options[] = array( 'text-field', 'text', '' );
		$options[] = array( 'textarea-field', 'textarea', '' );

		return $options;

	} // get_options_list()

	/**
	 * Adds a link to the plugin settings page
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$links 		The current array of links
	 *
	 * @return 		array 					The modified array of links
	 */
	public function link_settings( $links ) {

		$links[] = sprintf( '<a href="%s">%s</a>', admin_url( 'edit.php?post_type=restaurant&page=restaurants-settings' ), esc_html__( 'Settings', 'restaurants' ) );

		return $links;

	} // link_settings()

	/**
	 * Adds links to the plugin links row
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$links 		The current array of row links
	 * @param 		string 		$file 		The name of the file
	 *
	 * @return 		array 					The modified array of row links
	 */
	public function link_row_meta( $links, $file ) {

		if ( $file == RESTAURANTS_FILE ) {

			$links[] = '<a href="http://twitter.com/slushman">Twitter</a>';

		}

		return $links;

	} // link_row_meta()

	/**
	 * Includes the help page view
	 *
	 * @since 		1.0.0
	 *
	 * @return 		void
	 */
	public function page_help() {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/pages/help.php' );

	} // page_help()

	/**
	 * Includes the options page view
	 *
	 * @since 		1.0.0
	 *
	 * @return 		void
	 */
	public function page_options() {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/pages/settings.php' );

	} // page_options()

	/**
	 * Registers settings fields with WordPress
	 */
	public function register_fields() {

		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );

		add_settings_field(
			'text-field',
			apply_filters( RESTAURANTS_SLUG . '-label-text-field', esc_html__( 'Text Field', 'restaurants' ) ),
			array( $this, 'field_text' ),
			RESTAURANTS_SLUG,
			RESTAURANTS_SLUG . '-settingssection',
			array(
				'description' 	=> esc_html__( 'Text field description.', 'restaurants' ),
				'id' 			=> 'text-field',
				'value' 		=> '',
			)
		);

		add_settings_field(
			'select-field',
			apply_filters( RESTAURANTS_SLUG . '-label-select-field', esc_html__( 'Select Field', 'restaurants' ) ),
			array( $this, 'field_select' ),
			RESTAURANTS_SLUG,
			RESTAURANTS_SLUG . '-settingssection',
			array(
				'description' 	=> esc_html__( 'Select description.', 'restaurants' ),
				'id' 			=> 'select-field',
				'selections'	=> array(
					array( 'label' => esc_html__( 'Label', 'restaurants' ), 'value' => 'value' ),
				),
				'value' 		=> ''
			)
		);

		add_settings_field(
			'editor-field',
			apply_filters( RESTAURANTS_SLUG . 'label-editor-field', esc_html__( 'Editor Field', 'restaurants' ) ),
			array( $this, 'field_editor' ),
			RESTAURANTS_SLUG,
			RESTAURANTS_SLUG . '-settingssection',
			array(
				'description' 	=> esc_html__( 'Editor field description.', 'restaurants' ),
				'id' 			=> 'howtoapply'
			)
		);

		add_settings_field(
			'checkbox-field',
			apply_filters( RESTAURANTS_SLUG . '-label-checkbox-field', esc_html__( 'Checkbox Field', 'restaurants' ) ),
			array( $this, 'field_checkbox' ),
			RESTAURANTS_SLUG,
			RESTAURANTS_SLUG . '-settingssection',
			array(
				'description' 	=> esc_html__( 'Checkbox description.', 'restaurants' ),
				'id' 			=> 'checkbox-field',
				'value' 		=> '',
			)
		);

		add_settings_field(
			'radios-field',
			apply_filters( RESTAURANTS_SLUG . '-label-radios-field', esc_html__( 'Radios Field', 'restaurants' ) ),
			array( $this, 'field_radios' ),
			RESTAURANTS_SLUG,
			RESTAURANTS_SLUG . '-settingssection',
			array(
				'description' 	=> esc_html__( 'Radio fields description.', 'restaurants' ),
				'id' 			=> 'radios-field',
				'selections' 	=> array(
					array( 'label' => esc_html__( 'Label 1', 'restaurants' ), 'value' => 'value1' ),
					array( 'label' => esc_html__( 'Label 2', 'restaurants' ), 'value' => 'value2' ),
					array( 'label' => esc_html__( 'Label 3', 'restaurants' ), 'value' => 'value3' ),
				),
				'value' 		=> '',
			)
		);

		add_settings_field(
			'textarea-field',
			apply_filters( RESTAURANTS_SLUG . '-label-textarea-field', esc_html__( 'Textarea Field', 'restaurants' ) ),
			array( $this, 'field_textarea' ),
			RESTAURANTS_SLUG,
			RESTAURANTS_SLUG . '-settingssection',
			array(
				'description' 	=> esc_html__( 'Textarea description.', 'restaurants' ),
				'id' 			=> 'textarea-field',
				'value' 		=> '',
			)
		);

		add_settings_field(
			'file-upload-field',
			apply_filters( RESTAURANTS_SLUG . '-label-file-upload-field', esc_html__( 'File Upload Field', 'restaurants' ) ),
			array( $this, 'field_file_uploader' ),
			RESTAURANTS_SLUG,
			RESTAURANTS_SLUG . '-settingssection',
			array(
				'description' 	=> esc_html__( 'File uploader description.', 'restaurants' ),
				'id' 			=> 'file-upload-field',
				'value' 		=> '',
			)
		);

	} // register_fields()

	/**
	 * Registers settings sections with WordPress
	 */
	public function register_sections() {

		// add_settings_section( $id, $title, $callback, $menu_slug );

		add_settings_section(
			RESTAURANTS_SLUG . '-settingssection',
			apply_filters( RESTAURANTS_SLUG . '-section-settingssection-title', esc_html__( 'Settings Section', 'restaurants' ) ),
			array( $this, 'section_settingssection' ),
			RESTAURANTS_SLUG
		);

	} // register_sections()

	/**
	 * Registers plugin settings
	 *
	 * @since 		1.0.0
	 */
	public function register_settings() {

		// register_setting( $option_group, $option_name, $sanitize_callback );

		register_setting(
			RESTAURANTS_SLUG . '-options',
			RESTAURANTS_SLUG . '-options',
			array( $this, 'validate_options' )
		);

	} // register_settings()

	/**
	 * Displays a settings section
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$params 		Array of parameters for the section
	 *
	 * @return 		mixed 						The settings section
	 */
	public function section_settingssection( $params ) {

		include( plugin_dir_path( dirname( __FILE__ ) ) . 'views/sections/settingssection.php' );

	} // section_settingssection()

	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( RESTAURANTS_SLUG . '-options' );

	} // set_options()

	/**
	 * Validates saved options
	 *
	 * @since 		1.0.0
	 *
	 * @param 		array 		$input 			array of submitted plugin options
	 *
	 * @return 		array 						array of validated plugin options
	 */
	public function validate_options( $input ) {

		$valid 		= array();
		$options 	= $this->get_options_list();

		foreach ( $options as $option ) {

			$sanitizer 			= new Restaurants_Sanitize();
			$valid[$option[0]] 	= $sanitizer->clean( $input[$option[0]], $option[1] );

			if ( $valid[$option[0]] != $input[$option[0]] ) {

				add_settings_error( $option[0], $option[0] . '_error', esc_html__( $option[0] . ' error.', 'restaurants' ), 'error' );

			}

			unset( $sanitizer );

		}

		return $valid;

	} // validate_options()

} // class
