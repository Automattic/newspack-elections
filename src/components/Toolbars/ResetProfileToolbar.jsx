
import { __ } from '@wordpress/i18n';
import { BlockControls } from '@wordpress/block-editor';
import { Toolbar } from '@wordpress/components';
import { Icon, postAuthor} from '@wordpress/icons';


const ResetProfileToolbar = (props) => {

    const {
        setProfile,
        setAttributes,
        attributes
    } = props


    return ( 
        <BlockControls>
            <Toolbar
                controls={ [
                    {
                        icon: <Icon icon={ postAuthor } />,
                        title: __( 'Modify Selection', 'newspack-elections' ),
                        onClick: () => {
                            setAttributes( { profileId: 0 } );
                            setProfile( null );
                        },
                    },
                ] }
            />
        </BlockControls>
    )
}

export default ResetProfileToolbar