import {PanelRow} from "@wordpress/components";

import {GovPackSidebarPanel} from "./../../../components/sidebar-panel"
import {PanelTextControl, PanelFieldset} from "./../Controls"

import {usePanel} from './usePanel'

export const SocialPanel = (props) => {

	const {meta, setPostMeta} = usePanel()

	console.log(meta)

	return (
        <GovPackSidebarPanel 
            title="Social"
            name="gov-profile-social"
        >

			<PanelRow>
				<PanelFieldset legend={"Twitter"} >
					<PanelTextControl meta={meta} placeholder="https://" label= "X (Official)" meta_key="x_official" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} placeholder="https://" label= "X (Personal)" meta_key="x_personal" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} placeholder="https://" label= "X (Campaign)" meta_key="x_campaign" onChange={setPostMeta}/>
				</PanelFieldset>
			</PanelRow>

			<PanelRow>
				<PanelFieldset legend={"Instagram"} >
					<PanelTextControl meta={meta} placeholder="https://" label= "Instagram (Official)" meta_key="instagram_official" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} placeholder="https://" label= "Instagram (Personal)" meta_key="instagram_personal" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} placeholder="https://" label= "Instagram (Campaign)" meta_key="instagram_campaign" onChange={setPostMeta}/>
				</PanelFieldset>
			</PanelRow>

			<PanelRow>
				<PanelFieldset legend={"Facebook"} >	
					<PanelTextControl meta={meta} placeholder="https://" label= "Facebook (Official)" meta_key="facebook_official" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} placeholder="https://" label= "Facebook (Personal)" meta_key="facebook_personal" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} placeholder="https://" label= "Facebook (Campaign)" meta_key="facebook_campaign" onChange={setPostMeta}/>
				</PanelFieldset>
			</PanelRow>

			<PanelRow>
				<PanelFieldset legend={"Youtube"} >	
					<PanelTextControl meta={meta} placeholder="https://" label= "YouTube (Official)" meta_key="youtube_official" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} placeholder="https://" label= "YouTube (Personal)" meta_key="youtube_personal" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} placeholder="https://" label= "YouTube (Campaign)" meta_key="youtube_campaign" onChange={setPostMeta}/>
				</PanelFieldset>
			</PanelRow>

			<PanelRow>
				<PanelFieldset legend={"Other"} >
					<PanelTextControl meta={meta} placeholder="https://" label= "LinkedIn" meta_key="linkedin" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} placeholder="https://" label= "Rumble" meta_key="rumble" onChange={setPostMeta}/>
					<PanelTextControl meta={meta} placeholder="https://" label= "Gab" meta_key="gab" onChange={setPostMeta}/>
				</PanelFieldset>
			</PanelRow>
		</GovPackSidebarPanel>
	)
}


