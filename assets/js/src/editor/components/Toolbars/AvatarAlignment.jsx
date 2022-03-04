
import { __ } from '@wordpress/i18n';
import { BlockControls } from '@wordpress/block-editor';
import { Toolbar } from '@wordpress/components';
import { Icon, pullLeft, pullRight} from '@wordpress/icons';

const AvatarAlignmentToolBar = (props) => {

    const {
        attributes,
        setAttributes
    } = props
    
    const {
        avatarAlignment
	} = attributes;


    return(
        <BlockControls>
            <Toolbar
                controls={ [
                    {
                        icon: <Icon icon={ pullLeft } />,
                        title: __( 'Show avatar on left', 'newspack-blocks' ),
                        isActive: avatarAlignment === 'left',
                        onClick: () => setAttributes( { avatarAlignment: 'left' } ),
                    },
                    {
                        icon: <Icon icon={ pullRight } />,
                        title: __( 'Show avatar on right', 'newspack-blocks' ),
                        isActive: avatarAlignment === 'right',
                        onClick: () => setAttributes( { avatarAlignment: 'right' } ),
                    },
                ] }
            />
        </BlockControls>
    )
}

export default AvatarAlignmentToolBar