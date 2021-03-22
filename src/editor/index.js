/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls } from '@wordpress/block-editor';
import { Panel, PanelBody, PanelRow } from '@wordpress/components';

import ProfileSelector from './components/profile-selector';

registerBlockType( 'newspack/govpack', {
	apiVersion: 2,
	title: 'Govpack',
	icon: 'universal-access-alt',
	category: 'embed',
	keywords: [ 'govpack' ],
	attributes: {
		id: {
			type: 'number',
			default: 0,
		},
	},

	edit: props => {
		return (
			<InspectorControls>
				<Panel>
					<PanelBody title={ __( 'Govpack', 'govpack' ) }>
						<PanelRow>
							<ProfileSelector props={ props } />
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
