import { __ } from '@wordpress/i18n';
import {Panel, PanelBody, PanelRow, ToggleControl} from '@wordpress/components';
import { ControlledPanel } from './ControlledPanel';


const ProfileDisplaySettings = (props) => {

    const {
        attributes,
        setAttributes,
        showBioControl = true,
        showLinkControl = true,
		profile
    } = props


	const disableAgeToggle = _.isEmpty(profile?.meta?.date_of_birth)

	let controls = [
		{
			label : "Display Bio",
			attr : "showBio", 
			shouldDisplay : showBioControl
		},
		{
			label : "Display Name",
			attr : "showName", 
		},
		{
			label : "Display Status Tag",
			attr : "showStatusTag", 
		},
		{
			label : "Display Age",
			attr: "showAge",
			disabled: disableAgeToggle,
			help: (disableAgeToggle) ? "Date of Birth Required" : null
		},
		{
			label: 'Display Legistlative Body',
			attr: "showLegislativeBody",
		},
		{
			label: 'Display Position',
			attr: "showPosition",	
		},{
			label: 'Display Party',
			attr: "showParty",
			
		},{
			label: 'Display District',
			attr: "showDistrict",
			
		},{
			label: 'Display Status',
			attr: "showParty",
			
		},{
			label: 'Display State',
			attr: "showState",
		},{
			label : 'Display Social',
			attr : "showSocial"
		},
		{
			label : 'Display Capitol Communications',
			attr : "showCapitolCommunicationDetails"
		},
		{
			label : 'Display District Communication',
			attr : "showDistrictCommunicationDetails"
		},
		{
			label : 'Display Campaign Communication',
			attr : "showCampaignCommunicationDetails"
		},
		{
			label : 'Display Other Communication',
			attr : "showOtherCommunicationDetails"
		},{
			label : 'Display Other Links',
			attr : "showOtherLinks"
		},{
			label : 'Include Link to Profile Page',
			attr : "showProfileLink",
			shouldDisplay : showLinkControl
		}
	]


	
	const controlDefaults = {
		onChange : () => {
			setAttributes( { [control.attr]: ! attributes[control.attr] } ) 
		}
	}

	controls = controls.map( (control) => ({
		...control, 
		onChange : () => {
			setAttributes( { [control.attr]: ! attributes[control.attr] } ) 
		},
		checked : attributes[control.attr]
	}))

	return (
		<ControlledPanel 
			controls = {controls} 
			title = {__( 'Govpack Profile Settings', 'govpack' )} 
		/>

    )
}

export default ProfileDisplaySettings
