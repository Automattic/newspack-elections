import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { Fragment } from "@wordpress/element";

import { compose } from "@wordpress/compose";
import { withSelect, withDispatch } from "@wordpress/data";


const GovPackSidebarPanel = (props) => {
    return (
        <PluginDocumentSettingPanel 
            title = {props.title}
            name = {props.name}
            icon={ <Fragment /> }
        >
            {props.children}
        </PluginDocumentSettingPanel>
    )
}

export {GovPackSidebarPanel}
export default GovPackSidebarPanel