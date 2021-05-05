/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
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

	const post = useSelect( select => select( 'core/editor' ).getCurrentPost() );
	const unsavedChanges = useSelect( select => select( 'core/editor' ).getPostEdits() );

	if ( props.attributes.id === 0 ) {
		props.setAttributes( { id: post.id } );
	}

	if ( unsavedChanges.hasOwnProperty( 'govpack_issue_tax' ) ) {
		props.setAttributes( { issue: unsavedChanges.govpack_issue_tax } );
	} else if ( post.hasOwnProperty( 'govpack_issue_tax' ) ) {
		props.setAttributes( { issue: post.govpack_issue_tax } );
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
		issue: {
			type: 'array',
			default: [],
		},
	},
	supports: {
		customClassName: false,
	},
	edit: Edit,
	save() {
		return null;
	},
} );
