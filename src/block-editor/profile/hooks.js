import { useSelect, select} from '@wordpress/data';
import { store as coreDataStore } from '@wordpress/core-data';

import { store as editorStore } from '@wordpress/editor';

import { PROFILE_POST_TYPE } from './constants';
import { useAttributeOverContext, useContextOverAttribute } from './utils';
import { useFieldAttributes, useFields } from "./../fields"

import {useMemo, useState} from "@wordpress/element"
/**
 * Gets the ID of the Profile to use from the Block's Context, falling back to Attributes. 
 * Provides an ID and booleans indicating if the ID was found in Context, or Attributes  
 */
export const useProfileId = (props, pid = null) => {

	const { attributes, context, clientId, name } = props
	const [profileId, setProfileId] = useState(null)
	const [lastClientId, setLastClientId] = useState(props.clientId)

	

	const { 
		postType,
		queryId,
		'npe/postId' : inheritedSelectedProfileId = null,
		postId : queryPostId,
	} = context

	const {
		postId : selectedProfileId = null
	} = attributes

	
	const {currentPostType, currentPostId} = useSelect( (select) => {

		return {
			currentPostType : select(editorStore).getCurrentPostType(),
			currentPostId : select(editorStore).getCurrentPostId()
		}
	}, [clientId])
	
	if(pid){
		return pid
	}

	const isProfilePage = ((currentPostType === PROFILE_POST_TYPE) && (context.postId === currentPostId))
	const isQuery = (queryId && postType) ? true : false
	const isInheritedSelection = (inheritedSelectedProfileId !== null)
	const isDirectSelection = (selectedProfileId !== null )

	let derivedProfileId
	if(isProfilePage){
		
		derivedProfileId = currentPostId
	} else if(isQuery){
		
		derivedProfileId = queryPostId
	} else {
		
		derivedProfileId = isDirectSelection ? selectedProfileId : inheritedSelectedProfileId
	}

	

	if( profileId !== derivedProfileId){
		setProfileId(derivedProfileId)
		return derivedProfileId
	}

	return  profileId
}

/**
 * Get the profile specified by the ID passed
 * @param {number|string} profileId ID of the profile to fetch
 */
export const useProfile = ( profileId ) => {
	const query = useSelect(
		( select ) => {
			if ( 'preview' === profileId ) {
				return {
					profile: {},
					hasStartedLoading: false,
					hasFinishedLoading: true,
					hasFailed: false,
					hasLoaded: true,
					isLoading: false,
				};
			}

		const selectorArgs = [ 
			'postType', 
			PROFILE_POST_TYPE,
			profileId,
			{
				_embed : true,
				context: 'edit'
			}
		]

		const hasStartedResolution = select( coreDataStore ).hasStartedResolution(
			"getEntityRecord", // _selectorName_
			selectorArgs
		)
		const hasFinishedResolution = select( coreDataStore ).hasFinishedResolution(
			"getEntityRecord", 
			selectorArgs
		)
		const hasResolutionFailed = select( coreDataStore ).hasResolutionFailed(
			"getEntityRecord", 
			selectorArgs
		)

		

		return {
			profile : select( coreDataStore ).getEntityRecord(...selectorArgs),
			hasStartedLoading : hasStartedResolution,
			hasFinishedLoading : hasFinishedResolution,
			hasFailed : hasResolutionFailed,
			hasLoaded : (hasFinishedResolution && (!hasResolutionFailed)),
			isLoading : (hasStartedResolution && (!hasFinishedResolution))
		}

	}, [profileId] )

	
	return query
}

/**
 * Hook that provides profile, profileID, setProfile and reset Profile for blocks that use it.
 */
export const useProfileAttributes = ( props ) => {

	const { setAttributes } = props
	const profileId = useProfileId(props)
	const { profile, ...profileQuery } = useProfile(profileId)

	const resetProfile = () => {
		setProfile( 0 )
	}

	const setProfile = (newProfileId = 0) => {

		if(newProfileId === null){
			newProfileId = 0
		}
		setAttributes({"postId" : newProfileId})
	}

	return {setProfile, resetProfile, profileId, profile, profileQuery}
}

/**
 * Gets a Profile from a the Blocks Context
 */
export const useProfileFromContext = ( context ) => {

	
	let { 
		'npe/postId' : selectedProfileId = null,
		postId : pageInheritedPostId = null,
		postType = false
	} = context
	
	
	
	const profileId = selectedProfileId ?? pageInheritedPostId

	// Must be within a block that provide a govpack profile context..
	// Or an actual profile page
	if(!profileId && postType !== PROFILE_POST_TYPE){
		
		return false;
	} 

	// At least one of profileId or postId exists in context
	if(!profileId){
		return false;
	}

	return useSelect( (select) => {
		return select(coreDataStore).getEntityRecord("postType", PROFILE_POST_TYPE, profileId ) ?? {}
	}, [profileId])

}

/**
 * Get the defined field objects for a profile enhanced with the value for for that profile
 */
export const useProfileFields = (props) => {

	const {context} = props
	const profileId = useProfileId(props)

	const {profile} = useProfile(profileId) ?? {}
	let fields = useFields()

	

	fields = fields.map( ( field ) => {
	
		let val 
		
		

		if(profile?.profile?.[field.slug]){
			val = profile?.profile?.[field.slug]
		}

		/*
		if(field.type === "taxonomy"){

			val = profile?.profile?.[field.slug]
			
			if(!val || val.length < 1){
				val = ""
			} else {
				val = val.map((f) => f.name).join(", ")
			}

		}
		*/

		if(val && (typeof val === "string")){
			val = val.trim()
		}

		return {
			...field,
			'value' : val
		} 
	})

	return fields
}


export const useProfileFieldAttributes = (props, pid = null) => {  
		
	

	const profileId = useProfileId(props, pid)
	const fieldAttrs  = useFieldAttributes( props )

	const {profile} = useProfile( profileId )
	const value = profile?.profile?.[fieldAttrs?.fieldKey] ?? null;
	
	//console.log("fieldAttrs", fieldAttrs.fieldKey, value, pid, profileId, profile)
	
	return {
		profileId,
		profile,
		value,
		...fieldAttrs
	}
}