import { PanelRow } from "@wordpress/components";

import { GovPackSidebarPanel } from "./../../../components/sidebar-panel"
import { PanelTextControl } from "./../Controls"

export const MetadataIdsPanel = (props) => {

    let { setPostMeta } = props

    return (
        <GovPackSidebarPanel 
            title="Metadata & IDS"
            name="gov-metadataids-communications"
        >
			  <PanelRow>
                <PanelTextControl meta={props.meta} label= "Govpack ID" meta_key="govpack_id" onChange={setPostMeta} placeholder="" disabled/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "FEC ID" meta_key="fec_ids" onChange={setPostMeta} placeholder="" disabled/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "US.IO ID" meta_key="usio_id" onChange={setPostMeta} placeholder="" disabled/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Opensecrets ID" meta_key="opensecrets_id" onChange={setPostMeta} placeholder="" disabled/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "District OCDID" meta_key="district_ocd_ic" onChange={setPostMeta} placeholder="" disabled/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Open States ID" meta_key="openstates_id" onChange={setPostMeta} placeholder="" disabled/>
            </PanelRow>

		</GovPackSidebarPanel>
	)

}