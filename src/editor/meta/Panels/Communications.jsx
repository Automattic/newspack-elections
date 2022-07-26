import { TextControl, TextareaControl, DatePicker,PanelRow, SelectControl, Spinner, Dropdown, Button, BaseControl } from "@wordpress/components";

import {GovPackSidebarPanel} from "./../../../components/sidebar-panel"
import {PanelTextControl, PanelTextareaControl, PanelDateControl, PanelFieldset} from "./../Controls"


export const CommunicationsPanel = (props) => {

    let { setPostMeta } = props

    return (
        <GovPackSidebarPanel 
            title="Communications"
            name="gov-profile-communications"
        >
        
        
            <PanelRow>
				<PanelFieldset legend="Email">
                	<PanelTextControl meta={props.meta} label= "Email (Official)" meta_key="email_official" onChange={setPostMeta}/>
                	<PanelTextControl meta={props.meta} label= "Email (Campaign)" meta_key="email_campaign" onChange={setPostMeta}/>
                	<PanelTextControl meta={props.meta} label= "Email (Other)" meta_key="email_other" onChange={setPostMeta}/>
				</PanelFieldset>
            </PanelRow>

			<PanelRow>
				<PanelFieldset legend="Phone">
                	<PanelTextControl meta={props.meta} label= "Phone (District)" meta_key="phone_district" onChange={setPostMeta}/>
                	<PanelTextControl meta={props.meta} label= "Phone (Campaign)" meta_key="phone_campaign" onChange={setPostMeta}/>
				</PanelFieldset>
            </PanelRow>
			
			<PanelRow>
				<PanelFieldset legend="Fax">
                	<PanelTextControl meta={props.meta} label= "Fax (District)" meta_key="fax_district" onChange={setPostMeta}/>
                	<PanelTextControl meta={props.meta} label= "Fax (Campaign)" meta_key="fax_campaign" onChange={setPostMeta}/>
				</PanelFieldset>
            </PanelRow>

			<PanelRow>
				<PanelFieldset legend="Web">
                	<PanelTextControl meta={props.meta} label="Website (Personal)" meta_key="website_personal" onChange={setPostMeta} placeholder="https://"/>
                	<PanelTextControl meta={props.meta} label="Website (Campaign)" meta_key="website_campaign" onChange={setPostMeta} placeholder="https://"/>
                	<PanelTextControl meta={props.meta} label="Website (Legislative)" meta_key="website_legislative" onChange={setPostMeta} placeholder="https://"/>
                	<PanelTextControl meta={props.meta} label= "RSS" meta_key="rss" onChange={setPostMeta}/>
				</PanelFieldset>
            </PanelRow>

        </GovPackSidebarPanel>
    )
}