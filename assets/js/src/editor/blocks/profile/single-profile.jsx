import { 
    Button, 
    FormFileUpload, 
    __experimentalHStack as HStack,
    __experimentalVStack as VStack,
    __experimentalSurface as Surface,
    __experimentalSpacer as Spacer,
    __experimentalHeading as Heading,
    Spinner,
    SelectControl
} from '@wordpress/components';

import { decodeEntities } from '@wordpress/html-entities';


function normalize_porfile(profile){

    const featured_image = profile?._embedded?.["wp:featuredmedia"][0] ?? null

    return {
        title : decodeEntities(profile.title.rendered),
        featured_image : featured_image,
        featured_image_thumbnail : featured_image?.media_details.sizes?.thumbnail ?? featured_image?.media_details.sizes?.full ?? null
    }
}

const SingleProfile = (props) => {

    let profile = normalize_porfile(props.profile)

    const {showAvatar, avatarBorderRadius, avatarSize} = props.attributes

    console.log(profile)

    return (
        <HStack alignment="left">

    
            { showAvatar && profile.featured_image_thumbnail && (
				<div className="wp-block-govpack-profile__avatar">
					<figure
						style={ {
							borderRadius: avatarBorderRadius,
							height: `${ avatarSize }px`,
							width: `${ avatarSize }px`,
						} }
					>
                        <img src={profile.featured_image_thumbnail.source_url} />
                    </figure>
				</div>
			) }


            <div>
                Profile {profile.title}
            </div>  
        </HStack>
    )
}

export default SingleProfile;