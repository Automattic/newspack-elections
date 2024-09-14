import { __ } from '@wordpress/i18n';
import {Panel, PanelBody, PanelRow, ToggleControl, BaseControl, ButtonGroup, Button} from '@wordpress/components';
import {__experimentalUnitControl as UnitControl} from '@wordpress/components';



const ProfileCommsSocialPanel = (props) => {

    const {
		title,
        attributes,
        setAttributes,
		display : shouldDisplayPanel = true,
		parentAttributeKey
    } = props

    const {
        showOfficial,
        showCampaign,
        showPersonal,
    } = attributes[parentAttributeKey]


	if(!shouldDisplayPanel){
		return null
	}

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
					<ToggleControl
						label={ __( 'Display Official', 'newspack-elections' ) }
						checked={ showOfficial ?? true }
						onChange={ () => setSubAttributes( { showOfficial: ! showOfficial } ) }
					/>
				</PanelRow>
				<PanelRow>
					<ToggleControl
						label={ __( 'Display Campaign', 'newspack-elections' ) }
						checked={ showCampaign ?? true }
						onChange={ () => setSubAttributes( { showCampaign: ! showCampaign } ) }
					/>
				</PanelRow>
				<PanelRow>
					<ToggleControl
						label={ __( 'Display Personal', 'newspack-elections' ) }
						checked={ showPersonal ?? true }
						onChange={ () => setSubAttributes( { showPersonal: ! showPersonal } ) }
					/>
				</PanelRow>
			</PanelBody>
		</Panel>
	)
}

export default ProfileCommsSocialPanel