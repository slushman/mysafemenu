<?php
/**
 * The view for the content wrap start used in the loop
 */

?><li class="restaurant"<?php

if ( empty( $meta['menu-file'][0] ) || empty( $meta['menu-files'] ) ) :

	?> data-menu="none"<?php

endif;

?>>
