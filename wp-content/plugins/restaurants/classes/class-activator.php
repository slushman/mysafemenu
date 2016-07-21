<?php

/**
 * Fired during plugin activation
 *
 * @link 		https://www.slushman.com
 * @since 		1.0.0
 *
 * @package 	Restaurants
 * @subpackage 	Restaurants/classes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since 		1.0.0
 * @package 	Restaurants
 * @subpackage 	Restaurants/classes
 * @author 		Slushman <chris@slushman.com>
 */
class Restaurants_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-cpt-restaurant.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'classes/class-tax-taxonomyname.php';

		Restaurants_CPT_Restaurant::new_cpt_restaurant();
		Restaurants_Tax_TaxonomyName::new_taxonomy_taxonomyname();

		flush_rewrite_rules();

		$opts 		= array();
		$options 	= Restaurants_Admin::get_options_list();

		foreach ( $options as $option ) {

			$opts[ $option[0] ] = $option[2];

		}

		update_option( 'restaurants-options', $opts );

	} // activate()

} // class
