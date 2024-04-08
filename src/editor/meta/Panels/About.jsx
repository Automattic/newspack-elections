import { PanelRow } from "@wordpress/components";

import {GovPackSidebarPanel} from "./../../../components/sidebar-panel"
import {PanelTextControl, PanelDateControl, PanelFieldset, PanelTaxonomyControl} from "./../Controls"


const changeContributesToName = (change) => {

	let keys = Object.keys(change)

	if(keys.length === 0){
		return false
	}
	let searchKeys = ["name_prefix", "name_first", "name_middle", "name_last", "name_suffix"]
	let intersection = keys.filter( i => searchKeys.includes(i) )

	console.log("is a name key", intersection)
}

export const AboutPanel = (props) => {

    let { setPostMeta, setTerm, setSingleTerm, meta } = props

	const updateMetaAndName = (change) => {
		console.log("??");
		if(changeContributesToName(change)){
			setPostMeta(change)
		} else {
			setPostMeta(change)
		}
	}

    return (
        <GovPackSidebarPanel 
            title="About"
            name="gov-profile-about"
        >
			<PanelRow>
                <PanelTextControl meta={meta} label = "Name" meta_key="name" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Prefix" meta_key="name_prefix" onChange={updateMetaAndName} />
            </PanelRow>

            <PanelRow>
                <PanelTextControl meta={meta} label = "First Name" meta_key="name_first" onChange={updateMetaAndName} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Middle Name" meta_key="name_middle" onChange={updateMetaAndName} />
            </PanelRow>

            <PanelRow>
                <PanelTextControl meta={meta} label = "Last Name" meta_key="name_last" onChange={updateMetaAndName} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Suffix" meta_key="name_suffix" onChange={updateMetaAndName} />
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
                <PanelDateControl meta={meta} label = "Date of Birth" meta_key="date_of_birth" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelDateControl meta={meta} label = "Date of Death" meta_key="date_of_death" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "District" meta_key="district" onChange={setPostMeta} />
            </PanelRow>


        </GovPackSidebarPanel>
    )
}