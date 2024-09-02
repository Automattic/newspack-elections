import { registerBlockType, unregisterBlockType } from '@wordpress/blocks';
import domReady from '@wordpress/dom-ready';
import {subscribe, select} from "@wordpress/data"


/**
 * Internal dependencies
 */
 import Edit from './edit';

 /**
 * Style dependencies - will load in editor
 */
//import './editor.scss';
import './view.scss';

import metadata from './block.json';
const { name, attributes, category } = metadata;

export const title = 'GovPack Profile Self'

registerBlockType( 'govpack/profile-self', {
	apiVersion: 2,
	title,
    category,
    attributes,
	icon: 'groups',
	keywords: [ 'govpack' ],
	edit : Edit,
	save() {
		return null;
	},
} );  


function unregisterProfileSelf(){
	let currentPostType
	const unsubscribe = subscribe( ( ) => {
		currentPostType = select("core/editor").getCurrentPostType()
	
		if(currentPostType === null) {
			return;
		}
		
		if(currentPostType === "govpack_profiles"){
			return;
		}

		unregisterBlockType( 'govpack/profile-self' );
		unsubscribe()
		
	}, "core/editor")
}

domReady( unregisterProfileSelf );