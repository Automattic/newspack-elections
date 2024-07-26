import { more } from '@wordpress/icons';
import { registerPlugin } from '@wordpress/plugins';
import {AboutPanel, OfficePanel, CommunicationsPanel, SocialPanel, MetadataIdsPanel} from "./Panels"
import "./view.scss"
 
const GovPackProfileSidebar = () => (
    <>
        <AboutPanel />
        <OfficePanel />
        <CommunicationsPanel />
		<SocialPanel />
		<MetadataIdsPanel />
    </>
)

 
registerPlugin( 'profile-meta', {
    icon: more,
    render: GovPackProfileSidebar,
} );