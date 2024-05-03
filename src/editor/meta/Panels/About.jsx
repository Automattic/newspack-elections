import { PanelRow } from "@wordpress/components";
import { useDispatch, useSelect } from '@wordpress/data';

import {GovPackSidebarPanel} from "./../../../components/sidebar-panel"
import {PanelTextControl, PanelDateControl, PanelFieldset, PanelTaxonomyControl} from "./../Controls"


const changeContributesToName = (change) => {

	let keys = Object.keys(change)

	if(keys.length === 0){
		return false
	}
	let searchKeys = ["name_prefix", "name_first", "name_middle", "name_last", "name_suffix"]
	let intersection = keys.filter( i => searchKeys.includes(i) )

	if(intersection.length > 0){
		return true;
	}

	return false;
}

const getNamePieces = (meta, change) => {
	let {
		name_prefix = null, 
		name_first  = null, 
		name_middle = null, 
		name_last   = null, 
		name_suffix = null
	} = meta 

	let pieces = {
		"name_prefix" : name_prefix,
		"name_first"  : name_first,
		"name_middle" : name_middle,
		"name_last"   : name_last,
		"name_suffix" : name_suffix,
	}

	let changeKey = Object.keys(change).at(0)
	pieces[changeKey] = change[changeKey]

	return pieces

}

const assembleName = (pieces) => {
	return Object.values(pieces).join(" ").trim()
}


export const AboutPanel = (props) => {

	let {editPost} = useDispatch("core/editor")
	const {postTitle, postIsNew, postEdits} = useSelect( (select) => {
		return {
			postTitle: select("core/editor").getEditedPostAttribute("title"),
			postIsNew: select("core/editor").isEditedPostNew(),
			postEdits: select("core/editor").getPostEdits()
		}
	})

	let { setPostMeta, setTerm, setSingleTerm, meta } = props

	const shouldUpdateTitle = (newPostTitle) => {

		//console.log(postEdits)

		if(!postIsNew){
			return false;
		}

		if(newPostTitle === postTitle){
			return false;
		}

		return true;
	}

	const updateMetaAndName = (change) => {
		
		if(changeContributesToName(change)){
			let namePieces = getNamePieces(meta, change)
			let name = assembleName(namePieces)

			let newChange = {
				name : name,
				...change
			}

			if(shouldUpdateTitle(name)){
				editPost({ "title" : name })
			}

			setPostMeta(newChange)

		} else {
			setPostMeta(change)
		}
	}

    return (
        <GovPackSidebarPanel 
            title="About"
            name="gov-profile-about"
        >
			<PanelRow>
                <PanelTextControl 
					meta={meta} label = "Name" meta_key="name" onChange={setPostMeta} 
					disabled 
					help = "Assembed from name piece fields below."
					/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Prefix" meta_key="name_prefix" onChange={setPostMeta} />
            </PanelRow>

            <PanelRow>
                <PanelTextControl meta={meta} label = "First Name" meta_key="name_first" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Middle Name" meta_key="name_middle" onChange={setPostMeta} />
            </PanelRow>

            <PanelRow>
                <PanelTextControl meta={meta} label = "Last Name" meta_key="name_last" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Suffix" meta_key="name_suffix" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Nickname" meta_key="nickname" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Occupation" meta_key="occupation" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Education" meta_key="education" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Gender" meta_key="gender" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Race" meta_key="race" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "Ethnicity" meta_key="ethnicity" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelDateControl meta={meta} label = "Date of Birth" meta_key="date_of_birth" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelDateControl meta={meta} label = "Date of Death" meta_key="date_of_death" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={meta} label = "District" meta_key="district" onChange={setPostMeta} />
            </PanelRow>


        </GovPackSidebarPanel>
    )
}