/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

import { InspectorControls, useBlockProps, BlockControls, BlockAlignmentControl} from '@wordpress/block-editor';
import { Placeholder, Spinner, Toolbar, ToolbarDropdownMenu } from '@wordpress/components';
import { useRef, useState, useEffect } from '@wordpress/element';
import { Icon, postAuthor,  pullLeft, pullRight, resizeCornerNE } from '@wordpress/icons';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';
import { useSelect }  from '@wordpress/data';
import { decodeEntities } from '@wordpress/html-entities';

import { AutocompleteWithSuggestions } from 'newspack-components';
import ProfileDisplaySettings from './../../components/Panels/ProfileDisplaySettings.jsx'
import ProfileAvatarPanel from '../../components/Panels/ProfileAvatarPanel';

import SingleProfile from "./single-profile.jsx"
import BlockSizeAlignmentToolbar from '../../components/Toolbars/BlockSizeAlignmentToolbar.jsx';
import AvatarAlignmentToolBar from '../../components/Toolbars/AvatarAlignment.jsx';
import ResetProfileToolbar from '../../components/Toolbars/ResetProfileToolbar.jsx';


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

function Edit( props ) {
    const [ profile, setProfile ] = useState( null );
	const [ error, setError ] = useState( null );
	const [ isLoading, setIsLoading ] = useState( true );

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


    useEffect( () => {
		if ( 0 !== profileId ) {
			getProfileById();
		} else {

        }
	}, [ profileId ] );

    useSelect( async (select) => {
        let id = await select("core/editor").getCurrentPostId()
        setAttributes({"profileId" : id })
    });

    const getProfileById = async () => {

		setError( null );
		setIsLoading( true );

		try {
		
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
		}
		setIsLoading( false );
	};

    return (
        <div { ...blockProps }>
            <InspectorControls>
                <ProfileAvatarPanel attributes = {attributes} setAttributes = {setAttributes} showSizeControl = {false} showRadiusControl = {false} />
                <ProfileDisplaySettings attributes = {attributes} setAttributes = {setAttributes} showBioControl = {false} showLinkControl = {false} />
            </InspectorControls>
                              
            { profile ? (
                <>
                   
                    {showAvatar &&  'is-style-center' !== attributes.className &&(
                        <AvatarAlignmentToolBar  attributes = {attributes} setAttributes = {setAttributes} />
                    )}

				    <SingleProfile profile={profile} attributes={ attributes } availableWidths = {availableWidths} showSelf = {true} />

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
            </Placeholder>
            )}
		</div>
	);
}




export {Edit}
export default Edit
