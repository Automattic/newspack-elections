import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
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
	title: __('Newspack Election Profile', "newspack-elections"),
    category,
    attributes,
	icon: 'groups',
	keywords: [ 'govpack', 'newspack-elections' ],
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
