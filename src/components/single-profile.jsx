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

import FacebookIcon from "./../images/facebook.svg"
import TwitterIcon from "./../images/twitter.svg"
import LinkedinIcon from "./../images/linkedin.svg"
import EmailIcon from "./../images/email.svg"
import InstagramIcon from "./../images/instagram.svg"

/**
 * External dependencies
 */
 import classnames from 'classnames';
 import { isArray, isEmpty, isUndefined, isNil } from 'lodash';



function normalize_porfile(profile){

    const featured_image = profile?._embedded?.["wp:featuredmedia"]?.[0] ?? null
    const getFromEmbedded = (tax) => {
        if(isArray(profile[tax]) && !isEmpty(profile[tax]) && (isArray(profile._embedded?.["wp:term"]))){
            return profile[tax].map( (term) => {
                return profile._embedded?.["wp:term"]?.filter( (t) => {
                    return t?.[0]?.id === term
                })[0]
            })?.[0]?.[0]
        }
    }

	const createAddress = (type) => {

		// BUild an arry of address items that we can connect with a join(", ") to get nice formatting
		let address = []
		address.push(profile.meta?.[type + "_office_address"] ?? null)
		address.push(profile.meta?.[type + "_office_city"] ?? null)
		address.push(profile.meta?.[type + "_office_county"] ?? null)
		address.push(profile.meta?.[type + "_office_state"] ?? null)
		address.push(profile.meta?.[type + "_office_zip"] ?? null)

		if(profile.meta?.[type + "_phone"]){
			address.push("(" + profile.meta?.[type + "_phone"] + ")")
		}

		address = address.filter( (line) => ( !isNil(line) && !isEmpty(line) && ("" !== line) ) ) 
		return isEmpty(address) ? null : address.join(", ")
	}
	
    return {
        title : decodeEntities(profile?.title?.rendered ?? profile?.title),
        featured_image : featured_image,
        featured_image_thumbnail :  featured_image?.source_url ?? null,
        legislative_body : getFromEmbedded("govpack_legislative_body")?.name ?? null,
        position : getFromEmbedded("govpack_officeholder_title")?.name ?? null,
        state : getFromEmbedded("govpack_state")?.name ?? null,
        party : getFromEmbedded("govpack_party")?.name ?? null,
        email :  decodeEntities(profile.meta?.email ?? null),
        link :  profile.link,
		social : {
        	twitter :  profile.meta?.twitter,
        	facebook :  profile.meta?.facebook,
        	linkedin :  profile.meta?.linkedin,
			instagram :  profile.meta?.instagram
		},
        hasSocial : !!(profile.meta?.twitter ?? profile.meta?.facebook ?? profile.meta?.linkedin ?? profile.meta?.instagram),
		address : {
			default 	: (createAddress("main") ?? createAddress("secondary") ?? null),
			capitol 	: createAddress("main"),
			district 	: createAddress("secondary")
		},
		name : {
			full 	: [profile.meta?.first_name, profile.meta?.last_name].join(" "),
			first 	:  profile.meta?.first_name ?? null,
			last 	:  profile.meta?.last_name ?? null
		},
		websites : {
			campaign : profile.meta?.campaign_url ?? null,
			legislative : profile.meta?.leg_url ?? null,
		},
		hasWebsites : !!(profile.meta?.campaign_url ?? profile.meta?.leg_url),
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

const Link = (props) => {

	const {
		showProfileLink,
		href
	} = props

	if(!showProfileLink){
		return props.children
	}
	return (<a href="#">
	   {props.children}
	</a>)
}

const Photo = (props) => {

	const {
		display,
		href,
		blockClassName,
		avatarBorderRadius,
		avatarSize,
		LinkProps = {}
	} = props

	console.log(props)

	if(!display || !href){
		return null
	}

	return (
		
		<div className={`${blockClassName}__avatar`}>
			<Link {...LinkProps} >
				<figure
					style={ {
						borderRadius: avatarBorderRadius,
						height: `${ avatarSize }px`,
						width: `${ avatarSize }px`,
					} }
				>
					<img src={href} />
				</figure>
			</Link>
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
        showDistrictAddress,
		showCapitolAddress,
		showWebsites,
        showProfileLink,
        className

    } = attributes

	console.log(profile)

	console.log(showAvatar)


	const Websites = (props) => {
		return (
			<div className={`${blockClassName}__contacts`}>
				<ul>
				{ profile.websites.campaign && (
					<li>
						<a href={profile.websites.campaign}>Campaign Website</a>
					</li>
				)}

				{ profile.websites.legislative && (
					<li>
						<a href={profile.websites.legislative}>Legislative Website</a>
					</li>
				)}
				</ul>
			</div>
		)
    }

	const Contact = (props) => {
        return (
            <li className={classnames(`${blockClassName}__contact`, {
                [`${blockClassName}__contact--hide-label`] : true
            })}>
                <a href={props.href} className={`${blockClassName}__link`}>
                    {props.icon && (
                        <span className={`${blockClassName}__contact__icon ${blockClassName}__contact__icon`}>{props.icon}</span>
                    )}
                    <span className = {`${blockClassName}__contact__label`}>{props.label}</span>
                </a>
            </li >
        )
    }

    const Contacts = (props) => {
        return (
           
            <div className={`${blockClassName}__contacts`}>
                <ul>
                    { showEmail && (
                        <Contact 
							href={`mailto:${profile.link}`}
							label = "email"
							icon = { <EmailIcon />}
						/>
                    )}

                    { showSocial && (
                        <>
                            { profile.social.facebook && (
                                <Contact 
								 	href={profile.facebook} 
								 	label = "FB"
									icon = { <FacebookIcon />}
							 	/>
                            )}

                            { profile.social.twitter && (
                                <Contact 
									href={profile.twitter} 
									label = "Tw" 
									icon = { <TwitterIcon />}
								/>
                            )}

                            { profile.social.linkedin && (
                                <Contact 
									href={profile.linkedin} 
									label = "Li" 
									icon = { <LinkedinIcon />}
								/>
                            )}

							{ profile.social.instagram && (
                                <Contact 
									href={profile.instagram} 
									label = "In" 
									icon = { <InstagramIcon />}
								/>
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

	const showSecondaryAddress = (!isEmpty(profile.address.secondary) && (profile.address.secondary !== profile.address.default))

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

    
         
				<Photo 
					display = {showAvatar} 
					href= {profile.featured_image_thumbnail}
					avatarBorderRadius= {avatarBorderRadius}
					blockClassName = {blockClassName}
					avatarSize = {avatarSize}
					key = {"photo"}
					LinkProps = {{
						href : profile.link,
						showProfileLink : showProfileLink
					}}
				/>

            
                <div className={`${blockClassName}__info`}>
                    <div className={`${blockClassName}__line`}>
                        {showName && (
                            <h3><Link>{profile.name.full}</Link></h3>
                        )}
                        {showBio && profile.bio && (
                            <>
                                <div>{bio}</div>
                            </>
                        )}
                        
                    </div>
                    <Row key="leg_body" value={profile.legislative_body} display={showLegislativeBody}/>
                    <Row key="pos" value={profile.position}  display={showPosition}/>
                    <Row key="party" value={profile.party}  display={showParty}/>
                    <Row key="states" value={profile.state} display={showState}/>
                    <Row key="contact" value={<Contacts />} display={showEmail || (showSocial && profile.hasSocial)}/>
                    <Row key="address_district" value={profile.address.district} display={showDistrictAddress}/>
					<Row key="address_capitol" value={profile.address.capitol} display={showCapitolAddress}/>
					<Row key="website" value={<Websites />} display={showWebsites && profile.hasWebsites}/>
                    <Row key="url" value={<Link> More about {profile.title}</Link>} display={showProfileLink}/>
                </div>
            </div>  
     
    )
}

export default SingleProfile;