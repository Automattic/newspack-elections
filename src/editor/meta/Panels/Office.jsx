import { PanelRow } from "@wordpress/components";

import {GovPackSidebarPanel} from "./../../../components/sidebar-panel"
import {PanelTextControl, PanelDateControl} from "./../Controls"

import {usePanel} from './usePanel'

export const OfficePanel = (props) => {

    let { setPostMeta, meta } = usePanel()

    return (
        <GovPackSidebarPanel 
            title="Office"
            name="gov-profile-office"
        >
			<PanelRow>
                <PanelDateControl meta={meta} label= "Date assumed office" meta_key="date_assumed_office" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "Appointed by" meta_key="appointed_by" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelDateControl meta={meta} label= "Date appointed" meta_key="appointed_date" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelDateControl meta={meta} label= "Date confirmed" meta_key="confirmed_date" onChange={setPostMeta}/>
            </PanelRow>
			 
			<PanelRow>
                <PanelDateControl meta={meta} label= "Date term ends" meta_key="term_end_date" onChange={setPostMeta}/>
            </PanelRow>
			{/**
			<PanelRow>
                <PanelTextControl meta={meta} label= "Congress Year/Batch" meta_key="congress_year" onChange={setPostMeta}/>
            </PanelRow>
			 */}
        </GovPackSidebarPanel>
    )
}
