import { registerBlockType } from '@wordpress/blocks';

registerBlockType( 'newspack/govpack', {
	apiVersion: 2,
	title: 'Govpack',
	icon: 'universal-access-alt',
	category: 'embed',
	keywords: [ 'govpack' ],
	edit() {
		return <div></div>;
	},
	save() {
		return <div></div>;
	},
} );
