/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps, BlockControls, BlockAlignmentControl} from '@wordpress/block-editor';
import { Panel, PanelBody, PanelRow, RadioControl, Placeholder, Spinner, ToggleControl, BaseControl, ButtonGroup, Button, Toolbar, ToolbarDropdownMenu } from '@wordpress/components';
import { useRef, useState, useEffect } from '@wordpress/element';
import { Icon, postAuthor,  pullLeft, pullRight, resizeCornerNE } from '@wordpress/icons';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';
import { decodeEntities } from '@wordpress/html-entities';

import {__experimentalUnitControl as UnitControl} from '@wordpress/components';


import { AutocompleteWithSuggestions } from 'newspack-components';


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
	const [ maxItemsToSuggest, setMaxItemsToSuggest ] = useState( 10 );

    const ref = useRef();
	const blockProps = useBlockProps( { ref } );

    const {
        attributes,
        setAttributes
    } = props
    
    const {
		profileId,
        showAvatar,
        avatarBorderRadius,
        avatarSize,
        avatarAlignment,
        align,
        
        showBio,
        showLegislativeBody,
        showPosition,
        showParty,
        showState,
        showEmail,
        showSocial,
        showAddress,
        showProfileLink
        
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
		if ( 0 !== profileId ) {
			getProfileById();
		}
	}, [ profileId ] );


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
                <Panel>
					<PanelBody title={ __( 'Avatar', 'govpack' ) }>
                        <PanelRow>
						    <ToggleControl
				    			label={ __( 'Display avatar', 'newspack-blocks' ) }
			    				checked={ showAvatar }
		    					onChange={ () => setAttributes( { showAvatar: ! showAvatar } ) }
	    					/>
    					</PanelRow>
                        { showAvatar && (
						<PanelRow>
							<UnitControl
								label={ __( 'Avatar border radius', 'newspack-blocks' ) }
								labelPosition="edge"
								__unstableInputWidth="80px"
								units={ units }
								value={ avatarBorderRadius }
								onChange={ value =>
									setAttributes( { avatarBorderRadius: 0 > parseFloat( value ) ? '0' : value } )
								}
							/>
						</PanelRow>
					) }
                    { showAvatar && (
						<BaseControl
							label={ __( 'Avatar size', 'newspack-blocks' ) }
							id="newspack-blocks__avatar-size-control"
						>
							<PanelRow>
								<ButtonGroup
									id="newspack-blocks__avatar-size-control-buttons"
									aria-label={ __( 'Avatar size', 'newspack-blocks' ) }
								>
									{ avatarSizeOptions.map( option => {
										const isCurrent = avatarSize === option.value;
										return (
											<Button
												isLarge
												isPrimary={ isCurrent }
												aria-pressed={ isCurrent }
												aria-label={ option.label }
												key={ option.value }
												onClick={ () => setAttributes( { avatarSize: option.value } ) }
											>
												{ option.shortName }
											</Button>
										);
									} ) }
								</ButtonGroup>
							</PanelRow>
						</BaseControl>
					) }
                    </PanelBody>
                </Panel>
                <Panel>
                    <PanelBody title={ __( 'Govpack Profile Settings', 'govpack' ) }>

                    <PanelRow>
						    <ToggleControl
							    label={ __( 'Display Bio', 'govpack-blocks' ) }
							    checked={ showBio }
    							onChange={ () => setAttributes( { showBio: ! showBio } ) }
		    				/>
	    				</PanelRow>
                        <PanelRow>
						    <ToggleControl
							    label={ __( 'Display Legistlative Body', 'govpack-blocks' ) }
							    checked={ showLegislativeBody }
    							onChange={ () => setAttributes( { showLegislativeBody: ! showLegislativeBody } ) }
		    				/>
	    				</PanelRow>

                        <PanelRow>
						    <ToggleControl
							    label={ __( 'Display Position', 'govpack-blocks' ) }
							    checked={ showPosition }
    							onChange={ () => setAttributes( { showPosition: ! showPosition } ) }
		    				/>
	    				</PanelRow>
                        
                        <PanelRow>
						    <ToggleControl
							    label={ __( 'Display Party', 'govpack-blocks' ) }
							    checked={ showParty }
    							onChange={ () => setAttributes( { showParty: ! showParty } ) }
		    				/>
	    				</PanelRow>
                        <PanelRow>
						    <ToggleControl
							    label={ __( 'Display State', 'govpack-blocks' ) }
							    checked={ showState }
    							onChange={ () => setAttributes( { showState: ! showState } ) }
		    				/>
	    				</PanelRow>
                        <PanelRow>
						    <ToggleControl
							    label={ __( 'Display Email', 'govpack-blocks' ) }
							    checked={ showEmail }
    							onChange={ () => setAttributes( { showEmail: ! showEmail } ) }
		    				/>
	    				</PanelRow>
                        <PanelRow>
						    <ToggleControl
							    label={ __( 'Display Social', 'govpack-blocks' ) }
							    checked={ showSocial }
    							onChange={ () => setAttributes( { showSocial: ! showSocial } ) }
		    				/>
	    				</PanelRow>

                        <PanelRow>
						    <ToggleControl
							    label={ __( 'Display Addresses', 'govpack-blocks' ) }
							    checked={ showAddress }
    							onChange={ () => setAttributes( { showAddress: ! showAddress } ) }
		    				/>
	    				</PanelRow>

                        <PanelRow>
						    <ToggleControl
							    label={ __( 'Include Link to Profile Page', 'govpack-blocks' ) }
							    checked={ showProfileLink }
    							onChange={ () => setAttributes( { showProfileLink: ! showProfileLink } ) }
		    				/>
	    				</PanelRow>

                    </PanelBody>
                </Panel>
				
			</InspectorControls>
                              
            { profile ? (
                <>
                   
                   { showAvatar &&  'is-style-center' !== attributes.className &&(
                        <BlockControls>
                           <Toolbar
							controls={ [
								{
									icon: <Icon icon={ pullLeft } />,
									title: __( 'Show avatar on left', 'newspack-blocks' ),
									isActive: avatarAlignment === 'left',
									onClick: () => setAttributes( { avatarAlignment: 'left' } ),
								},
								{
									icon: <Icon icon={ pullRight } />,
									title: __( 'Show avatar on right', 'newspack-blocks' ),
									isActive: avatarAlignment === 'right',
									onClick: () => setAttributes( { avatarAlignment: 'right' } ),
								},
							] }
						/>
                        </BlockControls>
                    ) }

                    { profile && (
                        <>
                            <BlockControls>
                                <Toolbar>
                                    <BlockAlignmentControl
                                        value={ align }
                                        onChange={ (newAlignment) => setAttributes( { align: newAlignment } ) }
                                        controls = {['left', 'center', 'right','full']}
                                    />
                                    { (align !== "full") && (
                                        <ToolbarDropdownMenu
                                                icon = {resizeCornerNE}
                                                label = { __( 'Modify Selection', 'newspack-blocks' ) }
                                                controls={ availableWidths.map( (width) => {
                                                    return [
                                                        {
                                                            title: width.label,
                                                            icon: resizeCornerNE,
                                                            onClick: () => setAttributes( { width: width.value } )
                                                        },
                                                    ]
                                                }) }
                                        />
                                    )}
                                </Toolbar>
                            </BlockControls>

                            <BlockControls>
                                <Toolbar
                                    controls={ [
                                        {
                                            icon: <Icon icon={ postAuthor } />,
                                            title: __( 'Modify Selection', 'newspack-blocks' ),
                                            onClick: () => {
                                                setAttributes( { profileId: 0 } );
                                                setProfile( null );
                                            },
                                        },
                                    ] }
                                />
                            </BlockControls>
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
