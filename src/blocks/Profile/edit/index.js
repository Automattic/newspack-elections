import { isNil } from "lodash"

import {useSelect, select} from "@wordpress/data"
import {store as blockEditorStore, useInnerBlocksProps, useBlockProps, BlockContextProvider} from "@wordpress/block-editor"
import { store as blocksStore } from '@wordpress/blocks';
import { store as editorStore } from '@wordpress/editor';
import { useCallback, useState, useEffect } from '@wordpress/element';

import { ProfileBlockEdit } from "./edit"
import { ProfileVariationSelector } from "./variation-selector"
import { ProfileSelector } from "./profile-selector"

import { ProfileSelector as ProfileSelectorPlaceholder } from "./../../../components/ProfileSelector.jsx"
import { PROFILE_POST_TYPE } from "@npe/editor"

import "./../editor.scss"
/**
 * The ProfileEdit Component's only job is to show the correct sub-component
 * 1. The Profile Selection UI
 * 2. The Pattern / Variation Picker UI
 * 3. The Block Editing UI
*/

const BLOCK_MODES = {
	UNKNOWN: 0,
	PROFILE : 1,
	QUERY: 2,
	EMBEDED: 3
}

export const ProfileEdit = ( props ) => {

	
	const { clientId, attributes, name, setAttributes, context} = props
	const blockProps = useBlockProps()
	const {children, ...innerBlockProps} = useInnerBlocksProps(blockProps)

	const [blockMode, setBlockMode] = useState(BLOCK_MODES["UNKNOWN"])
	//const [profileId, setProfileId] = useState(null)

	const {
		queryId
	} = context

	// Once a Profile Has Inner Blocks we can't re-choose the variation
	const hasInnerBlocks = useSelect( ( select ) => {
			return select( blockEditorStore ).getBlock( clientId )
		}, [ clientId ]
	);


	const currentPostType = select(editorStore).getCurrentPostType()
	const currentPostId = select(editorStore).getCurrentPostId()

	
	const hasVariations = useSelect( ( select ) => {
			return select( blocksStore ).getBlockVariations( name )
		}, [ name ]
	);
	
	const setProfile = useCallback ((newProfileId) => {
		setAttributes({"postId" : newProfileId})
	}, [setAttributes])

	/*
	 * This code block is for determining if the block is inserted in the editor or is it in inserter preview
	 * We can use this to render the profile selector if block with preview profileId is inserted in the editor
	 */
	const { isSelected } = useSelect(
		( select ) => {
			const be = select( 'core/block-editor' );
			return { isSelected: be.isBlockSelected( clientId ) };
		},
		[ clientId ]
	);

	useEffect( () => {
		if ( attributes?.postId === 'preview' && isSelected ) {
			setProfile( 0 );
		}
	}, [ attributes?.postId, isSelected ] );

	const isProfilePage = (currentPostType === PROFILE_POST_TYPE) && (context.postId === currentPostId)
	const isInQueryLoop = (!isNil(queryId))
	//const isEmbeded = (!isProfilePage && !isInQueryLoop)

	let calculatedBlockMode
	let calculatedProfileId
	if(isProfilePage){
		calculatedBlockMode = BLOCK_MODES["PROFILE"]
		calculatedProfileId = currentPostId
	} else if(isInQueryLoop) {
		calculatedBlockMode = BLOCK_MODES["QUERY"]
		calculatedProfileId = context.postId
	} else {
		calculatedBlockMode = BLOCK_MODES["EMBEDED"]
		calculatedProfileId = attributes.postId
	}

	if(calculatedBlockMode !== blockMode){
		setBlockMode(calculatedBlockMode)
	}


	// If we have a postId then dont show the selector
	const hasSelectedProfile = attributes.postId ?? false
	const showVariationSelector = (hasInnerBlocks.length === 0) && (hasVariations.length > 0);
	const showProfileSelector = !isInQueryLoop && !isProfilePage && !hasSelectedProfile;
	const showEdit = hasInnerBlocks && hasSelectedProfile;

	
	let Component
	if(showProfileSelector){
		Component = ProfileSelector
	} else if (showVariationSelector) {
		Component = ProfileVariationSelector
	} else {
		Component = ProfileBlockEdit
	}
	
	console.log("calculatedProfileId", calculatedProfileId)
	return (
		<BlockContextProvider
			value = {{
				"postId" : calculatedProfileId,
				"npe/postId" : calculatedProfileId,
				"npe/profileId" : calculatedProfileId,
				"npe/mode" : blockMode,
			}}
		>
			<Component  {...props} 
				setProfile = {setProfile} 
				isProfilePage = {isProfilePage} 
				blockMode = {blockMode} 
			/>
		</BlockContextProvider>
	)
}