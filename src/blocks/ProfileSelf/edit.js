/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

import { InspectorControls, useBlockProps, BlockControls} from '@wordpress/block-editor';
import { Spinner } from '@wordpress/components';
import { useRef, useState, useEffect } from '@wordpress/element';
import { withSelect, useSelect, select} from "@wordpress/data";
import { compose } from "@wordpress/compose";

import ProfileDisplaySettings from './../../components/Panels/ProfileDisplaySettings.jsx'
import ProfileAvatarPanel from '../../components/Panels/ProfileAvatarPanel';
import ProfileLabelPanel from '../../components/Panels/ProfileLabelPanel';
import ProfileCommsPanel from '../../components/Panels/ProfileCommsPanel'
import ProfileCommsOtherPanel from '../../components/Panels/ProfileCommsOtherPanel'
import ProfileCommsSocialPanel from '../../components/Panels/ProfileCommsSocialPanel'
import {ProfileLinksPanel} from '../../components/Panels/ProfileLinksPanel.jsx'

import SingleProfile from "./../../components/single-profile"
import AvatarAlignmentToolBar from '../../components/Toolbars/AvatarAlignment.jsx';
import BlockSizeAlignmentToolbar from '../../components/Toolbars/BlockSizeAlignmentToolbar.jsx';

import {isNil, isEmpty} from "lodash"


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

function useLoaded(){


	let resp = useSelect( ( select ) => {

		const postType = select( 'core/editor' ).getCurrentPostType()
		const profileId = select( 'core/editor' ).getCurrentPostId()
		const taxonomies = select( 'core' ).getTaxonomies({ type : postType })
		let terms = []

		let selectorArgs = [
			"postType",
			postType,
			profileId
		]

		let entity = select( 'core' ).getEditedEntityRecord(...selectorArgs)
		
		if(!isNil(taxonomies) && !isNil(entity)){

			terms = taxonomies.
				filter( (tax) => {
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
			profileId,
			postType,
			taxonomies, 
			entity,
			image : select( 'core' ).getMedia( entity.featured_media ) ?? false,
			terms,
			hasResolved: select( 'core' ).hasFinishedResolution('getEntityRecords', selectorArgs),
		}

	}, [] );

	return resp
	
}
function Edit( props ) {

	const {
        attributes,
        setAttributes
    } = props
    
    const {
        showAvatar,
	} = attributes;

	const {
		taxonomies, 
		entity, 
		image, 
		terms, 
		hasResolved
	} = useLoaded()

    const ref = useRef();
	const blockProps = useBlockProps( { ref } );

	let {
		meta = {}, 
		title = null,
		link = null,
		excerpt = null,
		featured_media = null,
		_links = null,
		link_services,
		profile_links
	} = entity

	let profile = {
		meta, title, link, excerpt, featured_media, link_services, profile_links
	}

	taxonomies?.forEach( (tax) => {
		profile[tax.slug] = entity[tax.slug]
	})
	
	profile._embedded = {}
	profile._embedded['wp:featuredmedia'] = [image]
	profile._embedded['wp:term'] = terms

    return (
        <div { ...blockProps }>
            <InspectorControls>
                <ProfileAvatarPanel attributes = {attributes} setAttributes = {setAttributes} showSizeControl = {false} showRadiusControl = {true} />
				<ProfileLabelPanel attributes = {attributes} setAttributes = {setAttributes} />
                <ProfileDisplaySettings attributes = {attributes} setAttributes = {setAttributes} showBioControl = {true} showLinkControl = {false} profile={profile} />
				<ProfileCommsPanel attributes = {attributes} parentAttributeKey={"selectedCapitolCommunicationDetails"} setAttributes = {setAttributes} title="Capitol Communications" display={attributes.showCapitolCommunicationDetails} />
				<ProfileCommsPanel attributes = {attributes} parentAttributeKey={"selectedCampaignCommunicationDetails"} setAttributes = {setAttributes} title="Campaign Communications" display={attributes.showCampaignCommunicationDetails} />
				<ProfileCommsPanel attributes = {attributes} parentAttributeKey={"selectedDistrictCommunicationDetails"} setAttributes = {setAttributes} title="District Communications" display={attributes.showDistrictCommunicationDetails} />
				<ProfileCommsOtherPanel attributes = {attributes} parentAttributeKey={"selectedOtherCommunicationDetails"} setAttributes = {setAttributes} title="Other Communications" display={attributes.showOtherCommunicationDetails} profile={profile}/>
				<ProfileCommsSocialPanel attributes = {attributes} parentAttributeKey={"selectedSocial"} setAttributes = {setAttributes} title="Social" display={attributes.showSocial} />
				<ProfileLinksPanel key={"block-profile-row-links"} attributes = {attributes} parentAttributeKey={"selectedLinks"} setAttributes = {setAttributes} title="Links" display={attributes.showOtherLinks} profile={profile} />
            </InspectorControls>
			<BlockControls>
				{showAvatar &&  'is-style-center' !== attributes.className &&(
					<AvatarAlignmentToolBar  attributes = {attributes} setAttributes = {setAttributes} />
				)}
				{/*<BlockSizeAlignmentToolbar attributes={attributes} setAttributes={setAttributes} />*/}	
			</BlockControls>

			{ hasResolved ? (
				<div className="is-loading">
					{ __( 'Fetching profile info…', 'govpack-blocks' ) }
					<Spinner />
				</div>
			) : (
				<>
					<SingleProfile blockClassName="wp-block-govpack-profile-self" profile={profile} attributes={ attributes } availableWidths = {availableWidths} showSelf = {true} />
				</>
			) }
		</div>
	);
}



export {Edit}
export default Edit
