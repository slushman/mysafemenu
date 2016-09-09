/**
 * Enables file uploader field interaction with Media Library.
 */
(function() {

	'use strict';

	var sortMenu, letterLists, listsLen;

	sortMenu = document.querySelector( '.letter-sort-menu' );
	if ( ! sortMenu ) { return; }

	letterLists = document.querySelectorAll( '.letter-list' );
	if ( ! letterLists ) { return; }

	listsLen = letterLists.length;
	if ( 0 >= listsLen ) { return; }

	sortMenu.addEventListener( 'click', function( e ){

		var selected = e.target.getAttribute( 'id' );

		for ( var i = 0; i < listsLen; i++ ) {

			var checkid = letterLists[i].getAttribute( 'id' );

			if ( checkid === selected ) {

				letterLists[i].removeAttribute( 'style' );
				continue;

			}

			letterLists[i].style.display = 'none';

		}

	});

})();
