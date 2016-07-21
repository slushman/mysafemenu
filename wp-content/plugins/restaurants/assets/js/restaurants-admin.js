/**
 * Enables file uploader field interaction with Media Library.
 */
(function( $ ) {

	'use strict';

	$(function() {

		var field, upload, remove;

		field = $( '[data-id="url-file"]' );
		remove = $( '#remove-file' );
		upload = $( '#upload-file' );

		//Opens the Media Library, assigns chosen file URL to input field, switches links
		upload.on( 'click', function( e ) {

			// Stop the anchor's default behavior
			e.preventDefault();

			var file_frame, json;

			if ( undefined !== file_frame ) {

				file_frame.open();
				return;

			}

			file_frame = wp.media.frames.file_frame = wp.media({
				button: {
					text: 'Choose File',
				},
				frame: 'select',
				multiple: false,
				title: 'Choose File'
			});

			file_frame.on( 'select', function() {

				json = file_frame.state().get( 'selection' ).first().toJSON();

				if ( 0 > $.trim( json.url.length ) ) {
					return;
				}

				/*
				View all the properties in the console available from the returned JSON object

				for ( var property in json ) {

					console.log( property + ': ' + json[ property ] );

				}*/

				field.val( json.url );
				upload.toggleClass( 'hide' );
				remove.toggleClass( 'hide' );

			});

			file_frame.open();

		});

		//Remove value from input, switch links
		remove.on( 'click', function( e ) {

			// Stop the anchor's default behavior
			e.preventDefault();

			// clear the value from the input
			field.val('');

			// change the link message
			upload.toggleClass( 'hide' );
			remove.toggleClass( 'hide' );

		});

	});

})( jQuery );

/**
 * Enables image uploader field interaction with Media Library.
 */
(function( $ ) {

	'use strict';

	$(function() {

		var field, upload, remove;

		field = $( '[data-id="image-file"]' );
		remove = $( '#remove-file' );
		upload = $( '#upload-file' );

		//Opens the Media Library, assigns chosen file URL to input field, switches links
		upload.on( 'click', function( e ) {

			// Stop the anchor's default behavior
			e.preventDefault();

			var file_frame, json;

			if ( undefined !== file_frame ) {

				file_frame.open();
				return;

			}

			file_frame = wp.media.frames.file_frame = wp.media({
				button: {
					text: 'Choose File',
				},
				frame: 'select',
				multiple: false,
				title: 'Choose File'
			});

			file_frame.on( 'select', function() {

				json = file_frame.state().get( 'selection' ).first().toJSON();

				if ( 0 > $.trim( json.url.length ) ) {
					return;
				}

				/*
				View all the properties in the console available from the returned JSON object

				for ( var property in json ) {

					console.log( property + ': ' + json[ property ] );

				}*/

				field.val( json.url );
				upload.toggleClass( 'hide' );
				remove.toggleClass( 'hide' );

			});

			file_frame.open();

		});

		//Remove value from input, switch links
		remove.on( 'click', function( e ) {

			// Stop the anchor's default behavior
			e.preventDefault();

			// clear the value from the input
			field.val('');

			// change the link message
			upload.toggleClass( 'hide' );
			remove.toggleClass( 'hide' );

		});

	});

})( jQuery );


jQuery(document).ready(function($){

	/**
	 * The following code deals with the custom media modal frame.  It is a modified version
	 * of Thomas Griffin's New Media Image Uploader example plugin.
	 *
	 * @link        https://github.com/thomasgriffin/New-Media-Image-Uploader
	 * @license     http://www.opensource.org/licenses/gpl-license.php
	 * @author      Thomas Griffin <thomas@thomasgriffinmedia.com>
	 * @copyright   Copyright 2013 Thomas Griffin
	 */
	var sbgs_uploader;
	var $slides_ids = $( '#_sbgs_uploader_slides' );
	var $slides_images = $( '#sbgs_uploader_container ul.sbgs_mini_slides' );

	$( '.add_slides' ).click(

		function( event ){

			event.preventDefault();

			var image_ids = $slides_ids.val();

			if ( sbgs_uploader ) {
				sbgs_uploader.open();
				return;
			}

			sbgs_uploader = wp.media.frames.sbgs_uploader = wp.media({
				button: {
					text: 'Choose Images',
				},
				className: 'media-frame sbgs-uploader-frame',
				frame: 'select',
				library: {
					type: 'image'
				},
				multiple: true,
				title: 'Choose Images'
			});

			sbgs_uploader.on( 'select', function() {

				var selection = sbgs_uploader.state().get( 'selection' );

				selection.map( function( image ) {

					image = image.toJSON();

					console.log(image);

					if ( image.id ) {

						image_ids = image_ids ? image_ids + "," + image.id : image.id;

						$slides_images.append( '' +
							'<li class="sbgs_slide" data-attachment_id="' + image.id + '">' +
								'<img src="' + image.sizes.thumbnail.url + '" class="sbgs_mini_slide" />' +
								'<a href="#" class="delete" title="Delete Image">&times;</a>' +
							'</li>'
						);

					} // End of image ID check

				}); // End of selection.map()

				$slides_ids.val( image_ids );

			}); // End of sbgs_uploader.on()

			sbgs_uploader.open();

		} // End of event()

	);





	// Image ordering
	$slides_images.sortable({
		items: 'li.sbgs_slide',
		cursor: 'move',
		scrollSensitivity:40,
		forcePlaceholderSize: true,
		forceHelperSize: false,
		helper: 'clone',
		opacity: 0.65,
		placeholder: 'sbgs-metabox-sortable-placeholder',
		start:function(event,ui){
			ui.item.css( 'background-color','#f6f6f6' );
		},
		stop:function(event,ui){
			ui.item.removeAttr( 'style' );
		},
		update: function(event, ui) {
			var image_ids = '';
			$( '.sbgs_mini_slides li.sbgs_slide' ).css( 'cursor','default' ).each(
				function() {
					var image_id = jQuery(this).attr( 'data-attachment_id' );
					image_ids = image_ids ? image_ids + "," + image_id : image_id;
				}
			);

			$slides_ids.val( image_ids );
		}
	});

	// Remove images
	$( '.sbgs_mini_slides' ).on( 'click', 'a.delete', function() {

		$(this).closest( 'li.sbgs_slide' ).remove();

		var image_ids = '';

		$( '.sbgs_mini_slides li.sbgs_slide' ).css( 'cursor','default' ).each(
			function() {
				var image_id = jQuery(this).attr( 'data-attachment_id' );
				image_ids = image_ids ? image_ids + "," + image_id : image_id;
			}
		);

		$slides_ids.val( image_ids );

		return false;
	});

	/* === End image uploader JS. === */

});

