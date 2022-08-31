import { __ } from '@wordpress/i18n';
import {Panel, PanelBody, PanelRow, ToggleControl, BaseControl, ButtonGroup, Button} from '@wordpress/components';
import {__experimentalUnitControl as UnitControl} from '@wordpress/components';
import { isNil } from 'lodash';
import { normalize_profile } from '../NormaliseProfile';

const ProfileCommsOtherPanel = (props) => {

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

	if( isNil(profile) || isNil(profile.comms)){
		return null;
	}

    return (
		<Panel>
			<PanelBody title={ title }>

				{Object.keys(profile.comms?.other).map( (key) => (
					<PanelRow key={key}>
						<ToggleControl
							label={ profile.comms?.other[key].label}
							checked={  attributes[parentAttributeKey][key] ?? true }
							onChange={ () => setSubAttributes( { [key]: !(attributes[parentAttributeKey][key] ?? true) } ) }
						/>
					</PanelRow>
				))}
			
			</PanelBody>
		</Panel>
	)
}

export default ProfileCommsOtherPanel