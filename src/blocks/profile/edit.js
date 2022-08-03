/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps} from '@wordpress/block-editor';
import { Placeholder, Spinner } from '@wordpress/components';
import { useRef, useState, useEffect } from '@wordpress/element';
import { Icon, postAuthor, } from '@wordpress/icons';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';
import { decodeEntities } from '@wordpress/html-entities';
import { withSelect, useSelect, select} from "@wordpress/data";


import { AutocompleteWithSuggestions } from 'newspack-components';

import ProfileDisplaySettings from '../../components/Panels/ProfileDisplaySettings.jsx'
import ProfileAvatarPanel from '../../components/Panels/ProfileAvatarPanel';
import SingleProfile from "../../components/single-profile"
import AvatarAlignmentToolBar from '../../components/Toolbars/AvatarAlignment.jsx';
import BlockSizeAlignmentToolbar from '../../components/Toolbars/BlockSizeAlignmentToolbar.jsx';
import ResetProfileToolbar from '../../components/Toolbars/ResetProfileToolbar.jsx';


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
		label: /* translators: label for small avatar size option */ __( 'Small', 'newspack-blocks' ),
		shortName: /* translators: abbreviation for small avatar size option */ __(
			'S',
			'newspack-blocks'
		),
	},
	{
		value: 128,
		label: /* translators: label for medium avatar size option */ __( 'Medium', 'newspack-blocks' ),
		shortName: /* translators: abbreviation for medium avatar size option */ __(
			'M',
			'newspack-blocks'
		),
	},
	{
		value: 192,
		label: /* translators: label for large avatar size option */ __( 'Large', 'newspack-blocks' ),
		shortName: /* translators: abbreviation for large avatar size option */ __(
			'L',
			'newspack-blocks'
		),
	},
	{
		value: 256,
		label: /* translators: label for extra-large avatar size option */ __(
			'Extra-large',
			'newspack-blocks'
		),
		shortName: /* translators: abbreviation for extra-large avatar size option  */ __(
			'XL',
			'newspack-blocks'
		),
	},
];

function Edit( props ) {
    const [ profile, setProfile ] = useState( null );
	const [ error, setError ] = useState( null );
	const [ isLoading, setIsLoading ] = useState( false );
	const [ gotProfile, setGotProfile ] = useState( false );
	const [ maxItemsToSuggest, setMaxItemsToSuggest ] = useState( 10 );

    const ref = useRef();
	const blockProps = useBlockProps( { ref } );

    const {
        attributes,
        setAttributes
    } = props
    
    const {
		profileId,
        showAvatar
	} = attributes;

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

    useEffect( () => {	
		
		if(gotProfile){
			return
		}

		if(isLoading){
			return
		}

		if ( 0 !== profileId ) {
			getProfileById();
		}

	}, [ profileId, gotProfile, isLoading ] );


    const getProfileById = async () => {

		//console.log("getProfile By Id")

		setError( null );
		setIsLoading( true );

		try {
		
			//console.log("getProfile")


			const response = await apiFetch( {
				path: addQueryArgs( '/wp/v2/govpack_profiles/' + profileId , {
                    _embed : true
                } ),
			} );

			const _profile = response

			if ( ! _profile ) {
				throw sprintf(
					/* translators: Error text for when no authors are found. */
					__( 'No profile found for ID %s.', 'newspack-blocks' ),
					profileId
				);
			}
			setProfile( _profile );
			setGotProfile( true )
			setIsLoading( false );

		} catch ( e ) {
			setError(
				e.message ||
					e ||
					sprintf(
						/* translators: Error text for when no authors are found. */
						__( 'No profile found for ID %s.', 'newspack-blocks' ),
						profileId
					)
			);
			setIsLoading( false );
			setGotProfile( true )
		}	
		
		
	};

	return (
		<div { ...blockProps }>

            <InspectorControls>
                <ProfileAvatarPanel attributes = {attributes} setAttributes = {setAttributes} showSizeControl = {true} showRadiusControl = {true} />
                <ProfileDisplaySettings attributes = {attributes} setAttributes = {setAttributes} showBioControl = {true} showLinkControl = {true} />
            </InspectorControls>
                              
            { profile ? (
                <>
                   
                    {showAvatar &&  'is-style-center' !== attributes.className &&(
                        <AvatarAlignmentToolBar attributes={attributes} setAttributes={setAttributes} />
                    )}

                    { profile && (
                        <>
                            
                            <BlockSizeAlignmentToolbar attributes={attributes} setAttributes={setAttributes} />
                            <ResetProfileToolbar setProfile={setProfile} attributes={attributes} setAttributes={setAttributes} />
                        </>
                    ) }

				    <SingleProfile blockClassName = "wp-block-govpack-profile"  profile={profile} attributes={ attributes } availableWidths = {availableWidths} />
                </>
			) : (
			<Placeholder
                icon={ <Icon icon={ postAuthor } /> }
                label={ __( 'Profile', 'govpack-blocks' ) }
            >   
                { isLoading && (
						<div className="is-loading">
							{ __( 'Fetching profile info…', 'newspack-blocks' ) }
							<Spinner />
						</div>
				) }
                { ! isLoading && (
                    <AutocompleteWithSuggestions
                        label={ __( 'Search for an author to display', 'newspack-blocks' ) }
                        help={ __(
                            'Begin typing name, click autocomplete result to select.',
                            'newspack-blocks'
                        ) }

                        fetchSuggestions={ async ( search = null, offset = 0 ) => {
                            // If we already have a selected author, no need to fetch suggestions.
                             if ( profileId ) {
                                return [];
                             }

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
                            props.setAttributes( { profileId: parseInt( items[ 0 ].value ) } ) 
                        }}
                        postTypeLabel={ __( 'profile', 'govpack-blocks' ) }
                        postTypeLabelPlural={ __( 'profiles', 'govpack-blocks' ) }
                        selectedItems={ [] }
                    />
                )}
            </Placeholder>
            )}
		</div>
	);
}




export {Edit, units}
export default Edit
