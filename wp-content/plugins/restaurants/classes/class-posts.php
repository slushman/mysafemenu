<?php

/**
 * Creates a draft post when a new restaurant is saved.
 *
 * @link 		https://www.mysafemenu.com
 * @since 		1.0.0
 * @package 	Restaurants
 * @subpackage 	Restaurants/classes
 * @author 		Slushman <chris@slushman.com>
 */
class Restaurants_Posts {

	public function __construct(){}

	/**
	 * Inserts a new pot when a restaurant is published or scheduled.
	 *
	 * @exits 		If $restID is empty or not an int.
	 * @exits 		If $rest is empty or not an object.
	 * @hooked 		save_post_restaurant
	 * @param 		int 		$restID 	The restaurant ID
	 * @param 		object 		$rest 		The restaurant object
	 * @return 		int 					The new post ID.
	 */
	public function insert_post_for_new_restaurant( $restID, $rest ) {

		if ( empty( $restID ) || ! is_int( $restID ) ) { return FALSE; }
		if ( empty( $rest ) || ! is_object( $rest ) ) { return FALSE; }
		if ( wp_is_post_autosave( $restID ) ) { return FALSE; }
		if ( wp_is_post_revision( $restID ) ) { return FALSE; }
		if ( $this->does_post_already_exist( $rest ) ) { return FALSE; }

		$status = get_post_status( $restID );

		if ( 'publish' !== $status && 'future' !== $status ) { return FALSE; }

		$content = '';

		$post_args['post_date'] 	= $rest->post_date;
		$post_args['post_content'] 	= 'The allergen menu for ' . $rest->post_title . ' has been added to the menu list.';

		if ( ! empty( $rest->post_content ) ) {

			$post_args['post_content'] .= '<p>' . $rest->post_content . '</p>';

		}

		$post_args['post_status'] 	= 'publish';
		$post_args['post_title'] 	= $rest->post_title . ' added to the menus!';
		$postID 					= wp_insert_post( $post_args );

		return $postID;

	} // insert_post_for_new_restaurant()

	/**
	 * Returns all posts of post type "post".
	 * @return 		array 		Array of post objects.
	 */
	private function get_posts() {

		$shared 				= new Restaurants_Shared();
		$args['posts_per_page'] = -1;
		$posts 					= $shared->query( $args, 0, 'post' );

		return $posts;

	} // get_posts()

	private function does_post_already_exist( $rest ) {

		if ( empty( $rest ) ) { return; }

		$posts = get_posts( array( 'numberposts' => -1 ) );

		if ( $posts ) { return FALSE; }

		foreach ( $posts as $post ) {

			$check = strpos( $post->post_title, $rest->post_title );

			if ( FALSE !== $check ) {

				return TRUE; // post exists

			}

		}

		return FALSE; // post does not exist

	} // does_post_already_exist()

	public function get_restaurants() {

		$shared 				= new Restaurants_Shared();
		$args['posts_per_page'] = -1;
		$rests 					= $shared->query( $args );

		return $rests;

	} // get_restaurants()

	public function loop_through_restaurants() {

		$rests = $this->get_restaurants();

		foreach ( $rests as $rest ) {

			$check = $this->does_post_already_exist( $rest );

			if ( $check ) { continue; }

			$id = $this->insert_post_for_new_restaurant( $rest->ID, $rest );

		}

	} // loop_through_restaurants()

} // class
