<?php
/**
 * The view for the content link start used in the loop
 */

if ( empty( $meta['menu-file'][0] ) ) { return; }

?><a class="restaurant-list-link" href="<?php echo esc_url( $meta['menu-file'][0] ); ?>">
