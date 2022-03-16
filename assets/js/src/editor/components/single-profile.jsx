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
import { select} from "@wordpress/data";

/**
 * External dependencies
 */
 import classnames from 'classnames';
 import { isArray, isEmpty, isUndefined, isNil } from 'lodash';



function normalize_porfile(profile){



    const featured_image = profile?._embedded?.["wp:featuredmedia"]?.[0] ?? null
    const getFromEmbedded = (tax) => {
        if(isArray(profile[tax]) && !isEmpty(profile[tax])){
            return profile[tax].map( (term) => {
                return profile._embedded?.["wp:term"]?.filter( (t) => {
                    return t?.[0]?.id === term
                })[0]
            })?.[0]?.[0]
        }
    }

	const createAddress = (type) => {

		let address = []
		address.push(profile.meta?.[type + "_office_address"] ?? null)
		address.push(profile.meta?.[type + "_office_city"] ?? null)
		address.push(profile.meta?.[type + "_office_county"] ?? null)
		address.push(profile.meta?.[type + "_office_state"] ?? null)
		address.push(profile.meta?.[type + "_office_zip"] ?? null)

		address = address.filter( (line) => ( !isNil(line) && !isEmpty(line) && ("" !== line) ) ) 


		return address.join(", ") ?? null
	}

    return {
        title : decodeEntities(profile?.title?.rendered ?? profile?.title),
        featured_image : featured_image,
        featured_image_thumbnail :  featured_image?.media_details?.sizes?.full ?? null,
        legislative_body : getFromEmbedded("govpack_legislative_body")?.name ?? null,
        position : getFromEmbedded("govpack_officeholder_title")?.name ?? null,
        state : getFromEmbedded("govpack_state")?.name ?? null,
        party : getFromEmbedded("govpack_party")?.name ?? null,
        email :  decodeEntities(profile.meta?.email ?? null),
        link :  profile.link,
        twitter :  profile.meta?.twitter,
        facebook :  profile.meta?.facebook,
        linkedin :  profile.meta?.linkedin,
        hasSocial : !!(profile.meta?.twitter ?? profile.meta?.facebook ?? profile.meta?.linkedin),
        address : (createAddress("main") ?? createAddress("secondary") ?? null),
        bio : decodeEntities(profile.excerpt?.rendered ?? profile.excerpt ?? null)
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

    let {
        profile,
        attributes,
        blockClassName,
        showSelf = false
    } = props

    profile = normalize_porfile(profile)


    const {
        showAvatar, 
        avatarBorderRadius, 
        avatarSize,
        avatarAlignment,
        align,
        width,

        showName,
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

    } = attributes

	//console.log(profile)

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
           
            <div className={`${blockClassName}__contacts`}>
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

	const maxWidth = (align !== "full" ? props.availableWidths.find( (w) => w.value === width)?.maxWidth : false)
    const excerptElement = document.createElement( 'div' );
    excerptElement.innerHTML = profile.bio;

    let bio = excerptElement.textContent || excerptElement.innerText || '';

    return (
       <div className= {classnames(`${blockClassName}__container`, {
            [`${blockClassName}__container--right`] : (avatarAlignment === "right"),
            [`${blockClassName}__container--left`] : (avatarAlignment === "left"),
            [`${blockClassName}__container--center`] : (className === "is-styled-center"),
            [`${blockClassName}__container--align-center`] : (align === "center"),
            [`${blockClassName}__container--show-self`] : showSelf,
       })}
       style = {{
           maxWidth : maxWidth ?? "none"
       }}
       >

    
            { showAvatar && profile.featured_image_thumbnail && (
				<div className={`${blockClassName}__avatar`}>
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


            
                <div className={`${blockClassName}__info`}>
                    <div className={`${blockClassName}__line`}>
                        {showName && (
                            <h3><Link>{profile.title}</Link></h3>
                        )}
                        {showBio && profile.bio && (
                            <>
                                <div>{bio}</div>
                                {showProfileLink && (
                                    <div><Link>More about {profile.title}</Link></div>
									
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