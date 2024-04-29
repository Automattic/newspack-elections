/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps, BlockControls} from '@wordpress/block-editor';
import { Placeholder, Spinner } from '@wordpress/components';
import { useRef, useState, useEffect } from '@wordpress/element';
import { Icon, postAuthor, } from '@wordpress/icons';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';
import { decodeEntities } from '@wordpress/html-entities';
import { useSelect } from "@wordpress/data";
import { useEntityRecord, store as coreData } from "@wordpress/core-data"


import AutocompleteWithSuggestions from '../../components/AutocompleteWithSuggestions.jsx'

import ProfileDisplaySettings from '../../components/Panels/ProfileDisplaySettings.jsx'
import ProfileAvatarPanel from '../../components/Panels/ProfileAvatarPanel';
import ProfileCommsPanel from '../../components/Panels/ProfileCommsPanel'
import ProfileCommsOtherPanel from '../../components/Panels/ProfileCommsOtherPanel'
import ProfileCommsSocialPanel from '../../components/Panels/ProfileCommsSocialPanel'

import AvatarAlignmentToolBar from '../../components/Toolbars/AvatarAlignment.jsx';
import BlockSizeAlignmentToolbar from '../../components/Toolbars/BlockSizeAlignmentToolbar.jsx';
import ResetProfileToolbar from '../../components/Toolbars/ResetProfileToolbar.jsx';

import SingleProfile from "./../../components/single-profile"



/**
 * @param {Object} props The component properties.
 */


// Available units for avatarBorderRadius option.
const units = [
	{
		value: '%',
		label: '%',  
	},
	{
		value: 'px',
		label: 'px',
	},
	{
		value: 'em',
		label: 'em',
	},
	{
		value: 'rem',
		label: 'rem',  
	},
];

// Avatar size options.
export const avatarSizeOptions = [
	{
		value: 72,
		label: /* translators: label for small avatar size option */ __( 'Small', 'govpack' ),
		shortName: /* translators: abbreviation for small avatar size option */ __(
			'S',
			'govpack'
		),
	},
	{
		value: 128,
		label: /* translators: label for medium avatar size option */ __( 'Medium', 'govpack' ),
		shortName: /* translators: abbreviation for medium avatar size option */ __(
			'M',
			'govpack'
		),
	},
	{
		value: 192,
		label: /* translators: label for large avatar size option */ __( 'Large', 'govpack' ),
		shortName: /* translators: abbreviation for large avatar size option */ __(
			'L',
			'govpack'
		),
	},
	{
		value: 256,
		label: /* translators: label for extra-large avatar size option */ __(
			'Extra-large',
			'govpack'
		),
		shortName: /* translators: abbreviation for extra-large avatar size option  */ __(
			'XL',
			'govpack'
		),
	},
];


