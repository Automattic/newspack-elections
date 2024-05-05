import { __ } from '@wordpress/i18n';
import { isNil } from 'lodash';
import { normalize_profile } from '../NormaliseProfile';
import { ControlledPanel } from './ControlledPanel';

const ProfileCommsOtherPanel = (props) => {

    let {
		title,
        attributes,
        setAttributes,
		display : shouldDisplayPanel = true,
		parentAttributeKey,
		profile
    } = props

	if(!shouldDisplayPanel){
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

	if( isNil(profile) || isNil(profile.comms)){
		return null;
	}

	let controls = Object.keys(profile.comms?.other).map( (key) => {
		return {
			label : profile.comms?.other[key].label,
			attr : key,
			checked : attributes[parentAttributeKey][key],
			onChange : () => {
				setSubAttributes( { [key]: ! attributes[parentAttributeKey][key] } ) 
			}
		}
	});

	return (
		<ControlledPanel 
			controls = {controls} 
			title = { title } 
		/>
    )

}

export default ProfileCommsOtherPanel