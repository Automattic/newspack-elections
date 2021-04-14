/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import { select } from '@wordpress/data';
import { useRef } from '@wordpress/element';

/*
 * import { ServerSideRender } from '@wordpress/editor'
 *    is deprecated.
 * Use
 *    import ServerSideRender from @wordpress/server-side-render
 * instead. But it only has a default export, not a named export,
 * so you can't use braces.
 */
import ServerSideRender from '@wordpress/server-side-render';

/**
 * @param {Object} props The component properties.
 */
function Edit( props ) {
	const ref = useRef();
	const blockProps = useBlockProps( { ref } );

	if ( props.attributes.id === 0 ) {
		props.setAttributes( { id: select( 'core/editor' ).getCurrentPostId() } );
	}

	return (
		<div { ...blockProps }>
			<ServerSideRender block="govpack/issue-archive" attributes={ props.attributes } />
		</div>
	);
}

registerBlockType( 'govpack/issue-archive', {
	apiVersion: 2,
	title: 'Govpack Issue Archive',
	icon: 'groups',
	category: 'embed',
	keywords: [ 'govpack' ],
	attributes: {
		id: {
			type: 'number',
			default: 0,
		},
	},

	edit: Edit,
	save() {
		return null;
	},
} );
