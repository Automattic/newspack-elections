import { registerBlockType } from '@wordpress/blocks';

import { useRef } from '@wordpress/element';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import {useSelect} from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';

/**
 * @param {Object} props The component properties.
 */
 function Edit( props ) {
	/**
	 * @param {string} value The selected format.
	 */
	function updateFormat( value ) {
		props.setAttributes( { format: value } );
	}

	const ref = useRef();
	const blockProps = useBlockProps( { ref } );

    const postType = useSelect(
        ( select ) => select( 'core/editor' ).getCurrentPostType(),
        []
    );
    const [ meta, setMeta ] = useEntityProp( 'postType', postType, 'meta' );
    
    console.log(postType, meta)

	return (
		<div { ...blockProps }>
			Hi There
		</div>
	);
}


registerBlockType( 'govpack/profile-meta', {
	apiVersion: 2,
	title: 'Govpack Profile Meta',
	icon: 'groups',
	category: 'embed',
	keywords: [ 'govpack' ],
	attributes: {
	},

	edit: Edit,
	save() {
		return null;
	},
} );