const ProfileSelector = ( {
	setProfile,
	...props
} ) => {

	const [ isLoading, setIsLoading ] = useState( false );
	const [ maxItemsToSuggest, setMaxItemsToSuggest ] = useState( 10 )

	return (
		<Placeholder
            icon={ <Icon icon={ postAuthor } /> }
            label={ __( 'Profile', 'govpack-blocks' ) }
        >
            { isLoading && (
						<div className="is-loading">
							{ __( 'Fetching profile info…', 'govpack' ) }
							<Spinner />
						</div>
			) }

            { ! isLoading && (
                <AutocompleteWithSuggestions
                    label={ __( 'Search for a profile to display', 'govpack' ) }
                    help={ __(
                        'Begin typing name, click autocomplete result to select.',
                        'govpack'
                    ) }

                    fetchSuggestions={ async ( search = null, offset = 0 ) => {

						const response = await apiFetch( {
							parse: false,
							path: addQueryArgs( '/wp/v2/govpack_profiles', {
								search,
								offset,
								fields: 'id,name',
							} ),
						} ).catch( (error) => {
							return error
						});

                        const total = parseInt( response.headers.get( 'x-wp-total' ) || 0 );
                        const profiles = await response.json();

						// Set max items for "load more" functionality in suggestions list.
						if ( ! maxItemsToSuggest && ! search ) {
							setMaxItemsToSuggest( total );
						}

        
						return profiles.map( _profile => ( {
							value: _profile.id,
							label: decodeEntities( _profile.title.rendered ) || __( '(no name)', 'govpack' ),
						} ) );
                    } }
					maxItemsToSuggest={ maxItemsToSuggest }
					onChange={ (items) => {
						let profileId = parseInt( items[ 0 ].value );
						setProfile(profileId)
					}}
					postTypeLabel={ __( 'profile', 'govpack-blocks' ) }
					postTypeLabelPlural={ __( 'profiles', 'govpack-blocks' ) }
					selectedItems={ [] }
				/>
			)}
		</Placeholder>
	)
}
function Edit( props ) {


	const setProfile = (newProfileId) => {
		setAttributes({"profileId" : newProfileId})
	}


    const ref = useRef();
	const blockProps = useBlockProps( { ref } );

    const {
        attributes,
        setAttributes
    } = props
    
    const {
		profileId = null,
        showAvatar
	} = attributes;

	
	const {profile, hasStartedResolution} = useSelect( (select) => {

		const selectorArgs = [ 
			'postType', 
			'govpack_profiles', 
			profileId, 
			{ 
				_embed : true 
			} 
		];

		return {
			profile : select( coreData ).getEntityRecord( ...selectorArgs ),
			hasStartedResolution: select( coreData ).hasStartedResolution(
				"getEntityRecord", // _selectorName_
				selectorArgs
			),
			hasFinishedResolution: select( coreData ).hasFinishedResolution(
				"getEntityRecord", 
				selectorArgs
			),
			hasResolutionFailed: select( coreData ).hasResolutionFailed(
				"getEntityRecord", 
				selectorArgs
			)
		}
	})
	

    const availableWidths = [
        {
            label : "Small",
            value : "small",
            maxWidth : "300px"
        },
        {
            label : "Medium",
            value : "medium",
            maxWidth : "400px"
        },
        {
            label : "Large",
            value : "large",
            maxWidth : "600px"
        },
        {
            label : "Full",
            value : "full",
            maxWidth : "100%"
        }
    ]

	/**
	 * @param {string} value The selected format.
	 */
	function updateFormat( value ) {
		setAttributes( { format: value } );
	}


	return (
		<div { ...blockProps }>

            <InspectorControls>
                <ProfileAvatarPanel attributes = {attributes} setAttributes = {setAttributes} showSizeControl = {true} showRadiusControl = {true} />
                <ProfileDisplaySettings attributes = {attributes} setAttributes = {setAttributes} showBioControl = {true} showLinkControl = {true} profile={profile} />
				<ProfileCommsPanel attributes = {attributes} parentAttributeKey={"selectedCapitolCommunicationDetails"} setAttributes = {setAttributes} title="Capitol Communications" display={attributes.showCapitolCommunicationDetails} />
				<ProfileCommsPanel attributes = {attributes} parentAttributeKey={"selectedCampaignCommunicationDetails"} setAttributes = {setAttributes} title="Campaign Communications" display={attributes.showCampaignCommunicationDetails} />
				<ProfileCommsPanel attributes = {attributes} parentAttributeKey={"selectedDistrictCommunicationDetails"} setAttributes = {setAttributes} title="District Communications" display={attributes.showDistrictCommunicationDetails} />
				<ProfileCommsOtherPanel attributes = {attributes} parentAttributeKey={"selectedOtherCommunicationDetails"} setAttributes = {setAttributes} title="Other Communications" display={attributes.showOtherCommunicationDetails} profile={profile}/>
				<ProfileCommsSocialPanel attributes = {attributes} parentAttributeKey={"selectedSocial"} setAttributes = {setAttributes} title="Social" display={attributes.showSocial} />
            </InspectorControls>
                              
            { profileId ? (
                <>
                    { profile ? (
                        <>
                            <BlockControls>
								{showAvatar &&  'is-style-center' !== attributes.className &&(
                        			<AvatarAlignmentToolBar attributes={attributes} setAttributes={setAttributes} />
                    			)}
                            	<BlockSizeAlignmentToolbar attributes={attributes} setAttributes={setAttributes} />
                            	<ResetProfileToolbar setProfile={setProfile} attributes={attributes} setAttributes={setAttributes} />
							</BlockControls>

							<SingleProfile blockClassName = "wp-block-govpack-profile"  profile={profile} attributes={ attributes } availableWidths = {availableWidths} />
                        </>
                    ) : (
						<div className="is-loading">
							{ __( 'Fetching profile info…', 'govpack' ) }
							<Spinner />
						</div>
					) }

				    
                </>
			) : (
				<ProfileSelector
					setProfile = {setProfile}
				 />
			)} 
		</div>
	);
}




export {Edit, units}
export default Edit
