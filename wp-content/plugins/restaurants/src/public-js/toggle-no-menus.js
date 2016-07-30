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
