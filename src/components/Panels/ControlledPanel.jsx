
import {Panel, PanelBody, PanelRow, ToggleControl} from '@wordpress/components';
import {cleanForSlug} from '@wordpress/url'

export const ControlledPanel = ({
	title,
	controls,
	key = false
}) => {

	if(!key) {
		key = cleanForSlug(title);
	}

	return (
	<Panel>
		<PanelBody title={ title }>
			{ controls.filter( (control) => ( control.shouldDisplay ?? true) ).map( (control, index) => (
				<PanelRow key={`panel-${key}-control-${index}`}>
					<ToggleControl
						{...control}
					/>
				</PanelRow>
			))}
		</PanelBody>
	</Panel>
	)
}
