
import { compose } from "@wordpress/compose";
import { withSelect, withDispatch, select } from "@wordpress/data";
import { more } from '@wordpress/icons';
import { registerPlugin } from '@wordpress/plugins';

import {GovPackSidebarPanel} from "../../components/sidebar-panel"
import {withPanel, AboutPanel, OfficePanel, CommunicationsPanel, SocialPanel, MetadataIdsPanel} from "./Panels"
import "./view.scss"
 
import { ProfileNameToPostTitle } from "./Actions"

const ComposedAboutPanel = withPanel(AboutPanel)
const ComposedOfficePanel = withPanel(OfficePanel)
const ComposedCommunicationsPanel = withPanel(CommunicationsPanel)
const ComposedSocialPanel = withPanel(SocialPanel)
const ComposedMetadataIds = withPanel(MetadataIdsPanel)


const GovPackProfileSidebar = () => {

	return (
    <>
        <ComposedAboutPanel />
        <ComposedOfficePanel />
        <ComposedCommunicationsPanel />
		<ComposedSocialPanel />
		<ComposedMetadataIds />
    </>
	)
};

 
registerPlugin( 'profile-meta', {
    icon: more,
    render: GovPackProfileSidebar,
} );