<?php

/**
 * Provides the markup for a repeater field
 *
 * Must include an multi-dimensional array with each field in it. The
 * field type should be the key for the field's attribute array.
 *
 * $fields['file-type']['all-the-field-attributes'] = 'Data for the attribute';
 *
 * @link       https://www.mysafemenu.com
 * @since      1.0.0
 *
 * @package    Restaurants
 * @subpackage Restaurants/views/fields
 */

//echo '<pre>'; print_r( $repeater ); echo '</pre>';

$defaults['class'] 				= 'repeater';
$defaults['fields'] 			= array( array( 'fieldtype' => '' ), array( 'fieldtype' => '' ) );
$defaults['id'] 				= '';
$defaults['labels']['add'] 		= __( 'Add', 'restaurants' );
$defaults['labels']['edit'] 	= __( 'Edit', 'restaurants' );
$defaults['labels']['header'] 	= __( 'Name', 'restaurants' );
$defaults['labels']['remove'] 	= __( 'Remove', 'restaurants' );
$setatts 						= wp_parse_args( $setatts, $defaults );

?><ul class="repeaters"><?php

	for ( $i = 0; $i <= $count; $i++ ) {

		if ( $i === $count ) {

			$setatts['class'] .= ' hidden';

		}

		?><li class="<?php echo esc_attr( $setatts['class'] ); ?>">
			<div class="handle">
				<span class="title-repeater"><?php echo esc_html( $setatts['labels']['header'], 'restaurants' ); ?></span>
				<button aria-expanded="true" class="btn-edit" type="button">
					<span class="screen-reader-text"><?php echo esc_html( $setatts['labels']['edit'], 'restaurants' ); ?></span>
					<span class="toggle-arrow"></span>
				</button>
			</div><!-- .handle -->
			<div class="repeater-content">
				<div class="wrap-fields"><?php

					foreach ( $setatts['fields'] as $field ) {

						if ( ! empty( $repeater ) && ! empty( $repeater[$i][$field['id']] ) ) {

							$field['value'] = $repeater[$i][$field['id']];

						}

						?><p class="wrap-field"><?php

						$atts = $field;

						include( plugin_dir_path( dirname( __FILE__ ) ) . 'fields/' . $field['fieldtype'] . '.php' );

						?></p><?php

					} // foreach

				?></div>
				<div>
					<a class="link-remove" href="#">
						<span><?php

							echo esc_html( apply_filters( PLUGIN_NAME_SLUG . '-repeater-remove-link-label', $setatts['labels']['remove'] ), 'restaurants' );

						?></span>
					</a>
				</div>
			</div>
		</li><!-- .repeater --><?php

	} // for

?></ul><!-- repeater -->
<div class="repeater-more">
	<span id="status"></span>
	<a class="button" href="#" id="add-repeater"><?php

		echo esc_html( apply_filters( PLUGIN_NAME_SLUG . '-repeater-more-link-label', $setatts['labels']['add'] ), 'restaurants' );

	?></a>
</div><!-- .repeater-more -->
