/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Panel, PanelBody, PanelRow, RadioControl } from '@wordpress/components';
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

import IssueSelector from '../components/issue-selector';

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

	return (
		<div { ...blockProps }>
			<InspectorControls>
				<Panel>
					<PanelBody title={ __( 'Govpack Issue', 'govpack' ) }>
						<PanelRow>
							<IssueSelector props={ props } />
						</PanelRow>
						<PanelRow>
							<RadioControl
								label="Format"
								selected={ props.attributes.format }
								options={ [
									{ value: 'full', label: 'Full' },
									{ value: 'mini', label: 'Mini' },
									{ value: 'wiki', label: 'Wiki' },
								] }
								onChange={ updateFormat }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</InspectorControls>
			<ServerSideRender block="govpack/issue" attributes={ props.attributes } />
		</div>
	);
}

registerBlockType( 'govpack/issue', {
	apiVersion: 2,
	title: 'Govpack Issue',
	icon: 'groups',
	category: 'embed',
	keywords: [ 'govpack' ],
	attributes: {
		id: {
			type: 'number',
			default: 0,
		},
		format: {
			type: 'string',
			default: 'full',
		},
	},

	edit: Edit,
	save() {
		return null;
	},
} );
