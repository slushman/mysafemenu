/**
 * Enables file uploader field interaction with Media Library.
 */
(function() {

	'use strict';

	var otherMenu, letterLists, listsLen, noneList;

	otherMenu = document.querySelector( '.other-sort-menu' );
	if ( ! otherMenu ) { return; }

	letterLists = document.querySelectorAll( '.letter-list' );
	if ( ! letterLists ) { return; }

	listsLen = letterLists.length;
	if ( 0 >= listsLen ) { return; }

	noneList = document.querySelectorAll( '[data-menu="none"]' );

	otherMenu.addEventListener( 'click', function( e ){

		var selected = e.target.getAttribute( 'id' );

		if ( 'viewall' === selected  ) {

			for ( var i = 0; i < listsLen; i++ ) {

				letterLists[i].removeAttribute( 'style' );

			}

			for ( var j = 0; j < noneList.length; j++ ) {

				noneList[j].removeAttribute( 'style' );

			}

		}

		if ( 'toggle-none' === selected ) {

			var status = e.target.getAttribute( 'data-status' );

			if ( ! status ) {

				for ( var j = 0; j < noneList.length; j++ ) {

					noneList[j].style.display = 'none';

				}

				e.target.setAttribute( 'data-status', 'toggled' );

			} else {

				for ( var j = 0; j < noneList.length; j++ ) {

					noneList[j].removeAttribute( 'style' );

				}

				e.target.removeAttribute( 'data-status' );

			}

		}

	});

})();


/**
 * Toggles the visibility of the restaurants with no menu.
 */
// (function() {
//
// 	'use strict';
//
// 	var button, noneList;
//
// 	button = document.querySelector( '.toggle-none' );
// 	noneList = document.querySelectorAll( '[data-menu="none"]' );
//
// 	button.addEventListener( 'click', function() {
//
// 		var status = this.getAttribute( 'data-status' );
//
// 		if ( ! status ) {
//
// 			for ( var j = 0; j < noneList.length; j++ ) {
//
// 				noneList[j].style.display = 'none';
//
// 			}
//
// 			this.setAttribute( 'data-status', 'toggled' );
//
// 		} else {
//
// 			for ( var j = 0; j < noneList.length; j++ ) {
//
// 				noneList[j].removeAttribute( 'style' );
//
// 			}
//
// 			this.removeAttribute( 'data-status' );
//
// 		}
//
// 	});
//
// })();
