import { unregisterBlockType } from '@wordpress/blocks';
import domReady from '@wordpress/dom-ready';

domReady( function () {
    
    if( 'govpack_profiles' !== unregister_profile_self_block_data.current_post_type ) {
        unregisterBlockType( 'govpack/profile-self' );
    }

} );