import { subscribe, select } from '@wordpress/data';

let unsub = null;
let lastRunValue = "";

const subscribeToCoreData = (action) => {
	
	return subscribe( ( ) => {
		let meta = select('core/editor').getEditedPostAttribute("meta")
		let value = meta.name
		if(value !== lastRunValue){

		}
	} );
} 

const updateTitle = (value) => {
	const { editPost } = useDispatch('core/editor')
	editPost({})
}

export const ProfileNameToPostTitle = () => {
	if(!unsub){
		unsub = subscribeToCoreData(updateTitle)
	}

	console.log(unsub)
}