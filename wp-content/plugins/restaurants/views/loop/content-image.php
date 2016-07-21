<?php
/**
 * The view for the featured image used in the loop
 */

$images = $this->get_featured_images( $item->ID );

if ( empty( $images ) ) { return; }

if ( array_key_exists( 'medium', $images['sizes'] ) ) {

	$source = apply_filters( 'restaurants-loop-image', $images['sizes']['medium']['url'], $images );

} else {

	$source = apply_filters( 'restaurants-loop-image', $images['sizes']['full']['url'], $images );

}

?><div class="restaurants-loop-thumb" style="background-image:url(<?php echo esc_url( $source ); ?>)"></div>