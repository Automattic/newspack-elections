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


/**
 * External dependencies
 */
 import classnames from 'classnames';
 import { isArray, isEmpty } from 'lodash';


function normalize_porfile(profile){

    console.log(profile)

    const featured_image = profile?._embedded?.["wp:featuredmedia"][0] ?? null

   

    const getFromEmbedded = (tax) => {

        if(isArray(profile[tax]) && !isEmpty(profile[tax])){
            return profile[tax].map( (term) => {
                return profile._embedded["wp:term"].filter( (t) => {
                    return t?.[0]?.id === term
                })[0]
            })[0][0]
        }
    }

    return {
        title : decodeEntities(profile.title.rendered),
        featured_image : featured_image,
        featured_image_thumbnail : featured_image?.media_details.sizes?.thumbnail ?? featured_image?.media_details.sizes?.full ?? null,
        legislative_body : getFromEmbedded("govpack_legislative_body")?.name ?? null,
        position : getFromEmbedded("govpack_officeholder_title")?.name ?? null,
        state : getFromEmbedded("govpack_state")?.name ?? null,
        party : getFromEmbedded("govpack_party")?.name ?? null,
        email :  decodeEntities(profile.meta.email ?? null),
        link :  profile.link,
        twitter :  profile.meta.twitter,
        facebook :  profile.meta.facebook,
        linkedin :  profile.meta.linkedin,
        hasSocial : !!(profile.meta.twitter ?? profile.meta.facebook ?? profile.meta.linkedin),
        address : (profile.meta.main_office_address ?? profile.meta.secondary_office_address ?? null),
        bio : decodeEntities(profile.excerpt.rendered)
    }
}

const Row = (props) => {

    const {display, value} = props

    if(!display){
        return null
    }

    if(!value){
        return null
    }

    return (
        <div className="wp-block-govpack-profile__line">
            {value}
        </div>
    )
}

const SingleProfile = (props) => {

    let profile = normalize_porfile(props.profile)

    const {
        showAvatar, 
        avatarBorderRadius, 
        avatarSize,
        avatarAlignment,

        showBio,
        showLegislativeBody,
        showPosition,
        showParty,
        showState,
        showEmail,
        showSocial,
        showAddress,
        showProfileLink,
        className


    } = props.attributes

    console.log(profile)

    const Link = (props) => {

        if(!showProfileLink){
            return props.children
        }

        return (<a href={profile.link}>
           {props.children}
        </a>)
    }

    const Contacts = (props) => {
        return (
           
            <div className="wp-block-govpack-profile__contacts">
                <ul>
                    { showEmail && (
                        <li>
                            <a href={`mailto:${profile.link}`}>em</a>
                        </li>
                    )}

                    { showSocial && (
                        <>
                            { profile.facebook && (
                                <li>
                                    <a href={profile.facebook}>fb</a>
                                </li>
                            )}

                            { profile.twitter && (
                                <li>
                                    <a href={profile.twitter}>tw</a>
                                </li>
                            )}

                            { profile.linkedin && (
                                <li>
                                    <a href={profile.linkedin}>li</a>
                                </li>
                            )}
                        </>
                    )}
                </ul>
            </div>
        )
    }

    const excerptElement = document.createElement( 'div' );
    excerptElement.innerHTML = profile.bio;

    let bio =
        excerptElement.textContent ||
        excerptElement.innerText ||
        '';

    return (
       <div className= {classnames("wp-block-govpack-profile__container", {
            "wp-block-govpack-profile__container--right" : (avatarAlignment === "right"),
            "wp-block-govpack-profile__container--left" : (avatarAlignment === "left"),
            "wp-block-govpack-profile__container--center" : (className === "is-styled-center"),
       })}>

    
            { showAvatar && profile.featured_image_thumbnail && (
				<div className="wp-block-govpack-profile__avatar">
                    <Link>
                        <figure
                            style={ {
                                borderRadius: avatarBorderRadius,
                                height: `${ avatarSize }px`,
                                width: `${ avatarSize }px`,
                            } }
                        >
                            <img src={profile.featured_image_thumbnail.source_url} />
                        </figure>
                    </Link>
				</div>
			) }


            
                <div className="wp-block-govpack-profile__info">
                    <div className="wp-block-govpack-profile__line">
                        <h3><Link>{profile.title}</Link></h3>
                        {showBio && profile.bio && (
                            <>
                                {bio}
                                {showProfileLink && (
                                    <Link>More about {profile.title}</Link>
                                )}
                            </>
                        )}
                        
                    </div>
                    <Row value={profile.legislative_body} display={showLegislativeBody}/>
                    <Row value={profile.position}  display={showPosition}/>
                    <Row value={profile.party}  display={showParty}/>
                    <Row value={profile.state} display={showState}/>
                    <Row value={<Contacts />} display={showEmail || (showSocial && profile.hasSocial)}/>
                    <Row value={profile.address} display={showAddress}/>
                    <Row value={<Link> More about {profile.title}</Link>} display={showProfileLink}/>
                </div>
            </div>  
     
    )
}

export default SingleProfile;