import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import { useRef } from '@wordpress/element';

import {isUndefined} from "lodash"

import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import {useSelect, select} from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';
import { TextControl, Panel, PanelBody, PanelRow, RadioControl } from '@wordpress/components';

import ProfileSelector from '../components/profile-selector';


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
        <HStack>
            <dt><Text>{props.label}</Text></dt>
            <dt><Text>{value}</Text></dt>
        </HStack>
    )
}

/**
 * @param {Object} props The component properties.
 */
 function Edit( props ) {

    const ref = useRef();
	const blockProps = useBlockProps( { ref } );

    const postType = useSelect(
        ( select ) => select( 'core/editor' ).getCurrentPostType(),
        []
    );
   
    const profile = select( 'core' ).getEntityRecord('postType','govpack_profiles', (props.attributes.id ?? 0))
    

    	/**
	 * @param {string} value The selected format.
	 */
	function updateFormat( value ) {
		props.setAttributes( { format: value } );
	}

    console.log("render Selected Profile", props)

    const hasProfile = !isUndefined(profile)

    console.log("pro?", profile, hasProfile)

	return (

		<div { ...blockProps }>

			<h2>Meta Demo Selected</h2>

            {hasProfile && (
                <>
                    <dl>
                        <ListItem label="Prefix" meta_key="prefix" key="prefix" meta = {profile.meta}/>
                        <ListItem label="First Name" meta_key="first_name" key="first_name" meta = {profile.meta}/>
                        <ListItem label="Last Name" meta_key="last_name" key="last_name" meta = {profile.meta}/>
                    </dl>
                    <hr />
                </>
            )}
            <InspectorControls>
				<Panel>
					<PanelBody title={ __( 'Govpack Profile', 'govpack' ) }>
						<PanelRow>
							<ProfileSelector props={ props } />
						</PanelRow>
					</PanelBody>
				</Panel>
			</InspectorControls>

		</div>
	);
}


registerBlockType( 'govpack/profile-meta-selected', {
	apiVersion: 2,
	title: 'Govpack Profile Meta Selected',
	icon: 'groups',
	category: 'embed',
	keywords: [ 'govpack' ],
	attributes: {
        id: {
			type: 'number',
			default: 0,
		},
	},

	edit: Edit,
	save() {
		return null;
	},
} );