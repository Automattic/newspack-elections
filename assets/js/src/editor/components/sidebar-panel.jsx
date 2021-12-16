import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { Fragment } from "@wordpress/element";

import { compose } from "@wordpress/compose";
import { withSelect, withDispatch } from "@wordpress/data";


const RawGovPackSidebarPanel = (props) => {
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

const GovPackSidebarPanel = compose( [
	withSelect( ( select ) => {		
		return {
			meta: select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
			type: select( 'core/editor' ).getCurrentPostType(),
		};
	} ),
	withDispatch( ( dispatch ) => {
		return {
			setPostMeta( newMeta ) {
				dispatch( 'core/editor' ).editPost( { meta: newMeta } );
			}
		};
	} )
] )(RawGovPackSidebarPanel);

export {GovPackSidebarPanel}
export default GovPackSidebarPanel