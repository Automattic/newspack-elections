import { __ } from '@wordpress/i18n';
import {Panel, PanelBody, PanelRow, ToggleControl, BaseControl, ButtonGroup, Button} from '@wordpress/components';
import {__experimentalUnitControl as UnitControl} from '@wordpress/components';



const ProfileCommsPanel = (props) => {

    const {
		title,
        attributes,
        setAttributes,
		display = true,
		parentAttributeKey
    } = props

    const {
        showPhone,
        showEmail,
        showFax,
        showAddress,
		showWebsite,
    } = attributes[parentAttributeKey]


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

    return (
		<Panel>
			<PanelBody title={ title }>
				<PanelRow>
					<ToggleControl
						label={ __( 'Display Phone', 'govpack' ) }
						checked={ showPhone ?? true }
						onChange={ () => setSubAttributes( { showPhone: ! showPhone } ) }
					/>
				</PanelRow>
				<PanelRow>
					<ToggleControl
						label={ __( 'Display Fax', 'govpack' ) }
						checked={ showFax ?? true }
						onChange={ () => setSubAttributes( { showFax: ! showFax } ) }
					/>
				</PanelRow>
				<PanelRow>
					<ToggleControl
						label={ __( 'Display Email', 'govpack' ) }
						checked={ showEmail ?? true }
						onChange={ () => setSubAttributes( { showEmail: ! showEmail } ) }
					/>
				</PanelRow>
				<PanelRow>
					<ToggleControl
						label={ __( 'Display Address', 'govpack' ) }
						checked={ showAddress ?? true }
						onChange={ () => setSubAttributes( { showAddress: ! showAddress } ) }
					/>
				</PanelRow>
				<PanelRow>
					<ToggleControl
						label={ __( 'Display Website', 'govpack' ) }
						checked={ showWebsite ?? true }
						onChange={ () => setSubAttributes( { showWebsite: ! showWebsite } ) }
					/>
				</PanelRow>
			</PanelBody>
		</Panel>
	)
}

export default ProfileCommsPanel