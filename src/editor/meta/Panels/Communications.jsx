import { TextControl, TextareaControl, DatePicker,PanelRow, SelectControl, Spinner, Dropdown, Button, BaseControl } from "@wordpress/components";

import {GovPackSidebarPanel} from "./../../../components/sidebar-panel"
import {PanelTextControl, PanelTextareaControl, PanelDateControl, PanelFieldset} from "./../Controls"
import {usePanel} from './usePanel'

export const CommunicationsPanel = (props) => {

	
	const {meta, setPostMeta} = usePanel()

    return (
        <GovPackSidebarPanel 
            title="Communications"
            name="gov-profile-communications"
        >
			<PanelRow>
				<PanelFieldset legend="Capitol">
					<PanelTextareaControl meta={meta} label= "Address (Capitol)" meta_key="address_capitol" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} label= "Phone (Capitol)" meta_key="phone_capitol" onChange={setPostMeta}/>
                	<PanelTextControl meta={meta} label= "Email (Capitol)" meta_key="email_capitol" onChange={setPostMeta}/>
                	<PanelTextControl meta={meta} label= "Fax (Capitol)" meta_key="fax_capitol" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} label= "Website (Capitol)" meta_key="website_capitol" onChange={setPostMeta}/>
				</PanelFieldset>
            </PanelRow>
            <PanelRow>
				<PanelFieldset legend="District">
					<PanelTextareaControl meta={meta} label= "Address (District)" meta_key="address_district" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} label= "Phone (District)" meta_key="phone_district" onChange={setPostMeta}/>
                	<PanelTextControl meta={meta} label= "Email (District)" meta_key="email_district" onChange={setPostMeta}/>
                	<PanelTextControl meta={meta} label= "Fax (District)" meta_key="fax_district" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} label= "Website (District)" meta_key="website_district" onChange={setPostMeta}/>
				</PanelFieldset>
            </PanelRow>

			<PanelRow>
				<PanelFieldset legend="Campaign">
				<PanelTextareaControl meta={meta} label= "Address (Campaign)" meta_key="address_campaign" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} label= "Email (Campaign)" meta_key="email_campaign" onChange={setPostMeta}/>
                	<PanelTextControl meta={meta} label= "Phone (Campaign)" meta_key="phone_campaign" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} label= "Fax (Campaign)" meta_key="fax_campaign" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} label= "Website (Campaign)" meta_key="website_campaign" onChange={setPostMeta}/>
					
				</PanelFieldset>
            </PanelRow>
			
			<PanelRow>
				<PanelFieldset legend="Other">
					<PanelTextControl meta={meta} label="Website (Personal)" meta_key="website_personal" onChange={setPostMeta} placeholder="https://"/>
					<PanelTextControl meta={meta} label= "Email (Other)" meta_key="email_other" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} label= "RSS" meta_key="rss" onChange={setPostMeta} placeholder="https://"/>
                	<PanelTextControl meta={meta} label= "Contact Form URL" meta_key="contact_form_url" onChange={setPostMeta} placeholder="https://"/>
				</PanelFieldset>
            </PanelRow>

		

        </GovPackSidebarPanel>
    )
}