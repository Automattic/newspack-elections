import { __ } from '@wordpress/i18n';
import { ControlledPanel } from './ControlledPanel';


const ProfileCommsPanel = (props) => {

    const {
		title,
        attributes,
        setAttributes,
		display : shouldDisplayPanel = true,
		parentAttributeKey
    } = props


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

	let controls = [
		{
			label : "Display Phone",
			attr : "showPhone", 
		},{
			label : "Display Fax",
			attr : "showFax", 
		},{
			label : "Display Email",
			attr : "showEmail", 
		},{
			label : "Display Address",
			attr : "showAddress", 
		},{
			label : "Display Website",
			attr : "showWebsite", 
		},
	]


	controls = controls.map( (control) => ({
		...control, 
		checked : attributes[parentAttributeKey][control.attr],
		onChange : () => {
			setSubAttributes( { [control.attr]: ! attributes[parentAttributeKey][control.attr] } ) 
		}
	}))



	return (
		<ControlledPanel 
			controls = {controls} 
			title = { title } 
		/>
    )

}

export default ProfileCommsPanel