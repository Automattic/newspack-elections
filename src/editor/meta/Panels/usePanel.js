import {useSelect, useDispatch} from "@wordpress/data";
import {store as editorStore} from "@wordpress/editor"
import {store as coreStore} from "@wordpress/core-data"

export const usePanel = () => {

	const req = useSelect( (select) => {
		const postType = select( editorStore ).getCurrentPostType()
		const postId = select( editorStore ).getCurrentPostId()
		return { 
			meta :select( coreStore ).getEditedEntityRecord('postType', postType, postId)?.meta ?? {}, 
			postId,
			postType
		}
	} )

	const {editPost} = useDispatch("core/editor");
	const setPostMeta = (newMeta) => {
		editPost( { meta: newMeta } )
	}

	const setTerm = async (taxonomy, term ) => {

		const _taxonomy = await useSelect( (select) => {
			return select(coreStore).getTaxonomy(taxonomy)
		});

		editPost( { [ _taxonomy.rest_base ]: term } );
	}

	return {
		...req,
		setPostMeta,
		setTerm
	}
}

export default usePanel