/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls } from '@wordpress/block-editor';
import { Panel, PanelBody, PanelRow, RadioControl } from '@wordpress/components';

import ProfileSelector from './components/profile-selector';

registerBlockType( 'newspack/govpack', {
	apiVersion: 2,
	title: 'Govpack',
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

	edit: props => {
		/**
		 * @param {string} value The selected format.
		 */
		function updateFormat( value ) {
			props.setAttributes( { format: value } );
		}

		return (
			<InspectorControls>
				<Panel>
					<PanelBody title={ __( 'Govpack', 'govpack' ) }>
						<PanelRow>
							<ProfileSelector props={ props } />
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
		);
	},
	save() {
		return null;
	},
} );
