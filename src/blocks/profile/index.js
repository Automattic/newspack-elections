import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
 import Edit from './edit';
 import metadata from './block.json';

 /**
 * Style dependencies - will load in editor
 */
import './view.scss';



const { attributes, category } = metadata;

registerBlockType( 'govpack/profile', {
	apiVersion: 2,
	title: 'GovPack Profile',
    category,
    attributes,
	icon: 'groups',
	keywords: [ 'govpack' ],
    styles: [
		{ name: 'default', label:  'Default', isDefault: true },
        { name: 'boxed', label:  'Boxed' }
	],
	edit : Edit,
	save() {
		return null;
	},
    getEditWrapperProps( attributes ) {
		return {
			'data-align': attributes.align,
		};
	},
} );
