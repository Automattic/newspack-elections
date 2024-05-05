import { PanelRow } from "@wordpress/components";

import {GovPackSidebarPanel} from "./../../../components/sidebar-panel"

import {usePanel} from './usePanel'

export const PositionPanel = (props) => {

	const {meta, setPostMeta, setTerm} = usePanel()

    return (
        <GovPackSidebarPanel 
            title="Position"
            name="gov-profile-position"
        >
        
          
            <PanelRow>
                <PanelSelectControl options = {Object.keys(titles).map( (key) => {
                   return {
                    value : key,
                    label : titles[key]
                   }
                    } )} label = "Title" meta_key="title" onChange={setPostMeta} />
                </PanelRow>

            <PanelRow>
                <PanelTaxonomyControl 
                    meta={props.meta} 
                    label = "Legislative Body" 
                    taxonomy="govpack_legislative_body" 
                    onChange={setTerm}
                />
            </PanelRow>

            <PanelRow>
                <PanelTaxonomyControl 
                    meta={props.meta} 
                    label = "State" 
                    taxonomy="govpack_state" 
                    onChange={setTerm}
                />
            </PanelRow>

           

            <PanelRow>
                <PanelSelectControl 
                    meta={props.meta} 
                    label = "County" 
                    taxonomy="govpack_county" 
                    onChange={setTerm}
                />
            </PanelRow>

        </GovPackSidebarPanel>
    )
}