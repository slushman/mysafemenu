<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines a taxonomy and other related functionality.
 *
 * @link 		https://www.slushman.com
 * @since 		1.0.0
 *
 * @package 	Restaurants
 * @subpackage 	Restaurants/classes
 * @author		Slushman <chris@slushman.com>
 */
class Restaurants_Tax_TaxonomyName {

	/**
	 * The term meta data
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$meta    			The term meta data.
	 */
	private $meta;

	/**
	 * Constructor
	 */
	public function __construct() {} // __construct()

	/**
	 * Creates a new taxonomy for a custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_taxonomy()
	 */
	public static function new_taxonomy_taxonomyname() {

		$opts['description'] 							= '';
		$opts['hierarchical']							= TRUE;
		//$opts['meta_box_cb'] 							= '';
		$opts['public']									= TRUE;
		$opts['publicly_queryable']						= TRUE;
		$opts['query_var']								= 'taxonomyname';
		$opts['show_admin_column'] 						= FALSE;
		$opts['show_in_menu']							= TRUE;
		$opts['show_in_nav_menus']						= TRUE;
		$opts['show_in_quick_edit']						= TRUE;
		$opts['show_tag_cloud'] 						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['sort'] 									= '';
		//$opts['update_count_callback'] 					= '';

		$opts['capabilities']['assign_terms'] 			= 'edit_posts';
		$opts['capabilities']['delete_terms'] 			= 'manage_categories';
		$opts['capabilities']['edit_terms'] 			= 'manage_categories';
		$opts['capabilities']['manage_terms'] 			= 'manage_categories';

		$opts['labels']['add_new_item'] 				= esc_html__( 'Add New TaxonomySingle', 'restaurants' );
		$opts['labels']['add_or_remove_items'] 			= esc_html__( 'Add or remove TaxonomyPlural', 'restaurants' );
		$opts['labels']['all_items'] 					= esc_html__( 'TaxonomyPlural', 'restaurants' );
		$opts['labels']['choose_from_most_used'] 		= esc_html__( 'Choose from most used TaxonomyPlural', 'restaurants' );
		$opts['labels']['edit_item'] 					= esc_html__( 'Edit TaxonomySingle', 'restaurants');
		$opts['labels']['items_list'] 					= esc_html__( 'TaxonomyPlural', 'restaurants');
		$opts['labels']['items_list_navigation'] 		= esc_html__( 'TaxonomyPlural', 'restaurants');
		$opts['labels']['menu_name'] 					= esc_html__( 'TaxonomyPlural', 'restaurants' );
		$opts['labels']['name'] 						= esc_html__( 'TaxonomyPlural', 'restaurants' );
		$opts['labels']['new_item_name'] 				= esc_html__( 'New TaxonomySingle Name', 'restaurants' );
		$opts['labels']['no_terms'] 					= esc_html__( 'No TaxonomyPlural', 'restaurants' );
		$opts['labels']['not_found'] 					= esc_html__( 'No TaxonomyPlural Found', 'restaurants' );
		$opts['labels']['parent_item'] 					= esc_html__( 'Parent TaxonomySingle', 'restaurants' );
		$opts['labels']['parent_item_colon'] 			= esc_html__( 'Parent TaxonomySingle:', 'restaurants' );
		$opts['labels']['popular_items'] 				= esc_html__( 'Popular TaxonomyPlural', 'restaurants' );
		$opts['labels']['search_items'] 				= esc_html__( 'Search TaxonomyPlural', 'restaurants' );
		$opts['labels']['separate_items_with_commas'] 	= esc_html__( 'Separate TaxonomyPlural with commas', 'restaurants' );
		$opts['labels']['singular_name'] 				= esc_html__( 'TaxonomySingle', 'restaurants' );
		$opts['labels']['update_item'] 					= esc_html__( 'Update TaxonomySingle', 'restaurants' );
		$opts['labels']['view_item'] 					= esc_html__( 'View TaxonomySingle', 'restaurants' );

		$opts['rewrite']['ep_mask']						= EP_NONE;
		$opts['rewrite']['hierarchical']				= FALSE;
		$opts['rewrite']['slug']						= esc_html__( 'taxonomyname', 'restaurants' );
		$opts['rewrite']['with_front']					= FALSE;

		$opts = apply_filters( 'restaurants-taxonomy-taxonomyname-options', $opts );

		register_taxonomy( 'taxonomyname', 'restaurant', $opts );

	} // new_taxonomy_taxonomyname()

} // class
