
import clsx from "clsx"

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from "@wordpress/block-editor"
import { store as coreDataStore } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import { PanelBody, PanelRow, ToggleControl, TextControl, RangeControl} from "@wordpress/components";
import { decodeEntities } from '@wordpress/html-entities';

import { useProfileFieldAttributes, PROFILE_POST_TYPE} from "@npe/editor"


import useProfileTerms from "./use-profile-terms"






//const WideRangeControl = RangeControl

/**
 * TODO:
 * 1. Move useProfileTaxonomies to its own, reusable hook
 * 2. Handle having no terms available
 */



const useProfileTaxonomies = () => {
	return useSelect( (select) => {
		return select( coreDataStore ).getTaxonomies( { type: PROFILE_POST_TYPE } );
	})
}

const getProfileTermClasses = (postTerm, context = "") => {
	
	let classes = clsx("npe-term", {
		[`npe-term--${postTerm?.taxonomy}`] :postTerm?.taxonomy,
		[`npe-term--${postTerm?.slug}`] :postTerm?.slug,
		[`npe-term--${postTerm?.id}`] :postTerm?.id,
		[`npe-term--is-child-term`] :postTerm?.parent !== 0,
		[`npe-term--parent-${postTerm?.parent}`] :postTerm?.parent !== 0,

		[`npe-term--is-link`] : context === "link"
	})

	return classes
}
const ProfileTermSpan = ({postTerm}) => {
	
	const className = getProfileTermClasses(postTerm)

	return (
		<span 
			key={ postTerm.id } 
			className = {className}
		>
			{ decodeEntities( postTerm.name ) }
		</span>
	)
}

const ProfileTermLink = ({postTerm}) => {

	let className = getProfileTermClasses(postTerm, "link")
	

	return (
		<a 
			key={ postTerm.id } 
			href={ postTerm.link }
			className = {className}
			onClick={ ( event ) => event.preventDefault() }
		>
			{ decodeEntities( postTerm.name ) }
		</a>
	)
}

const ProfileTerms = ({terms, displayLinks, separator, termLimit}) => {
	
	const Element = displayLinks ? ProfileTermLink : ProfileTermSpan

	if(termLimit === 0){
		return null
	}


	return (<>
		{terms.slice(0, termLimit).map( ( postTerm ) => (
			<Element postTerm={postTerm} />
		) ).reduce( ( prev, curr ) => (
		<>
			{ prev }
			<span className="wp-block-post-terms__separator">
				{ separator || ' ' }
			</span>
			{ curr }
		</>
	) ) } </> )
}

function EditTermBlock( props ) {
	
	const { attributes, setAttributes, context, isSelected } = props
	const { fieldKey, field, value, profileId, ...restField } =  useProfileFieldAttributes(props)
	const blockProps = useBlockProps();

	
	const { 	
		displayLinks,
		separator,
		termLimit
	} = attributes
	
	const taxonomySlug = field?.taxonomy ?? attributes.taxonomy ?? null
	const taxonomies = useProfileTaxonomies();
	const selectedTaxonomy = taxonomies?.find( (t) => {
		return t.slug === taxonomySlug
	})

	
	const FieldUnsetValue = `No Value Set for ${field.label}`

	const { profileTerms, hasProfileTerms } = useProfileTerms( value, selectedTaxonomy )
	const hasProfile = (profileId);

    return (
		<>
		<InspectorControls>
			<PanelBody title="Profile Term">
			 <PanelRow>
				<ToggleControl 
					__nextHasNoMarginBottom
					label="Output Terms as Links?"
					help={
						displayLinks
							  ? 'Profile Terms are links.'
							  : 'Profile Terms are not links.'
					}
					checked={ displayLinks }
					onChange={ (newValue) => {
						setAttributes( { "displayLinks" :  newValue } );
					} }
				/>
			 </PanelRow>
			 <PanelRow>
				<TextControl
						__next40pxDefaultSize
						__nextHasNoMarginBottom
						autoComplete="off"
						label={ __( 'Separator' ) }
						value={ separator || '' }
						onChange={ ( nextValue ) => {
							setAttributes( { separator: nextValue } );
						} }
						help={ __( 'Enter character(s) used to separate terms.' ) }
					/>
			</PanelRow>
			<PanelRow>
				
					<RangeControl
						className = "npe-term-count-range"
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Term Limit' ) }
						value={ termLimit }
						onChange={ ( value ) =>
							setAttributes( {"termLimit": Math.max( 1, value )})
						}
						min={ 0 }
						max={ 10 }
					/>
			
			</PanelRow>
			</PanelBody>
		</InspectorControls>
		<div {...blockProps}  >
			{ hasProfile && hasProfileTerms &&
				<ProfileTerms 
					terms={profileTerms} 
					displayLinks={displayLinks} 
					separator = {separator}
					termLimit = {termLimit}
				/>
		 	}
			{ hasProfile && !hasProfileTerms &&
				<>{FieldUnsetValue}</>
		 	}
		</div>
		</>
	)
}

export {EditTermBlock as Edit}
export default EditTermBlock
