import { __ } from '@wordpress/i18n';
import {Panel, PanelBody, PanelRow, ToggleControl} from '@wordpress/components';


const ProfileLabelPanel = (props) => {

    const {
        attributes,
        setAttributes,
    } = props

    const {
        showLabels,
		labelsAbove
    } = attributes

	return (
		<Panel>
			<PanelBody title={ __( 'Label', 'newspack-elections' ) }>
				<PanelRow>
					<ToggleControl
						label={ __( 'Display Row Labels', 'newspack-elections' ) }
						checked={ showLabels }
						onChange={ () => setAttributes( { showLabels: ! showLabels } ) }
					/>
				</PanelRow>
				<PanelRow>
					<ToggleControl
						label={ __( 'Position Labels Above', 'newspack-elections' ) }
						checked={ labelsAbove }
						onChange={ () => setAttributes( { labelsAbove: ! labelsAbove } ) }
						help={
							labelsAbove
								? 'Labels will be shown above.'
								: 'Labels will be shown beside.'
						}
					/>
				</PanelRow>
			</PanelBody>
		</Panel>
	)
}

export default ProfileLabelPanel