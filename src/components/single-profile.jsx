import { decodeEntities } from '@wordpress/html-entities';


import FacebookIcon from "./../images/facebook.svg"
import TwitterIcon from "./../images/twitter.svg"
import LinkedinIcon from "./../images/linkedin.svg"
import EmailIcon from "./../images/email.svg"
import InstagramIcon from "./../images/instagram.svg"
import PhoneIcon from "./../images/phone.svg"
import WebIcon from "./../images/globe.svg"
import FaxIcon from "./../images/fax.svg"

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
			default 	: (createAddress("capitol") ?? createAddress("district") ?? null),
			capitol 	: createAddress("capitol"),
			district 	: createAddress("district")
		},
		name : {
			name 	: profile.meta?.name,
			full 	: [
				profile.meta?.name_prefix, 
				profile.meta?.name_first,
				profile.meta?.name_middle, 
				profile.meta?.name_last,
				profile.meta?.name_suffix,
			].join(" "),
			first 	:  profile.meta?.first_name ?? null,
			last 	:  profile.meta?.last_name ?? null
		},
		websites : {
			campaign : profile.meta?.campaign_url ?? null,
			legislative : profile.meta?.leg_url ?? null,
		},
		hasWebsites : !!(profile.meta?.campaign_url ?? profile.meta?.leg_url),
        bio : decodeEntities(profile.excerpt?.rendered ?? profile.excerpt ?? null),
		comms : {
			capitol : {
				email : profile.meta?.email_capitol,
				phone : profile.meta?.phone_capitol,
				fax : profile.meta?.fax_capitol,
				address : profile.meta?.address_capitol,
				website : profile.meta?.website_capitol,
			},
			district : {
				email : profile.meta?.email_district,
				phone : profile.meta?.phone_district,
				fax : profile.meta?.fax_district,
				address : profile.meta?.address_district,
				website : profile.meta?.website_district,
			},
			campaign : {
				email : profile.meta?.email_campaign,
				phone : profile.meta?.phone_campaign,
				fax : profile.meta?.fax_campaign,
				address : profile.meta?.address_campaign,
				website : profile.meta?.website_campaign,
			},
			other : {
				email_other :  profile.meta?.email_other,
				rss :  profile.meta?.rss,
				contact_form_url :  profile.meta?.contact_form_url,
			}
		}
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
        className,

		showCapitolCommunicationDetails,
		showDistrictCommunicationDetails,
		showCampaignCommunicationDetails,
		showOtherCommunicationDetails,

		selectedCapitolCommunicationDetails,
		selectedDistrictCommunicationDetails,
		selectedCampaignCommunicationDetails,
		selectedOtherCommunicationDetails,

    } = attributes


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
                <a href={props.href} className={`${blockClassName}__link`} title={props.tooltip ?? props.label ?? ""}>
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


	const Comms = (props) => {

		const {
			label = "Comms"
		} = props


		return (
			<div className={`${blockClassName}__comms`}>
				<div className={`${blockClassName}__comms-label`}>{label}:</div>
				
				{props.data && (<>
					<ul className={`${blockClassName}__comms-icons`}>
						{ props.data.phone && props.show.showPhone && (
                                <Contact 
									href={`tel:${props.data.phone}`} 
									tooltip = {`${label} Phone : ${props.data.phone}`} 
									label = "Phone"  
									icon = { <PhoneIcon />}
								/>
								
                            )}
						
						{ props.data.fax && props.show.showFax &&(
                                <Contact 
									href={`tel:${props.data.fax}`} 
									tooltip = {`${label} Fax : ${props.data.fax}`} 
									label = "Fax" 
									icon = { <FaxIcon />}
								/>
								
                            )}

						{ props.data.email && props.show.showEmail &&(
                                <Contact 
									href={`tel:${props.data.email}`} 
									tooltip = {`${label} Email : ${props.data.email}`} 
									label = "Email" 
									icon = { <EmailIcon />}
								/>
								
                        )}

						{ props.data.website && props.show.showWebsite &&(
                                <Contact 
									href={props.data.website} 
									tooltip = {`${label} Website : ${props.data.website}`} 
									label = "Website" 
									icon = { <WebIcon />}
								/>
								
                        )}
					</ul>

					{ props.data.address && props.show.showAddress && (
						<address className={classnames(`${blockClassName}__contact`, {
							[`${blockClassName}__contact--hide-label`] : true,
							[`${blockClassName}__contact--address`] : true
						})}>
							{props.data.address}
						</address>
					) }

					</>)}
			</div>
		)
	}


	const CommsOther = (props) => {

		const {
			label = "Comms",
			data
		} = props

		console.log(data)

		return (
			<div className={`${blockClassName}__comms`}>
				<div className={`${blockClassName}__comms-label`}>{label}:</div>
				
				{props.data && (
					<dl className={`${blockClassName}__comms-other`}>
						{Object.keys(data).filter((key) => {
							return !!data[key]
						}).map( (key, value) => (<>
							<dt>{key}</dt>
							<dd>{data[key]}</dd>
						</>))}
					</dl>)}
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
                    <Row key="contact" value={<Contacts />} display={(showSocial && profile.hasSocial)}/>
                    <Row key="address_district" value={profile.address.district} display={showDistrictAddress}/>
					<Row key="address_capitol" value={profile.address.capitol} display={showCapitolAddress}/>
					<Row key="website" value={<Websites />} display={showWebsites && profile.hasWebsites}/>
                    <Row key="url" value={<Link> More about {profile.title}</Link>} display={showProfileLink}/>

					<Row key="comms_capitol" value={<Comms data={profile.comms.capitol} label="Capitol" show={selectedCapitolCommunicationDetails}/>} display={showCapitolCommunicationDetails} />
					<Row key="comms_district" value={<Comms data={profile.comms.district} label="District" show={selectedDistrictCommunicationDetails}/>} display={showDistrictCommunicationDetails} />
					<Row key="comms_campaign" value={<Comms data={profile.comms.campaign} label="Campaign" show={selectedCampaignCommunicationDetails}/>} display={showCampaignCommunicationDetails} />
					<Row key="comms_other" value={<CommsOther data={profile.comms.other} label="Other" show={selectedOtherCommunicationDetails}/>} display={showOtherCommunicationDetails} />

                </div>
            </div>  
     
    )
}

export default SingleProfile;