/**
 * Repeaters
 */
(function( $ ) {
	'use strict';

	var addbtn = document.querySelector( '#add-repeater' );
	var repwrap = document.querySelector( '.repeaters' );
	var repeaters = repwrap.querySelectorAll( '.repeater:not(.hidden)' );
	var orig = repwrap.querySelector( '.repeater.hidden' );
	var len = repeaters.length;

	/**
	 * Returns the selected parent element.
	 *
	 * @param 		object 		el 				The selected element.
	 * @param 		string 		stopHere 		The parent's class to find.
	 * @return 		object 						The selected parent element.
	 */
	function findParent( el, stopHere ) {

		var parent = '';

		parent = el.parentNode;

		if ( ! parent.classList ){ findParent( parent, stopHere ); }

		if ( ! parent.classList.contains( stopHere ) ) { return parent; }

		return false;

	} // findParent()

	/**
	 * Removes a repeated field.
	 *
	 * @param 		object 		event 			The event object.
	 * @param 		object 		element 		The selected element.
	 * @param 		object 		parent 			The parent element.
	 * @return 		bool 						Returns false.
	 */
	function removeRepeaterField( event, element, parent ) {

		console.log( element );

		event.preventDefault();

		console.log( parent ); // why does this come back as a null when its found in the function above?

		if ( ! parent.classList.contains( 'first' ) ) {

			repwrap.removeChild( parent );

		}

		return false;

	} // removeRepeaterField()

	/**
	 * Clones the hidden field to add another repeater.
	 */
	addbtn.addEventListener( 'click', function(e){
		e.preventDefault();

		var clone = orig.cloneNode( true );

		clone.classList.remove( 'hidden' );
		repwrap.insertBefore( clone );

		return false;

	});

	for( var i = 0; i < len; i++ ) {

		var parent = repeaters[i];
		var remover = parent.querySelector( '.link-remove' );
		var hidebtn = parent.querySelector( '.btn-edit' );
		var content = parent.querySelector( '.repeater-content' );
		var title = parent.querySelector( '.title-repeater' );
		var field = parent.querySelector( '[data-title]' );
		var fieldval = field.value;

		console.log( hidebtn );

		remover.addEventListener( 'click', function( event ){
			removeRepeaterField( event, this, parent )
		});

		hidebtn.addEventListener( 'click', function( event ){
			parent.classList.toggle( 'closed' );
			$(content).slideToggle( '150' );
		});

		console.log( fieldval );

		field.addEventListener( 'keyup', function(){
			title.createTextNode( fieldval );
		});

		if ( fieldval.length > 0 ) {

			title.textContent = fieldval;

		}
		// } else {
		//
		// 	repeater.find( '.title-repeater' ).text( nhdata.repeatertitle );
		//
		// }



		// field.addEventListener( 'keyup', function( e ){
		// 	title.text( this.value );
		// });

	}

	/**
	 * Changes the title of the repeater header as you type
	 */
	// $(function(){
	//
	// 	$( '.repeater-title' ).on( 'keyup', function(){
	//
	// 		var repeater = $(this).parents( '.repeater' );
	// 		var fieldval = $(this).val();
	//
	// 		if ( fieldval.length > 0 ) {
	//
	// 			repeater.find( '.title-repeater' ).text( fieldval );
	//
	// 		} else {
	//
	// 			repeater.find( '.title-repeater' ).text( nhdata.repeatertitle );
	//
	// 		}
	//
	// 	});
	//
	// });

	/**
	 * Makes the repeaters sortable.
	 */
	$(function() {
		$(repwrap).sortable({
			cursor: 'move',
			handle: '.handle',
			items: '.repeater',
			opacity: 0.6,
		});
	});

})( jQuery );
