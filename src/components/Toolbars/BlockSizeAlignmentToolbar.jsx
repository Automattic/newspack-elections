import { __ } from '@wordpress/i18n';
import { BlockControls, BlockAlignmentControl } from '@wordpress/block-editor';
import { Toolbar, ToolbarDropdownMenu } from '@wordpress/components';
import { resizeCornerNE } from '@wordpress/icons';

const availableWidths = [
    {
        label : "Small",
        value : "small",
        maxWidth : "300px"
    },
    {
        label : "Medium",
        value : "medium",
        maxWidth : "400px"
    },
    {
        label : "Large",
        value : "large",
        maxWidth : "600px"
    },
    {
        label : "Full",
        value : "full",
        maxWidth : "100%"
    }
]


const BlockSizeAlignmentToolbar = (props) => {

    const {
        setAttributes,
        attributes
    } = props

    const {
        align
    } = attributes

    return (
        <BlockControls>
            <Toolbar>
                <BlockAlignmentControl
                    value={ align }
                    onChange={ (newAlignment) => setAttributes( { align: newAlignment } ) }
                    controls = {['left', 'center', 'right','full']}
                />
                { (align !== "full") && (
                    <ToolbarDropdownMenu
                            icon = {resizeCornerNE}
                            label = { __( 'Modify Selection', 'newspack-blocks' ) }
                            controls={ availableWidths.map( (width) => {
                                return [
                                    {
                                        title: width.label,
                                        icon: resizeCornerNE,
                                        onClick: () => setAttributes( { width: width.value } )
                                    },
                                ]
                            }) }
                    />
                )}
            </Toolbar>
        </BlockControls>
    )
}

export default BlockSizeAlignmentToolbar