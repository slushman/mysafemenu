<?php
/**
 * Globally-accessible functions
 *
 * @link 		https://www.slushman.com
 * @since 		1.0.0
 *
 * @package		Restaurants
 * @subpackage 	Restaurants/classes
 * @author 		Slushman <chris@slushman.com>
 */

/**
 * Returns the requested SVG
 *
 * @param 	string 		$svg 		The name of the icon to return
 * @param 	string 		$link 		URL to link from the SVG
 *
 * @return 	mixed 					The SVG code
 */
function restaurants_get_svg( $svg ) {

	if ( empty( $svg ) ) { return; }

	$list = Restaurants_Public::get_svg_list();

	return $list[$svg];

} // restaurants_get_svg()

/**
 * Returns the path to a template file
 *
 * Looks for the file in these directories, in this order:
 * 		Current theme
 * 		Parent theme
 * 		Current theme plugin-name folder
 * 		Parent theme plugin-name folder
 * 		Current theme templates folder
 * 		Parent theme templates folder
 * 		Current theme views folder
 * 		Parent theme views folder
 * 		This plugin
 *
 * To use a custom list template in a theme, copy the
 * file from classes/views into a folder in your theme. The
 * folder can be named "plugin-name", "templates", or "views".
 * Customize the files as needed, but keep the file name as-is. The
 * plugin will automatically use your custom template file instead
 * of the ones included in the plugin.
 *
 * @param 	string 		$name 			The name of a template file
 * @param 	string 		$location 		The subfolder containing the view
 *
 * @return 	string 						The path to the template
 */
function restaurants_get_template( $name, $location = '' ) {

	$template = '';

	$locations[] = "{$name}.php";
	$locations[] = "/plugin-name/{$name}.php";
	$locations[] = "/templates/{$name}.php";
	$locations[] = "/views/{$name}.php";

	/**
	 * Filter the locations to search for a template file
	 *
	 * @param 	array 		$locations 			File names and/or paths to check
	 */
	$locations 	= apply_filters( 'restaurants_template_paths', $locations );
	$template 	= locate_template( $locations, TRUE );

	if ( empty( $template ) ) {

		if ( empty( $location ) ) {

			$template = plugin_dir_path( dirname( __FILE__ ) ) . 'views/' . $name . '.php';

		} else {

			$template = plugin_dir_path( dirname( __FILE__ ) ) . 'views/' . $location . '/' . $name . '.php';

		}

	}

	return $template;

} // restaurants_get_template()
