
import { __ } from '@wordpress/i18n';
import { BlockControls } from '@wordpress/block-editor';
import { ToolbarGroup } from '@wordpress/components';
import { Icon, pullLeft, pullRight, positionCenter} from '@wordpress/icons';

const AvatarAlignmentToolBar = (props) => {

    const {
        attributes,
        setAttributes
    } = props
    
    const {
        avatarAlignment
	} = attributes;


    return(
        
            <ToolbarGroup
				label='Picture Alignment'
                controls={ [
                    {
                        icon: <Icon icon={ pullLeft } />,
                        title: __( 'Show avatar on left', 'govpack' ),
                        isActive: avatarAlignment === 'left',
                        onClick: () => setAttributes( { avatarAlignment: 'left' } ),
                    },
					{
                        icon: <Icon icon={ positionCenter } />,
                        title: __( 'Show avatar above', 'govpack' ),
                        isActive: avatarAlignment === 'center',
                        onClick: () => setAttributes( { avatarAlignment: 'center' } ),
                    },
                    {
                        icon: <Icon icon={ pullRight } />,
                        title: __( 'Show avatar on right', 'govpack' ),
                        isActive: avatarAlignment === 'right',
                        onClick: () => setAttributes( { avatarAlignment: 'right' } ),
                    },
                ] }
            />
        
    )
}

export default AvatarAlignmentToolBar