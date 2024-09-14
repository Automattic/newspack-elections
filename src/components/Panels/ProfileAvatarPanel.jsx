import { __ } from '@wordpress/i18n';
import {Panel, PanelBody, PanelRow, ToggleControl, BaseControl, ButtonGroup, Button} from '@wordpress/components';
import {__experimentalUnitControl as UnitControl} from '@wordpress/components';

// Available units for avatarBorderRadius option.
const units = [
	{
		value: '%',
		label: '%',
	},
	{
		value: 'px',
		label: 'px',
	},
	{
		value: 'em',
		label: 'em',
	},
	{
		value: 'rem',
		label: 'rem',
	},
];

// Avatar size options.
export const avatarSizeOptions = [
	{
		value: 72,
		label: /* translators: label for small avatar size option */ __( 'Small', 'newspack-elections' ),
		shortName: /* translators: abbreviation for small avatar size option */ __(
			'S',
			'newspack-elections'
		),
	},
	{
		value: 128,
		label: /* translators: label for medium avatar size option */ __( 'Medium', 'newspack-elections' ),
		shortName: /* translators: abbreviation for medium avatar size option */ __(
			'M',
			'newspack-elections'
		),
	},
	{
		value: 192,
		label: /* translators: label for large avatar size option */ __( 'Large', 'newspack-elections' ),
		shortName: /* translators: abbreviation for large avatar size option */ __(
			'L',
			'newspack-elections'
		),
	},
	{
		value: 256,
		label: /* translators: label for extra-large avatar size option */ __(
			'Extra-large',
			'newspack-elections'
		),
		shortName: /* translators: abbreviation for extra-large avatar size option  */ __(
			'XL',
			'newspack-elections'
		),
	},
];

const ProfileAvatarPanel = (props) => {

    const {
        attributes,
        setAttributes,
        showSizeControl = true,
        showRadiusControl = true
    } = props

    const {
        showAvatar,
        avatarBorderRadius,
        avatarSize,
        avatarAlignment
    } = attributes

    return (
                <Panel>
					<PanelBody title={ __( 'Photo', 'newspack-elections' ) }>
                        <PanelRow>
						    <ToggleControl
				    			label={ __( 'Display Photo', 'newspack-elections' ) }
			    				checked={ showAvatar }
		    					onChange={ () => setAttributes( { showAvatar: ! showAvatar } ) }
	    					/>
    					</PanelRow>
                        { showAvatar && showRadiusControl && (
						<PanelRow>
							<UnitControl
								label={ __( 'Photo border radius', 'newspack-elections' ) }
								labelPosition="edge"
								__unstableInputWidth="80px"
								units={ units }
								value={ avatarBorderRadius }
								onChange={ value =>
									setAttributes( { avatarBorderRadius: 0 > parseFloat( value ) ? '0' : value } )
								}
							/>
						</PanelRow>
					) }
                    { showAvatar && showSizeControl &&(
						<BaseControl
							label={ __( 'Photo size', 'newspack-elections' ) }
							id="govpack__avatar-size-control"
						>
							<PanelRow>
								<ButtonGroup
									id="govpack__avatar-size-control-buttons"
									aria-label={ __( 'Avatar size', 'newspack-elections' ) }
								>
									{ avatarSizeOptions.map( option => {
										const isCurrent = avatarSize === option.value;
										return (
											<Button
												isPrimary={ isCurrent }
												aria-pressed={ isCurrent }
												aria-label={ option.label }
												key={ option.value }
												onClick={ () => setAttributes( { avatarSize: option.value } ) }
											>
												{ option.shortName }
											</Button>
										);
									} ) }
								</ButtonGroup>
							</PanelRow>
						</BaseControl>
					) }
                    </PanelBody>
                </Panel>
    )
}

export default ProfileAvatarPanel