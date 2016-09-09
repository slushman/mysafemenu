/**
 * Toggles the visibility of the search and sort options.
 */
(function() {

	'use strict';

	var button, options;

	button = document.querySelector( '.toggle-search-sort' );
	options = document.querySelector( '.search-sort-options' );

	options.setAttribute( 'aria-hidden', 'true' );

	function toggleOptions( e ) {

		e.preventDefault();

		options.classList.toggle( 'open' );

		if ( options.classList.contains( 'open' ) ) {

			options.setAttribute( 'aria-hidden', 'false' );

		} else {

			options.setAttribute( 'aria-hidden', 'true' );

		}

	}

	button.addEventListener( 'click', toggleOptions );

})();
