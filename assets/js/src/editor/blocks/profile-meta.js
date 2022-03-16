import { registerBlockType } from '@wordpress/blocks';

import { useRef } from '@wordpress/element';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import {useSelect} from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';
import { TextControl } from '@wordpress/components';

import {useState} from "React"

import {
    __experimentalHStack as HStack,
    __experimentalText as Text,
} from '@wordpress/components';

const ListItem = (props) => {
    console.log(props)

    const updateMeta = (newValue) => {
        console.log(newValue, props)
        props.setMeta( { ...props.meta, [props.meta_key]: newValue } );
    }

    let value =  props.meta[props.meta_key]
    return (
        <div>
            <dt><Text>{props.label}</Text></dt>
            <dd>
                <TextControl
                    value={ value }
                    onChange={ (val) => {
                        //console.log("Change", val)
                        updateMeta(val)
                    } }
                />
            </dd>
        </div>
    )
}

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


    const postType = useSelect(
        ( select ) => select( 'core/editor' ).getCurrentPostType(),
        []
    );
    const [ meta, setMeta ] = useEntityProp( 'postType', postType, 'meta' );



	return (

		<div>
			<h2>Meta Demo</h2>
            <dl>

                <ListItem label="First Name" meta_key="first_name" key="first_name" meta = {meta} setMeta = {setMeta}/>
                <ListItem label="Last Name" meta_key="last_name" key="last_name" meta = {meta} setMeta = {setMeta}/>
            </dl>
            <hr />
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