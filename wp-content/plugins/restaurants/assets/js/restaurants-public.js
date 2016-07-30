/**
 * Enables file uploader field interaction with Media Library.
 */
(function() {

	'use strict';

	var sortMenu, letterLists, noneList, listsLen;

	sortMenu = document.querySelector( '.letter-sort-menu' );
	if ( ! sortMenu ) { return; }

	letterLists = document.querySelectorAll( '.letter-list' );
	if ( ! letterLists ) { return; }

	listsLen = letterLists.length;
	if ( 0 >= listsLen ) { return; }

	sortMenu.addEventListener( 'click', function( e ){

		var selected = e.target.getAttribute( 'id' );

		if ( 'viewall' === selected  ) {

			for ( var i = 0; i < listsLen; i++ ) {

				letterLists[i].removeAttribute( 'style' );

			}

			for ( var j = 0; j < noneList.length; j++ ) {

				noneList[j].removeAttribute( 'style' );

			}

		} else {

			for ( var i = 0; i < listsLen; i++ ) {

				var checkid = letterLists[i].getAttribute( 'id' );

				if ( checkid === selected ) {

					letterLists[i].removeAttribute( 'style' );
					continue;

				}

				letterLists[i].style.display = 'none';

			}

		}

	});

})();

/**
 * Toggles the visibility of the restaurants with no menu.
 */
(function() {

	'use strict';

	var button, noneList;

	button = document.querySelector( '.toggle-none' );
	noneList = document.querySelectorAll( '[data-menu="none"]' );

	button.addEventListener( 'click', function() {

		var status = this.getAttribute( 'data-status' );

		if ( ! status ) {

			for ( var j = 0; j < noneList.length; j++ ) {

				noneList[j].style.display = 'none';

			}

			this.setAttribute( 'data-status', 'toggled' );

		} else {

			for ( var j = 0; j < noneList.length; j++ ) {

				noneList[j].removeAttribute( 'style' );

			}

			this.removeAttribute( 'data-status' );

		}

	});

})();
