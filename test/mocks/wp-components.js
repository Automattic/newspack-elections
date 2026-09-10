/**
 * Pass-through mocks for @wordpress/components (a webpack external).
 * Structural only, so the component logic under test stays the real code.
 * TextControl mirrors the real component's contract: renders a labeled input
 * carrying the forwarded `type`, and calls onChange with the string value.
 * That the real TextControl forwards `type` is assumed, not asserted — the
 * package is a webpack external absent from node_modules — so a test reading
 * `input.type` pins what the plugin passes, not what WordPress renders.
 */
import { createElement } from '@wordpress/element';

export const TextControl = ( { label, value, type = 'text', onChange = () => {} } ) =>
	createElement(
		'div',
		null,
		label ? createElement( 'label', null, label ) : null,
		createElement( 'input', {
			className: 'components-text-control__input',
			type,
			value: value ?? '',
			onChange: ( event ) => onChange( event.target.value ),
		} )
	);

const inputLike = ( tag ) => ( { value, onChange = () => {} } ) =>
	createElement( tag, {
		value: value ?? '',
		onChange: ( event ) => onChange( event.target.value ),
	} );

export const TextareaControl = inputLike( 'textarea' );
export const SelectControl = inputLike( 'select' );
export const Spinner = () => createElement( 'span', { 'data-testid': 'wp-spinner' } );
