import { PanelRow } from "@wordpress/components";

import {GovPackSidebarPanel} from "./../../../components/sidebar-panel"
import {PanelTextControl, PanelDateControl, PanelFieldset, PanelTaxonomyControl, PanelTextareaControl} from "./../Controls"

export const AboutPanel = (props) => {

    let { setPostMeta, setTerm, setSingleTerm } = props

    return (
        <GovPackSidebarPanel 
            title="About"
            name="gov-profile-about"
        >
			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Name" meta_key="name" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Prefix" meta_key="name_prefix" onChange={setPostMeta} />
            </PanelRow>

            <PanelRow>
                <PanelTextControl meta={props.meta} label = "First Name" meta_key="name_first" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Middle Name" meta_key="name_middle" onChange={setPostMeta} />
            </PanelRow>

            <PanelRow>
                <PanelTextControl meta={props.meta} label = "Last Name" meta_key="name_last" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Suffix" meta_key="name_suffix" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Nickname" meta_key="nickname" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Occupation" meta_key="occupation" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Education" meta_key="education" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Gender" meta_key="gender" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Race" meta_key="race" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Ethnicity" meta_key="ethnicity" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextareaControl meta={props.meta} label = "Endorsements" meta_key="endorsements" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelDateControl meta={props.meta} label = "Date of Birth" meta_key="date_of_birth" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelDateControl meta={props.meta} label = "Date of Death" meta_key="date_of_death" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelDateControl meta={props.meta} label = "Date of Death" meta_key="date_of_death" onChange={setPostMeta} />
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
                <PanelTaxonomyControl 
					taxonomy="govpack_state" 
					label = "State"
					onChange = {setSingleTerm}
				/>
            </PanelRow>

			<PanelRow>
                <PanelTaxonomyControl 
					taxonomy="govpack_officeholder_status" 
					label = "Status"
					onChange = {setSingleTerm}
				/>
            </PanelRow>
			*/}
			
			<PanelRow>
                <PanelTextControl meta={props.meta} label = "District" meta_key="district" onChange={setPostMeta} />
            </PanelRow>


        </GovPackSidebarPanel>
    )
}