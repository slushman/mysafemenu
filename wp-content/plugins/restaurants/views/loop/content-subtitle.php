<?php
/**
 * The view for the subtitle used in the loop
 */

if ( empty( $meta['subtitle'][0] ) ) { return; }

?><p class="restaurants-subtitle"><?php echo esc_html( $meta['subtitle'][0] ); ?></p>