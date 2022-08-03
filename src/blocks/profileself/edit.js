/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

import { InspectorControls, useBlockProps} from '@wordpress/block-editor';
import { Placeholder, Spinner } from '@wordpress/components';
import { useRef, useState, useEffect } from '@wordpress/element';
import { Icon, postAuthor } from '@wordpress/icons';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';
import { withSelect, useSelect, select} from "@wordpress/data";
import { useEntityProp, getEditedEntityRecord, getEntitiesConfig} from '@wordpress/core-data';
import { compose } from "@wordpress/compose";

import ProfileDisplaySettings from './../../components/Panels/ProfileDisplaySettings.jsx'
import ProfileAvatarPanel from '../../components/Panels/ProfileAvatarPanel';

import SingleProfile from "./../../components/single-profile"
import AvatarAlignmentToolBar from '../../components/Toolbars/AvatarAlignment.jsx';

import {isNil, isUndefined, isEmpty} from "lodash"




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

function useLoaded(props){


	let {taxonomies, entity, image, terms} = useSelect( ( select ) => {

		let taxonomies = select( 'core' ).getTaxonomies({ type : props.postType })
		let entity = select( 'core' ).getEditedEntityRecord('postType', props.postType, props.profileId)
		let terms = []


		if(!isNil(taxonomies) && !isNil(entity)){
			terms = taxonomies.filter( (tax) => {
				return !isEmpty(entity[tax.slug])
			}).map((tax) => {
				return select('core').getEntityRecords( 'taxonomy', tax.slug, {"include" : entity[tax.slug]} )
			}).filter((term) => {
				return !isEmpty(term)
			});

			if(isEmpty(terms)){
				terms = false
			}		
		}

		return {
			taxonomies, 
			entity,
			image : select( 'core' ).getMedia( entity.featured_media ) ?? false,
			terms : terms
		}
	}, [] );

	return [taxonomies, entity, image, terms]
	
}
function RawEdit( props ) {

	const loaded = useLoaded(props)
	console.log("LOADED", loaded)
	const [ isLoading, setIsLoading ] = useState( true );
    const ref = useRef();
	const blockProps = useBlockProps( { ref } );

	
	useEffect( () => {
		// first, if we already know we finished loading then leave
		if(!isLoading){
			return;
		}

		// if any item returned from the hook useLoaded is empty of undefined, we're not finished loading yet so set stillLoading to true
		const stillLoading = loaded.some( (load) => {
			return isNil(load)
		} )

		// if stillLoading is false (ie - we finished loading) then set that react state
		if(!stillLoading){
			console.log("loaded", loaded)
			setIsLoading(false)
		}

	}, loaded)

	
	// destucture loaded values to make it easier to work with
	let [taxonomies, entity, image, terms] = loaded

	let {
		meta = {}, 
		title = null,
		link = null,
		excerpt = null,
		featured_media = null,
		_links = null
	} = entity

	let profile = {
		meta, title, link, excerpt, featured_media
	}

	taxonomies?.forEach( (tax) => {
		profile[tax.slug] = entity[tax.slug]
	})
	
	profile._embedded = {}
	profile._embedded['wp:featuredmedia'] = [image]
	profile._embedded['wp:term'] = terms


	//Promise.all(term_promises).then( () => setIsLoading(false ))

    const {
        attributes,
        setAttributes
    } = props
    
    const {
        showAvatar
	} = attributes;

	/*
	if(isArray(profile[tax]) && !isEmpty(profile[tax])){
		let term_lookups =  profile[tax].map( async (term) => {
			let lookup = await select('core').getEntityRecord( 'taxonomy', tax, term )
			return lookup
		})

		return await Promise.all(term_lookups)
	}
	*/
	/*
	useSelect( async (select) => {
        const id = await select("core/editor").getCurrentPostId()
		const postType = await  select( 'core/editor' ).getCurrentPostType()
		let profile = await  select( 'core/editor' ).getCurrentPost()
		const [ meta, setMeta ] = useEntityProp( 'postType', postType, 'meta' );
		profile['meta'] = meta

		console.log("profile", profile)
    });
	*/
	/*

    useEffect( () => {
		if ( 0 !== profileId ) {
			getProfileById();
		} else {

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
						
						__( 'No profile found for ID %s.', 'newspack-blocks' ),
						profileId
					)
			);
		}
		setIsLoading( false );
	};
	*/

	

    return (
        <div { ...blockProps }>
            <InspectorControls>
                <ProfileAvatarPanel attributes = {attributes} setAttributes = {setAttributes} showSizeControl = {false} showRadiusControl = {false} />
                <ProfileDisplaySettings attributes = {attributes} setAttributes = {setAttributes} showBioControl = {false} showLinkControl = {false} />
            </InspectorControls>

			{ isLoading ? (
				<div className="is-loading">
					{ __( 'Fetching profile info…', 'newspack-blocks' ) }
					<Spinner />
				</div>
			) : (
				<>
					{showAvatar &&  'is-style-center' !== attributes.className &&(
						<AvatarAlignmentToolBar  attributes = {attributes} setAttributes = {setAttributes} />
					)}
					<SingleProfile blockClassName="wp-block-govpack-profile-self" profile={profile} attributes={ attributes } availableWidths = {availableWidths} showSelf = {true} />
				</>
			) }
		</div>
	);
}

const Edit = compose([ 
	withSelect( ( select ) => {
		return {
			profileId: select( 'core/editor' ).getCurrentPostId(),
			postType: select( 'core/editor' ).getCurrentPostType(),
		};
	})
])(RawEdit)

export {Edit}
export default Edit
