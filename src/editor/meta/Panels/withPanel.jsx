import { compose } from "@wordpress/compose";
import { withSelect, withDispatch, select } from "@wordpress/data";

export function withPanel(component) {

    return compose([ 
        withSelect( ( select ) => {		
            return {
                meta: select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
                type: select( 'core/editor' ).getCurrentPostType(),
            };
        }),
        withDispatch( ( dispatch ) => {
            return {
                setPostMeta( newMeta ) {
                    console.log("setPostMeta", newMeta)
                    dispatch( 'core/editor' ).editPost( { meta: newMeta } );
                },
                setTerm(taxonomy, term ) {

                    const { getTaxonomy } = select( 'core' );
                    const _taxonomy = getTaxonomy(taxonomy)

                    dispatch( 'core/editor' ).editPost( { [ _taxonomy.rest_base ]: term } );
                }

            };
        } ) 
    ])(component)
}