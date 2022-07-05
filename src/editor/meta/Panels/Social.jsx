import { TextControl, TextareaControl, DatePicker,PanelRow, SelectControl, Spinner, Dropdown, Button, BaseControl } from "@wordpress/components";

import {GovPackSidebarPanel} from "./../../../components/sidebar-panel"
import {PanelTextControl, PanelTextareaControl, PanelDatePickerControl, PanelFieldset} from "./../Controls"

export const SocialPanel = (props) => {

	let { setPostMeta } = props

	return (
        <GovPackSidebarPanel 
            title="Social"
            name="gov-profile-social"
        >

			<PanelRow>
				<PanelFieldset legend={"Twitter"} >
					<PanelTextControl meta={props.meta} label= "Twitter (Official)" meta_key="twitter_official" onChange={setPostMeta}/>
					<PanelTextControl meta={props.meta} label= "Twitter (Personal)" meta_key="twitter_personal" onChange={setPostMeta}/>
					<PanelTextControl meta={props.meta} label= "Twitter (Campaign)" meta_key="twitter_campaign" onChange={setPostMeta}/>
				</PanelFieldset>
			</PanelRow>

			<PanelRow>
				<PanelFieldset legend={"Instagram"} >
					<PanelTextControl meta={props.meta} label= "Instagram (Official)" meta_key="Instagram_official" onChange={setPostMeta}/>
					<PanelTextControl meta={props.meta} label= "Instagram (Personal)" meta_key="Instagram_personal" onChange={setPostMeta}/>
					<PanelTextControl meta={props.meta} label= "Instagram (Campaign)" meta_key="Instagram_campaign" onChange={setPostMeta}/>
				</PanelFieldset>
			</PanelRow>

			<PanelRow>
				<PanelFieldset legend={"Facebook"} >	
					<PanelTextControl meta={props.meta} label= "Facebook (Official)" meta_key="facebook_official" onChange={setPostMeta}/>
					<PanelTextControl meta={props.meta} label= "Facebook (Personal)" meta_key="facebook_personal" onChange={setPostMeta}/>
					<PanelTextControl meta={props.meta} label= "Facebook (Campaign)" meta_key="facebook_campaign" onChange={setPostMeta}/>
				</PanelFieldset>
			</PanelRow>

			<PanelRow>
				<PanelFieldset legend={"LinkedIn"} >
					<PanelTextControl meta={props.meta} label= "LinkedIn" meta_key="linkedin" onChange={setPostMeta}/>
				</PanelFieldset>
			</PanelRow>
		</GovPackSidebarPanel>
	)
}


