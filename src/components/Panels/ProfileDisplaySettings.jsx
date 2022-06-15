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
        showEmail,
        showSocial,
        showCapitolAddress,
		showDistrictAddress,
		showName,
        showProfileLink,
		showWebsites
        
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
							    label={ __( 'Display State', 'govpack-blocks' ) }
							    checked={ showState }
    							onChange={ () => setAttributes( { showState: ! showState } ) }
		    				/>
	    				</PanelRow>
                        <PanelRow>
						    <ToggleControl
							    label={ __( 'Display Email', 'govpack-blocks' ) }
							    checked={ showEmail }
    							onChange={ () => setAttributes( { showEmail: ! showEmail } ) }
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
							    label={ __( 'Display Capitol Addresses', 'govpack-blocks' ) }
							    checked={ showCapitolAddress }
    							onChange={ () => setAttributes( { showCapitolAddress: ! showCapitolAddress } ) }
		    				/>
	    				</PanelRow>

						<PanelRow>
						    <ToggleControl
							    label={ __( 'Display District Addresses', 'govpack-blocks' ) }
							    checked={ showDistrictAddress }
    							onChange={ () => setAttributes( { showDistrictAddress: ! showDistrictAddress } ) }
		    				/>
	    				</PanelRow>

						<PanelRow>
						    <ToggleControl
							    label={ __( 'Display Websites', 'govpack-blocks' ) }
							    checked={ showWebsites }
    							onChange={ () => setAttributes( { showWebsites: ! showWebsites } ) }
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