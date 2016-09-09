<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://slushman.com
 * @since      1.0.0
 *
 * @package    Restaurants
 * @subpackage Restaurants/classes/loop-views
 */

/**
 * restaurants-before-loop hook
 *
 * @hooked 		loop_wrap_begin 		10
 * @hooked 		search_or_sort 			15
 */
do_action( 'restaurants-before-loop', $args );

while ( $items->have_posts() ) : $items->the_post();

	$meta 		= get_post_custom( get_the_ID() );
	$title 		= get_the_title();
	$thecheck 	= substr( $title, 0, 3 );
	$link 		= $meta['menu-file'][0];

	if ( is_numeric( $letter ) ) {

		$capped = 'Nums';

	} else {

		$capped = strtoupper( $letter );

	}

	if ( empty( $char ) ) :

		$char = $capped;

		?><ul class="letter-list" id="<?php echo esc_attr( $char ); ?>"><?php

	elseif ( $capped != $char ) :

		$char = $capped;

		?><a class="link-top" href="#"><?php esc_html_e( 'Back to top', 'restaurants' ); ?></a>
		</ul><ul class="letter-list" id="<?php echo esc_attr( $char ); ?>"><?php

	endif;

	/**
	 * restaurants-before-loop-content action hook
	 *
	 * @hooked 		loop_content_link_begin 		15
	 */
	do_action( 'restaurants-before-loop-content', $item, $meta );

	/**
	 * restaurants-loop-content action hook
	 *
	 * @hooked 		loop_content_title 		15
	 */
	do_action( 'restaurants-loop-content', $item, $meta );

	/**
	 * restaurants-after-loop-content action hook
	 *
	 * @hooked 		loop_content_link_end 		10
	 */
	do_action( 'restaurants-after-loop-content', $item, $meta );

	?></ul><?php

	unset( $capped );
	unset( $letter );
	unset( $meta );
	unset( $title );

endwhile;

// 	/**
// 	 * restaurants-before-loop-content hook
// 	 *
// 	 * @param 		object  	$item 		The post object
// 	 *
// 	 * @hooked 		loop_content_wrap_begin 		10
// 	 * @hooked 		loop_content_link_begin 		15
// 	 */
// 	do_action( 'restaurants-before-loop-content', $item, $meta );
//
// 		/**
// 		 * lazy-load-videos-loop-content hook
// 		 *
// 		 * @param 		object  	$item 		The post object
// 		 *
// 		 * @hooked		loop_content_image 			10
// 		 * @hooked		loop_content_title 			15
// 		 * @hooked		loop_content_subtitle 		20
// 		 */
// 		do_action( 'restaurants-loop-content', $item, $meta );
//
// 	/**
// 	 * restaurants-after-loop-content hook
// 	 *
// 	 * @param 		object  	$item 		The post object
// 	 *
// 	 * @hooked 		loop_content_link_end 		10
// 	 * @hooked 		loop_content_wrap_end 		90
// 	 */
// 	do_action( 'restaurants-after-loop-content', $item, $meta );

/**
 * restaurants-after-loop hook
 *
 * @hooked 		loop_wrap_end 			10
 */
do_action( 'restaurants-after-loop', $args );
