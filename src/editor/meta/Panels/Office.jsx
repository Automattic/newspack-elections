import { PanelRow } from "@wordpress/components";

import {GovPackSidebarPanel} from "./../../../components/sidebar-panel"
import {PanelTextControl, PanelTextareaControl, PanelDateControl, PanelFieldset} from "./../Controls"

export const OfficePanel = (props) => {

    let { setPostMeta } = props

    return (
        <GovPackSidebarPanel 
            title="Office"
            name="gov-profile-office"
        >
			
			<PanelRow>
                <PanelTextareaControl meta={props.meta} label= "Address (Capitol)" meta_key="address_capitol" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextareaControl meta={props.meta} label= "Address (District)" meta_key="address_district" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextareaControl meta={props.meta} label= "Address (Campaign)" meta_key="address_campaign" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Contact Form URL" meta_key="contact_form_url" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelDateControl meta={props.meta} label= "Date assumed office" meta_key="date_assumed_office" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Appointed by" meta_key="appointed_by" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelDateControl meta={props.meta} label= "Date appointed" meta_key="appointed_date" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelDateControl meta={props.meta} label= "Date confirmed" meta_key="confirmed_date" onChange={setPostMeta}/>
            </PanelRow>
			 

			<PanelRow>
                <PanelDateControl meta={props.meta} label= "Date term ends" meta_key="term_end_data" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Congress Year/Batch" meta_key="congress_year" onChange={setPostMeta}/>
            </PanelRow>

        </GovPackSidebarPanel>
    )
}
