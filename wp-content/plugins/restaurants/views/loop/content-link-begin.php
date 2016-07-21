<?php
/**
 * The view for the content link start used in the loop
 */

$link = ( empty( $meta['menu-file'][0] ) ? get_permalink( $item->ID ) : $meta['menu-file'][0] );

?><a class="restaurant-list-link" href="<?php echo esc_url( $link ); ?>">
