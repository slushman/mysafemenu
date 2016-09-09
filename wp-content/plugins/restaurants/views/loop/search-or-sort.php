<?php
/**
 * The view for the search or sort menu.
 */
?><div class="search-or-sort-wrap">
	<p><button class="toggle-search-sort" aria-controls="search-or-sort" aria-expanded="false"><?php
		esc_html_e( 'Search or Sort', 'restaurant' );
	?></button></p>
	<div class="search-sort-options"><?php

		get_search_form();

		?><ul class="letter-sort-menu">
			<li id="Nums">0 - 9</li><?php

			foreach ( range( 'A', 'Z' ) as $char ) :

				?><li id="<?php echo esc_attr( $char ); ?>"><?php echo $char; ?></li><?php

			endforeach;

			unset( $char );

		?></ul>
		<ul class="other-sort-menu">
			<li id="viewall">View All</li>
			<li id="toggle-none" class="toggle-none" data-status=""><?php esc_html_e( 'Hide restaurants with no allergen menu.', 'restaurants' ); ?></li>
		</ul>
	</div>
</div>
