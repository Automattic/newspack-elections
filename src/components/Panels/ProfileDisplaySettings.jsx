import { __ } from '@wordpress/i18n';
import {Panel, PanelBody, PanelRow, ToggleControl} from '@wordpress/components';


const ProfileDisplaySettings = (props) => {

    const {
        attributes,
        setAttributes,
        showBioControl = true,
        showLinkControl = true,
		profile
    } = props

    const {
        showBio,
		showLabels,
        showAge,
        showLegislativeBody,
        showPosition,
        showParty,
        showState,
		showDistrict,
		showStatus,
		showStatusTag,
		showOtherLinks,

        showSocial,
		showName,
        showProfileLink,

		showCapitolCommunicationDetails,
		showDistrictCommunicationDetails,
		showCampaignCommunicationDetails,
		showOtherCommunicationDetails,

    } = attributes

	const disableAgeToggle = _.isEmpty(profile?.meta?.date_of_birth)

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
							label={ __( 'Display Status Tag', 'govpack-blocks' ) }
							checked={ showStatusTag }
							onChange={ () => setAttributes( { showStatusTag: ! showStatusTag } ) }
						/>
					</PanelRow>
				<PanelRow>
					
					<ToggleControl
						label={ __( 'Display Age', 'govpack-blocks' ) }
						checked={ showAge }
						onChange={ () => setAttributes( { showAge: ! showAge } ) }
						disabled = {disableAgeToggle}
						help = { (disableAgeToggle) ? "Date of Birth Required" : null}
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
						label={ __( 'Display District', 'govpack-blocks' ) }
						checked={ showDistrict }
						onChange={ () => setAttributes( { showDistrict: ! showDistrict } ) }
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

				<PanelRow>
					<ToggleControl
						label={ __( 'Display Other Links', 'govpack-blocks' ) }
						checked={ showOtherLinks }
						onChange={ () => setAttributes( { showOtherLinks: ! showOtherLinks } ) }
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
