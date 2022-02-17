/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { Panel, PanelBody, PanelRow, RadioControl, Placeholder, Spinner } from '@wordpress/components';
import { useRef, useState, useEffect } from '@wordpress/element';
import { Icon, postAuthor } from '@wordpress/icons';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';
import { decodeEntities } from '@wordpress/html-entities';

/*
 * import { ServerSideRender } from '@wordpress/editor'
 *    is deprecated.
 * Use
 *    import ServerSideRender from @wordpress/server-side-render
 * instead. But it only has a default export, not a named export,
 * so you can't use braces.
 */


import ServerSideRender from '@wordpress/server-side-render';
import ProfileSelector from '../components/profile-selector';

import { AutocompleteWithSuggestions } from 'newspack-components';

/**
 * @param {Object} props The component properties.
 */


function Edit( props ) {
    const [ profile, setProfile ] = useState( null );
	const [ error, setError ] = useState( null );
	const [ isLoading, setIsLoading ] = useState( false );
	const [ maxItemsToSuggest, setMaxItemsToSuggest ] = useState( 10 );

    const ref = useRef();
	const blockProps = useBlockProps( { ref } );

    const {
		profileId
	} = props.attributes;

	/**
	 * @param {string} value The selected format.
	 */
	function updateFormat( value ) {
		props.setAttributes( { format: value } );
	}

    useEffect( () => {
		if ( 0 !== profileId ) {
			getProfileById();
		}
	}, [ profileId ] );


    const getProfileById = async () => {
		setError( null );
		setIsLoading( true );
		try {
			const params = {
				profileId,
			};


			const response = await apiFetch( {
				path: addQueryArgs( '/wp/v2/govpack_profiles/', params ),
			} );

			const _profile = response.pop();

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



    console.log(profile)

	return (
		<div { ...blockProps }>
			<InspectorControls>
				<Panel>
					<PanelBody title={ __( 'Govpack Profile', 'govpack' ) }>
						<PanelRow>
							<ProfileSelector props={ props } />
						</PanelRow>
						<PanelRow>
							<RadioControl
								label="Format"
								selected={ props.attributes.format }
								options={ [
									{ value: 'full', label: 'Full' },
									{ value: 'mini', label: 'Mini' },
									{ value: 'wiki', label: 'Wiki' },
								] }
								onChange={ updateFormat }
							/>
						</PanelRow>
					</PanelBody>
				</Panel>
			</InspectorControls>
            { profile ? (
				<>Profile! {profile.post_title}</>
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
                            // if ( props.attributes.id ) {
                            //    return [];
                            // }

                            const response = await apiFetch( {
                                parse: false,
                                path: addQueryArgs( '/wp/v2/govpack_profiles', {
                                    search,
                                    offset,
                                    fields: 'id,name',
                                } ),
                            } );

                            const total = parseInt( response.headers.get( 'x-wp-total' ) || 0 );
                            const profiles = await response.json();

                            // Set max items for "load more" functionality in suggestions list.
                            if ( ! maxItemsToSuggest && ! search ) {
                                setMaxItemsToSuggest( total );
                            }

                            console.log
                            return profiles.map( _profile => ( {
                                value: _profile.id,
                                label: decodeEntities( _profile.title.rendered ) || __( '(no name)', 'govpack' ),
                            } ) );
                        } }
                        maxItemsToSuggest={ maxItemsToSuggest }
                        onChange={ items => props.setAttributes( { profileId: parseInt( items[ 0 ].value ) } ) }
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


registerBlockType( 'govpack/profile', {
	apiVersion: 2,
	title: 'Govpack',
	icon: 'groups',
	category: 'embed',
	keywords: [ 'govpack' ],
	attributes: {
		profileId: {
			type: 'number',
			default: 0,
		},
		format: {
			type: 'string',
			default: 'full',
		},
	},

	edit: Edit,
	save() {
		return null;
	},
} );


