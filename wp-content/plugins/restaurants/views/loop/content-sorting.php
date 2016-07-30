<?php
/**
 * The view for the list sorting in the loop.
 */

 if ( empty( $char ) ) :

 	$char = $capped;

 	?><ul class="letter-list" id="<?php echo esc_attr( $char ); ?>"><?php

 elseif ( $capped != $char ) :

 	$char = $capped;

 	?><a class="link-top" href="#">Back to top</a>
 </ul><ul class="letter-list" id="<?php echo esc_attr( $char ); ?>"><?php

 endif;
