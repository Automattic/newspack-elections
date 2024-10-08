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
		label: /* translators: label for small avatar size option */ __( 'Small', 'govpack-blocks' ),
		shortName: /* translators: abbreviation for small avatar size option */ __(
			'S',
			'govpack-blocks'
		),
	},
	{
		value: 128,
		label: /* translators: label for medium avatar size option */ __( 'Medium', 'govpack-blocks' ),
		shortName: /* translators: abbreviation for medium avatar size option */ __(
			'M',
			'govpack-blocks'
		),
	},
	{
		value: 192,
		label: /* translators: label for large avatar size option */ __( 'Large', 'govpack-blocks' ),
		shortName: /* translators: abbreviation for large avatar size option */ __(
			'L',
			'govpack-blocks'
		),
	},
	{
		value: 256,
		label: /* translators: label for extra-large avatar size option */ __(
			'Extra-large',
			'govpack-blocks'
		),
		shortName: /* translators: abbreviation for extra-large avatar size option  */ __(
			'XL',
			'govpack-blocks'
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
					<PanelBody title={ __( 'Photo', 'govpack' ) }>
                        <PanelRow>
						    <ToggleControl
				    			label={ __( 'Display Photo', 'govpack' ) }
			    				checked={ showAvatar }
		    					onChange={ () => setAttributes( { showAvatar: ! showAvatar } ) }
	    					/>
    					</PanelRow>
                        { showAvatar && showRadiusControl && (
						<PanelRow>
							<UnitControl
								label={ __( 'Photo border radius', 'govpack' ) }
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
							label={ __( 'Photo size', 'govpack' ) }
							id="govpack__avatar-size-control"
						>
							<PanelRow>
								<ButtonGroup
									id="govpack__avatar-size-control-buttons"
									aria-label={ __( 'Avatar size', 'govpack' ) }
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