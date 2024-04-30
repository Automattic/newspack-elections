import { __ } from '@wordpress/i18n';
import {Panel, PanelBody, PanelRow, ToggleControl, BaseControl, ButtonGroup, Button} from '@wordpress/components';


const ProfileLabelPanel = (props) => {

    const {
        attributes,
        setAttributes,
    } = props

    const {
        showLabels
    } = attributes

	return (
		<Panel>
			<PanelBody title={ __( 'Label', 'govpack' ) }>
				<PanelRow>
					<ToggleControl
						label={ __( 'Display Row Labels', 'govpack' ) }
						checked={ showLabels }
						onChange={ () => setAttributes( { showLabels: ! showLabels } ) }
					/>
				</PanelRow>
			</PanelBody>
		</Panel>
	)
}

export default ProfileLabelPanel