import { PanelRow } from "@wordpress/components";
import { useDispatch, useSelect } from '@wordpress/data';

import {GovPackSidebarPanel} from "./../../../components/sidebar-panel"
import {PanelTextControl, PanelDateControl, PanelTextareaControl} from "./../Controls"

import {usePanel} from './usePanel'



const changeContributesToName = (change) => {

	let keys = Object.keys(change)

	if(keys.length === 0){
		return false
	}
	let searchKeys = ["name_prefix", "name_first", "name_middle", "name_last", "name_suffix"]
	let intersection = keys.filter( i => searchKeys.includes(i) )

	if(intersection.length > 0){
		return true;
	}

	return false;
}

const getNamePieces = (meta, change) => {
	let {
		name_prefix = null, 
		name_first  = null, 
		name_middle = null, 
		name_last   = null, 
		name_suffix = null
	} = meta 

	let pieces = {
		"name_prefix" : name_prefix,
		"name_first"  : name_first,
		"name_middle" : name_middle,
		"name_last"   : name_last,
		"name_suffix" : name_suffix,
	}

	let changeKey = Object.keys(change).at(0)
	pieces[changeKey] = change[changeKey]

	return pieces

}

const assembleName = (pieces) => {
	return Object.values(pieces).join(" ").trim()
}


export const AboutPanel = (props) => {

	const {meta, setPostMeta} = usePanel()

    return (
        <GovPackSidebarPanel 
            title="About"
            name="gov-profile-about"
        >
			<PanelRow>
                <PanelTextControl meta={meta} label = "Name" meta_key="name" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Prefix" meta_key="name_prefix" onChange={setPostMeta} />
            </PanelRow>

            <PanelRow>
                <PanelTextControl meta={meta} label = "First Name" meta_key="name_first" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Middle Name" meta_key="name_middle" onChange={setPostMeta} />
            </PanelRow>

            <PanelRow>
                <PanelTextControl meta={meta} label = "Last Name" meta_key="name_last" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Suffix" meta_key="name_suffix" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Nickname" meta_key="nickname" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Occupation" meta_key="occupation" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Education" meta_key="education" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Gender" meta_key="gender" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Race" meta_key="race" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Ethnicity" meta_key="ethnicity" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextareaControl meta={meta} label = "Endorsements" meta_key="endorsements" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelDateControl meta={meta} label = "Date of Birth" meta_key="date_of_birth" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelDateControl meta={meta} label = "Date of Death" meta_key="date_of_death" onChange={setPostMeta} />
            </PanelRow>

			

			{/** 
			<PanelRow>
                <PanelTaxonomyControl 
					taxonomy="govpack_party" 
					label = "Party"
					onChange = {setSingleTerm}
				/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "District" meta_key="district" onChange={setPostMeta} />
            </PanelRow>

				*/}
        </GovPackSidebarPanel>
    )
}