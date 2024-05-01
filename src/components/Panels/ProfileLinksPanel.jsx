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

	profile = normalize_profile(profile)

	const setSubAttributes = (attrs) => {

		const newAttrs = {
			...attributes[parentAttributeKey],
			...attrs
		}

		setAttributes({ [parentAttributeKey] : newAttrs })
	}


	if( isNil(profile) || isNil(profile.links)){
		return null;
	}

    return (
		<Panel>
			<PanelBody title={ title }>
				hello
			</PanelBody>
		</Panel>
	)
}

export default ProfileLinksPanel