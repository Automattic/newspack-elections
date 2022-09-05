import { __ } from '@wordpress/i18n';
import {Panel, PanelBody, PanelRow, ToggleControl} from '@wordpress/components';


const ProfileDisplaySettings = (props) => {

    const {
        attributes,
        setAttributes,
        showBioControl = true,
        showLinkControl = true,
    } = props

    const {
        showBio,
        showLegislativeBody,
        showPosition,
        showParty,
        showState,
		showStatus,

        showSocial,
		showName,
        showProfileLink,

		showCapitolCommunicationDetails,
		showDistrictCommunicationDetails,
		showCampaignCommunicationDetails,
		showOtherCommunicationDetails,

    } = attributes

    return (
        <Panel>
                    <PanelBody title={ __( 'Govpack Profile Settings', 'govpack' ) }>
                        {showBioControl && (
                            <PanelRow>
                                <ToggleControl
                                    label={ __( 'Display Bio', 'govpack-blocks' ) }
                                    checked={ showBio }
                                    onChange={ () => setAttributes( { showBio: ! showBio } ) }
                                />
                            </PanelRow>
                        )}
						<PanelRow>
                                <ToggleControl
                                    label={ __( 'Display Name', 'govpack-blocks' ) }
                                    checked={ showName }
                                    onChange={ () => setAttributes( { showName: ! showName } ) }
                                />
                            </PanelRow>
                        <PanelRow>
						    <ToggleControl
							    label={ __( 'Display Legistlative Body', 'govpack-blocks' ) }
							    checked={ showLegislativeBody }
    							onChange={ () => setAttributes( { showLegislativeBody: ! showLegislativeBody } ) }
		    				/>
	    				</PanelRow>

                        <PanelRow>
						    <ToggleControl
							    label={ __( 'Display Position', 'govpack-blocks' ) }
							    checked={ showPosition }
    							onChange={ () => setAttributes( { showPosition: ! showPosition } ) }
		    				/>
	    				</PanelRow>
                        
                        <PanelRow>
						    <ToggleControl
							    label={ __( 'Display Party', 'govpack-blocks' ) }
							    checked={ showParty }
    							onChange={ () => setAttributes( { showParty: ! showParty } ) }
		    				/>
	    				</PanelRow>
						<PanelRow>
						    <ToggleControl
							    label={ __( 'Display Status', 'govpack-blocks' ) }
							    checked={ showParty }
    							onChange={ () => setAttributes( { showStatus: ! showStatus } ) }
		    				/>
	    				</PanelRow>
                        <PanelRow>
						    <ToggleControl
							    label={ __( 'Display State', 'govpack-blocks' ) }
							    checked={ showState }
    							onChange={ () => setAttributes( { showState: ! showState } ) }
		    				/>
	    				</PanelRow>
                        
                        <PanelRow>
						    <ToggleControl
							    label={ __( 'Display Social', 'govpack-blocks' ) }
							    checked={ showSocial }
    							onChange={ () => setAttributes( { showSocial: ! showSocial } ) }
		    				/>
	    				</PanelRow>

						<PanelRow>
						    <ToggleControl
							    label={ __( 'Display Capitol Communications', 'govpack-blocks' ) }
							    checked={ showCapitolCommunicationDetails }
    							onChange={ () => setAttributes( { showCapitolCommunicationDetails: ! showCapitolCommunicationDetails } ) }
		    				/>
	    				</PanelRow>

						<PanelRow>
						    <ToggleControl
							    label={ __( 'Display District Communication', 'govpack-blocks' ) }
							    checked={ showDistrictCommunicationDetails }
    							onChange={ () => setAttributes( { showDistrictCommunicationDetails: ! showDistrictCommunicationDetails } ) }
		    				/>
	    				</PanelRow>

						<PanelRow>
						    <ToggleControl
							    label={ __( 'Display Campaign Communication', 'govpack-blocks' ) }
							    checked={ showCampaignCommunicationDetails }
    							onChange={ () => setAttributes( { showCampaignCommunicationDetails: ! showCampaignCommunicationDetails } ) }
		    				/>
	    				</PanelRow>

						<PanelRow>
						    <ToggleControl
							    label={ __( 'Display Other Communication', 'govpack-blocks' ) }
							    checked={ showOtherCommunicationDetails }
    							onChange={ () => setAttributes( { showOtherCommunicationDetails: ! showOtherCommunicationDetails } ) }
		    				/>
	    				</PanelRow>

                        {showLinkControl && (
                            <PanelRow>
						        <ToggleControl
							        label={ __( 'Include Link to Profile Page', 'govpack-blocks' ) }
							        checked={ showProfileLink }
    							    onChange={ () => setAttributes( { showProfileLink: ! showProfileLink } ) }
		    				    />
	    				    </PanelRow>
                        )}

                    </PanelBody>
                </Panel>
    )
}

export default ProfileDisplaySettings