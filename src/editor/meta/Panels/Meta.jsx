import { PanelRow } from "@wordpress/components";

import { GovPackSidebarPanel } from "./../../../components/sidebar-panel"
import { PanelTextControl } from "./../Controls"
import {usePanel} from './usePanel'

export const MetadataIdsPanel = (props) => {

    let { setPostMeta, meta } = usePanel()

    return (
        <GovPackSidebarPanel 
            title="Metadata & IDS"
            name="gov-metadataids-communications"
        >
			  <PanelRow>
                <PanelTextControl meta={meta} label= "Govpack ID" meta_key="govpack_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "FEC ID" meta_key="fec_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "Bioguide ID" meta_key="usio_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "Opensecrets ID" meta_key="opensecrets_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "District OCDID" meta_key="district_ocd_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "Open States ID" meta_key="openstates_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "Thomas ID" meta_key="thomas_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "LIS ID" meta_key="lis_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "CSPAN ID" meta_key="cspan_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "Govtrack ID" meta_key="govtrack_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "VoteSmart ID" meta_key="votesmart_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "Balletpedia ID" meta_key="balletpedia_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "Washington Post ID" meta_key="washington_post_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "ICPSR ID" meta_key="icpsr_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "Wikipedia ID" meta_key="wikipedia_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "Google Entity ID" meta_key="google_entity_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label= "Candidate Committee ID" meta_key="committee_id" onChange={setPostMeta} placeholder="" />
            </PanelRow>

			


		</GovPackSidebarPanel>
	)

}