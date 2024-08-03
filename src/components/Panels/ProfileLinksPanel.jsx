import { __ } from '@wordpress/i18n';
import {Panel, PanelBody, PanelRow, ToggleControl, BaseControl, ButtonGroup, Button} from '@wordpress/components';
import { isNil } from 'lodash';
import { normalize_profile } from '../NormaliseProfile';
import {useEffect} from "@wordpress/element"

export const ProfileLinksPanel = (props) => {

    let {
		title,
        attributes,
        setAttributes,
		display = true,
		parentAttributeKey,
		profile
    } = props


	/**
	 * When The Links and IDs are enabled and populated, this should default it to on.
	 * 
	 * Waits for changes in the block attributes[parentAttributeKey] and the profile.profile_links
	 * If the profile link is valid, turn set the subattribute for the link on
	 * Batch these into a single object to update all at once
	 */
	useEffect( () => {
	
		const linksToEnable = {} 

		Object.keys(profile.profile_links).filter( (key) => {
			let link = profile.profile_links[key];
			if(!link.href){
				return false;
			}
			return true;
		}).filter( (key) => {
			return (typeof attributes[parentAttributeKey][key] === "undefined")
		}).forEach( (key) => {
			linksToEnable[key] = true
		})

		if(Object.keys(linksToEnable).length > 0){
			setSubAttributes(linksToEnable)
		}

	}, [ attributes[parentAttributeKey], profile.profile_links ]) 

	if(!display){
		return null
	}

	
	const setSubAttributes = (attrs) => {

		console.log("setSubAttributes", attrs)
		const newAttrs = {
			...attributes[parentAttributeKey],
			...attrs
		}

		setAttributes({ [parentAttributeKey] : newAttrs })
	}

	console.log(attributes[parentAttributeKey])

	if( isNil(profile) || isNil(profile.link_services)){
		return null;
	}

	const isDisabled = (key) => {
		return (typeof profile.profile_links[key] === "undefined")
	}

	const isActive = (key) => {
		
		if(Object.keys(attributes[parentAttributeKey]).length === 0){
			return false
		} 
		
		return attributes[parentAttributeKey][key] ?? false
	}

	
    return (
		<Panel>
			<PanelBody title={ title }>
			{Object.keys(profile.link_services ?? {}).map( (key) => (
					<PanelRow key={key}>
						<ToggleControl
							label={ profile.link_services[key].label}
							checked={  isActive(key) }
							onChange={ () => setSubAttributes( { [key]: !isActive(key) } ) }
							disabled = {isDisabled(key)}
						/>
					</PanelRow>
				))}
			</PanelBody>
		</Panel>
	)
}

export default ProfileLinksPanel