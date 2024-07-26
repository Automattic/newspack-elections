import { __ } from '@wordpress/i18n';
import {Panel, PanelBody, PanelRow, ToggleControl, BaseControl, ButtonGroup, Button} from '@wordpress/components';
import { isNil } from 'lodash';
import { normalize_profile } from '../NormaliseProfile';

export const ProfileLinksPanel = (props) => {

    let {
		title,
        attributes,
        setAttributes,
		display = true,
		parentAttributeKey,
		profile
    } = props

	if(!display){
		return null
	}

	

	const setSubAttributes = (attrs) => {

		const newAttrs = {
			...attributes[parentAttributeKey],
			...attrs
		}

		setAttributes({ [parentAttributeKey] : newAttrs })
	}


	if( isNil(profile) || isNil(profile.link_services)){
		return null;
	}

	const isDisabled = (key) => {
		return (typeof profile.profile_links[key] === "undefined")
	}

	const isActive = (key) => {

		if(Object.keys(attributes[parentAttributeKey]).length === 0){
			return !isDisabled(key)
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
							onChange={ () => setSubAttributes( { [key]: !(attributes[parentAttributeKey][key] ?? true) } ) }
							disabled = {isDisabled(key)}
						/>
					</PanelRow>
				))}
			</PanelBody>
		</Panel>
	)
}

export default ProfileLinksPanel