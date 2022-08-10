import { __ } from '@wordpress/i18n';
import {Panel, PanelBody, PanelRow, ToggleControl, BaseControl, ButtonGroup, Button} from '@wordpress/components';
import {__experimentalUnitControl as UnitControl} from '@wordpress/components';



const ProfileCommsOtherPanel = (props) => {

    const {
		title,
        attributes,
        setAttributes,
		display = true,
		parentAttributeKey
    } = props

	if(!display){
		return null
	}

	console.log(attributes[parentAttributeKey])

	const setSubAttributes = (attrs) => {

		const newAttrs = {
			...attributes[parentAttributeKey],
			...attrs
		}

		setAttributes({ [parentAttributeKey] : newAttrs })
	}

    return (
		<Panel>
			<PanelBody title={ title }>
				<PanelRow>
					Hita
				</PanelRow>
			</PanelBody>
		</Panel>
	)
}

export default ProfileCommsOtherPanel