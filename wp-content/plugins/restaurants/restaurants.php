<?php

/**
 * The plugin bootstrap file
 *
 * @link 				https://www.slushman.com
 * @since 				1.0.0
 * @package 			Restaurants
 *
 * @wordpress-plugin
 * Plugin Name: 		Restaurants
 * Plugin URI: 			https://www.slushman.com/restaurants
 * Description: 		A simple Restaurants custom post type plugin.
 * Version: 			1.0.0
 * Author: 				Slushman
 * Author URI: 			https://www.slushman.com/
 * License: 			GPL-2.0+
 * License URI: 		http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: 		restaurants
 * Domain Path: 		/assets/languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Define constants
 */
define( 'RESTAURANTS_VERSION', '1.0.0' );
define( 'RESTAURANTS_SLUG', 'restaurants' );
define( 'RESTAURANTS_FILE', plugin_basename( __FILE__ ) );

/**
 * Activation/Deactivation Hooks
 */
register_activation_hook( __FILE__, array( 'Restaurants_Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Restaurants_Deactivator', 'deactivate' ) );

/**
 * Autoloader function
 *
 * Will search both plugin root and includes folder for class
 *
 * @param string $class_name
 */
if ( ! function_exists( 'restaurants_autoloader' ) ) :

	function restaurants_autoloader( $class_name ) {

		$class_name = str_replace( 'Restaurants_', '', $class_name );
		$lower 		= strtolower( $class_name );
		$file      	= 'class-' . str_replace( '_', '-', $lower ) . '.php';
		$base_path 	= plugin_dir_path( __FILE__ );
		$paths[] 	= $base_path . $file;
		$paths[] 	= $base_path . 'classes/' . $file;

		/**
		 * restaurants_autoloader_paths filter
		 */
		$paths = apply_filters( 'function-names-autoloader-paths', $paths );

		foreach ( $paths as $path ) :

			if ( is_readable( $path ) && file_exists( $path ) ) {

				require_once( $path );
				return;

			}

		endforeach;

	} // restaurants_autoloader()

endif;

spl_autoload_register( 'restaurants_autoloader' );

if ( ! function_exists( 'restaurants_init' ) ) :

	/**
	 * Function to initialize plugin
	 */
	function restaurants_init() {

		restaurants()->run();

	}

	add_action( 'plugins_loaded', 'restaurants_init' );

endif;

if ( ! function_exists( 'restaurants' ) ) :

	/**
	 * Function wrapper to get instance of plugin
	 *
	 * @return Plugin_Name
	 */
	function restaurants() {

		return Restaurants::get_instance();

	}

endif;
