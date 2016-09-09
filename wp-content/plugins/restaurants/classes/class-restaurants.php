<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link 		https://www.mysafemenu.com
 * @since 		1.0.0
 *
 * @package 	Restaurants
 * @subpackage 	Restaurants/classes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since 		1.0.0
 * @package 	Restaurants
 * @subpackage 	Restaurants/classes
 * @author 		Slushman <chris@slushman.com>
 * https://www.slushman.com
 */
class Restaurants {

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Plugin_Name 	$_instance 		Instance singleton.
	 */
	protected static $_instance;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Restaurants_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The data sanitizer.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Restaurants_Sanitize    $sanitize    Sanitizes data.
	 */
	protected $sanitize;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_template_hooks();
		$this->define_metabox_hooks();
		$this->define_cpt_and_tax_hooks();
		$this->define_post_hooks();

	} // __construct()

	/**
	 * Creates an instance of the sanitizer and the loader, which will be used to
	 * register the hooks with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * Loads the global functions file.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/global-functions.php';

		$this->loader 		= new Restaurants_Loader();
		$this->sanitize 	= new Restaurants_Sanitize();

	} // load_dependencies()

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Restaurants_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Restaurants_i18n();

		$this->loader->action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	} // set_locale()

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Restaurants_Admin();

		$this->loader->action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->action( 'admin_init', $plugin_admin, 'register_fields' );
		$this->loader->action( 'admin_init', $plugin_admin, 'register_sections' );
		$this->loader->action( 'admin_init', $plugin_admin, 'register_settings' );
		$this->loader->action( 'admin_menu', $plugin_admin, 'add_menu' );
		$this->loader->action( 'plugin_action_links_' . RESTAURANTS_FILE, $plugin_admin, 'link_settings' );
		$this->loader->action( 'plugin_row_meta', $plugin_admin, 'link_row_meta', 10, 2 );

	} // define_admin_hooks()

	/**
	 * Register all of the hooks related to metaboxes
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_cpt_and_tax_hooks() {

		$plugin_cpt_restaurant = new Restaurants_CPT_Restaurant();

		$this->loader->action( 'init', $plugin_cpt_restaurant, 'new_cpt_restaurant' );
		$this->loader->filter( 'manage_restaurant_posts_columns', $plugin_cpt_restaurant, 'restaurant_register_columns' );
		$this->loader->action( 'manage_restaurant_posts_custom_column', $plugin_cpt_restaurant, 'restaurant_column_content', 10, 2 );
		$this->loader->action( 'request', $plugin_cpt_restaurant, 'restaurant_order_sorting', 10, 2 );
		$this->loader->action( 'init', $plugin_cpt_restaurant, 'add_image_sizes' );

		//$plugin_tax_taxonomyname =new Restaurants_Tax_TaxonomyName();

		//$this->loader->action( 'init', $plugin_tax_taxonomyname, 'new_taxonomy_taxonomyname' );

	} // define_cpt_and_tax_hooks()

	/**
	 * Register all of the hooks related to metaboxes
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_metabox_hooks() {

		$metaboxes = array( 'Menufile', 'Menufiles', 'RestaurantInfo' );

		foreach ( $metaboxes as $box ) {

			$class = 'Restaurants_Metabox_' . $box;

			$box = new $class();

			$this->loader->action( 'add_meta_boxes_restaurant', 	$box, 'add_metaboxes', 10, 1 );
			$this->loader->action( 'save_post_restaurant', 			$box, 'validate_meta', 10, 2 );
			$this->loader->action( 'edit_form_after_title', 		$box, 'promote_metaboxes', 10, 1 );
			$this->loader->action( 'add_meta_boxes_restaurant', 	$box, 'set_meta', 10, 1 );

		}

	} // define_metabox_hooks()

	private function define_post_hooks() {

		$plugin_posts = new Restaurants_Posts();

		$this->loader->action( 'save_post_restaurant', $plugin_posts,  'insert_post_for_new_restaurant', 10, 2 );
		//$this->loader->action( 'save_post_restaurant', $plugin_posts,  'loop_through_restaurants', 10, 2 );

	} // define_post_hooks()

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Restaurants_Public();

		$this->loader->action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->filter( 'single_template', $plugin_public, 'single_cpt_template', 11 );
		$this->loader->shortcode( 'listrestaurants', $plugin_public, 'shortcode_listrestaurants' );
		$this->loader->filter( 'posts_fields', $plugin_public, 'create_temp_column', 10, 2 );
		$this->loader->filter( 'posts_orderby', $plugin_public, 'sort_by_temp_column', 10, 2 );

		/**
		 * Action instead of template tag.
		 *
		 * do_action( 'actionname' );
		 * 		or
		 * echo apply_filters( 'actionname' );
		 *
		 * @link 	http://nacin.com/2010/05/18/rethinking-template-tags-in-plugins/
		 */
		$this->loader->action( 'actionname', $plugin_public, 'shortcode_listrestaurants' );

	} // define_public_hooks()

	/**
	 * Register all of the hooks related to the templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_template_hooks() {

		$plugin_templates = new Restaurants_Templates();

		// Loop
		$this->loader->action( 'restaurants-before-loop', 			$plugin_templates, 'loop_wrap_begin', 10, 1 );
		$this->loader->action( 'restaurants-before-loop', 			$plugin_templates, 'loop_search_or_sort', 15, 1 );

		//$this->loader->action( 'restaurants-before-loop-content', 	$plugin_templates, 'loop_content_sorting_begin', 9, 4 );
		$this->loader->action( 'restaurants-before-loop-content', 	$plugin_templates, 'loop_content_wrap_begin', 10, 2 );
		$this->loader->action( 'restaurants-before-loop-content', 	$plugin_templates, 'loop_content_link_begin', 15, 2 );

		$this->loader->action( 'restaurants-loop-content', 			$plugin_templates, 'loop_content_title', 15, 2 );

		$this->loader->action( 'restaurants-after-loop-content', 	$plugin_templates, 'loop_content_link_end', 10, 2 );
		$this->loader->action( 'restaurants-after-loop-content', 	$plugin_templates, 'loop_content_wrap_end', 90, 2 );

		$this->loader->action( 'restaurants-after-loop', 			$plugin_templates, 'loop_wrap_end', 10, 1 );
		$this->loader->action( 'restaurants-after-loop', 			$plugin_templates, 'loop_content_sorting_end', 11, 2 );

		// Single
		$this->loader->action( 'restaurants-single-content', 		$plugin_templates, 'single_restaurant_thumbnail', 10 );
		$this->loader->action( 'restaurants-single-content', 		$plugin_templates, 'single_restaurant_posttitle', 15 );
		$this->loader->action( 'restaurants-single-content', 		$plugin_templates, 'single_restaurant_subtitle', 20, 1 );
		$this->loader->action( 'restaurants-single-content', 		$plugin_templates, 'single_restaurant_content', 25 );
		$this->loader->action( 'restaurants-single-content', 		$plugin_templates, 'single_restaurant_meta_field', 30, 1 );

	} // define_template_hooks()

	/**
	 * Get instance of main class
	 *
	 * @since 		1.0.0
	 * @return 		Plugin_Name
	 */
	public static function get_instance() {

		if ( empty( self::$_instance ) ) {

			self::$_instance = new self;

		}

		return self::$_instance;

	} // get_instance()

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		$this->loader->run();

	} // run()

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 *
	 * @return    Restaurants_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {

		return $this->loader;

	} // get_loader()

} // class
