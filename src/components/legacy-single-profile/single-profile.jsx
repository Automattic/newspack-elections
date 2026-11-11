
/**
 * External dependencies
 */
 import clsx from 'clsx'; 

 /**
 * Internal Dependencies
 */
import { normalize_profile } from './NormaliseProfile';
import {prependHTTPS} from "@wordpress/url"

import { NPEIcons, Facebook, X, Instagram, YouTube, Web, Phone, Email, Fax } from "./../../components/Icons"
import { Icon } from "@wordpress/components"

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
					className="govpack-photo"
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


const availableWidths = [
	{
		label : "Small",
		value : "small",
		maxWidth : "300px"
	},
	{
		label : "Medium",
		value : "medium",
		maxWidth : "400px"
	},
	{
		label : "Large",
		value : "large",
		maxWidth : "600px"
	},
	{
		label : "Full",
		value : "full",
		maxWidth : "100%"
	}
]

const Row = (props) => {

	const {
		display, 
		children, 
		id,
		className,
		label = "",
		labelAbove = true,
		showLabel = true
		
	} = props

	if(!display){
		return null
	}

	if(!children){
		return null
	}
	
	const classes = clsx(`${className}__line`, {
		"npe-profile-row" : true,
		"npe-profile-row--labels-above" : labelAbove,
		"npe-profile-row--labels-beside" : !labelAbove,
		[`${className}--${id}`] : (id ?? false)
	} )

	const contentClasses = clsx("npe-profile-row__content", {
		[`npe-profile-row__content--${id}`] : true
	})
	return (
		<div className={classes} role="listitem">
			{(showLabel) && (label !== "") && (
				<dt className="npe-profile-row__label">{label}</dt>
			)}
			<dd className={contentClasses}>
				{children}
			</dd>
		</div>
	)
}

const isValidCollection = (testObj) => {

	let found = false

	// sometimes the object to test will have a value and label.
	// if the object has a key of "value", return true if the 
	// value is truthy and not an empty string
	if(Object.hasOwn(testObj, "value")){
		return (testObj.value && (testObj.value !== "") )
	}

	for(const key in testObj){
			
		if (typeof testObj[key] === "object") {
			found = isValidCollection(testObj[key])
		} else if(testObj[key] !== ""){
			found = true;
		}
		
		if(found){
			break;
		}
	}

	return found
}

const isAnyKeyTrue = ( testObj ) => {

	let found = false;

	for(const key in testObj){

		if(testObj[key] === true){
			found = true
			break;
		}
	}

	return found
}
const SingleProfile = (props) => {

    let {
        profile,
        attributes,
        blockClassName,
        showSelf = false
    } = props

	
    profile = normalize_profile(profile)
	
    const {
        showAvatar, 
        avatarBorderRadius, 
        avatarSize,
        avatarAlignment,
        align,
        width,
		showLabels = false,
		labelsAbove = true,

        showName,
        showAge,
        showBio,
        showLegislativeBody,
        showPosition,
        showParty,
        showState,
		showDistrict,
        showSocial,
		selectedSocial,
		showWebsites,
		showStatus,
		showStatusTag,
        showProfileLink,
		showEndorsements,
        className,

		showCapitolCommunicationDetails,
		showDistrictCommunicationDetails,
		showCampaignCommunicationDetails,
		showOtherCommunicationDetails,
		showOtherLinks,

		selectedCapitolCommunicationDetails,
		selectedDistrictCommunicationDetails,
		selectedCampaignCommunicationDetails,
		selectedOtherCommunicationDetails,
		selectedLinks,

    } = attributes

	const selectedContact = {
		official : showCapitolCommunicationDetails,
		district : showDistrictCommunicationDetails,
		campaign : showCampaignCommunicationDetails,
		other : selectedOtherCommunicationDetails
	}

	

	const Contact = (props) => {
		const href= prependHTTPS(props.href)
		
        return (
            
                <a href={href} className={`gp-profile-contact__link gp-profile-contact__link--hide-label gp-profile-contact__link--${props.service}`} title={props.tooltip ?? props.label ?? ""}>
                    {props.icon && (
                        <span className={`${blockClassName}__icon ${blockClassName}__icon--${props.service}`}>
							<Icon
								icon = { props.icon }
						 	/></span>
                    )}
                    <span className = {`gp-profile-contact__label`}>{props.label}</span>
                </a>
            
        )
    }

    const SocialMedia = (props) => {

		
		const SocialRow = (props) => {
  
			const {
				show = true,
				label
			} = props

			if(!show || !(props.services.facebook || props.services.x || props.services.instagram || props.services.youtube)){
				return null;
			}

			return (
				<div className={`${blockClassName}__social_group gp-profile-contact`}>

					<div className={"wp-block-govpack-profile__label npe-profile-sub-heading"}>{label}: </div>
					<ul className='wp-block-govpack-profile__icon-set'>
						{ props.services.facebook && (
							<Contact 
								service = "facebook"
								href={props.services.facebook} 
								label = "Facebook"
								icon = { <Facebook />}
							/>
						)}

						{ props.services.x && (
							<Contact 
								service = "x"
								href={props.services.x} 
								label = "X" 
								icon = { <X />}
							/>
						)}

						{ props.services.instagram && (
							<Contact 
								service = "instagram"
								href={props.services.instagram} 
								label = "Instagram" 
								icon = { <Instagram />}
							/>
						)}

						{ props.services.youtube && (
							<Contact 
								service = "youtube"
								href={props.services.youtube} 
								label = "YouTube" 
								icon = { <YouTube />}
							/>
						)}
					</ul>
				</div>
			)
		}

        return (
           
            <div className={`${blockClassName}__social wp-block-govpack-profile__group`}>
				<h4 class="wp-block-govpack-profile__heading wp-block-govpack-profile__heading--social">
					Social Media
				</h4>
                <div className={`wp-block-govpack-profile__services wp-block-govpack-profile__group-items`}>
					<SocialRow services={props.data.official} show={props.show.showOfficial} label="Official" />
					<SocialRow services={props.data.campaign} show={props.show.showCampaign} label="Campaign" />
					<SocialRow services={props.data.personal} show={props.show.showPersonal} label="Personal" />
                </div>
            </div>
        )
    }

	const ContactInfo = (props) => {

	/*
		const ContactRow = (props) => {
  
			const {
				show = true,
				label
			} = props

			//if(!show || !(props.services.facebook || props.services.x || props.services.instagram || props.services.youtube)){
			//	return null;
			//}

			return (
				<li className={`${blockClassName}__contact_group`}>
					<div className={`${blockClassName}__label`}>{label}: </div>
					<ul className='govpack-inline-list'>
						{ props.services.email && (
							<Contact 
								service = "email"
								href={props.services.email} 
								label = "email"
								icon = { <EmailIcon />}
							/>
						)}

						{ props.services.x && (
							<Contact 
								service = "x"
								href={props.services.x} 
								label = "X" 
								icon = { <XIcon />}
							/>
						)}

						{ props.services.instagram && (
							<Contact 
								service = "instagram"
								href={props.services.instagram} 
								label = "Instagram" 
								icon = { <InstagramIcon />}
							/>
						)}

						{ props.services.youtube && (
							<Contact 
								service = "youtube"
								href={props.services.youtube} 
								label = "YouTube" 
								icon = { <YouTubeIcon />}
							/>
						)}
					</ul>
				</li>
			)
		}
	*/
        return (
           
            <div className={`${blockClassName}__comms wp-block-govpack-profile__group`}>
				<h4 class="wp-block-govpack-profile__heading wp-block-govpack-profile__heading--social">
					Contact Information
				</h4>
                <ul className={`${blockClassName}__services wp-block-govpack-profile__group-items`}>
					{ selectedContact.official && (
						<ContactRow services={props.data.official} show={selectedCapitolCommunicationDetails} label="Official" />
					)}
					{ selectedContact.campaign && (
						<ContactRow services={props.data.campaign} show={selectedCampaignCommunicationDetails} label="Campaign" />
					)}
					{ selectedContact.district && (	
						<ContactRow services={props.data.district} show={selectedDistrictCommunicationDetails} label="District" />
					)}
					{ hasCommsOtherData(props.data.other) && (
						<CommsOther services={props.data.other} show={selectedOtherCommunicationDetails} label="Other" />
					)}
                </ul>
            </div>
        )
    }

	const ContactRow = (props) => {

		const {
			label = "Comms",
			services = {},
			show = {}
		} = props

		if(!isAnyKeyTrue(show)){
			return null;
		}
		
		if( !( services.phone || services.fax || services.email || services.website || services.address ) ){
			return null;
		}

		return (
			<div className="gp-profile-contact">
				<div class="wp-block-govpack-profile__label npe-profile-sub-heading	">{label}:</div>
				
				{services && (<>
					<div className="wp-block-govpack-profile__icon-set">
						{ services.phone && props.show.showPhone && (
                                <Contact 
									href={`tel:${services.phone}`} 
									tooltip = {`${label} Phone : ${services.phone}`} 
									label = "Phone"  
									icon = { <Phone />}
								/>
								
                            )}
						
						{ services.fax && props.show.showFax &&(
                                <Contact 
									href={`tel:${services.fax}`} 
									tooltip = {`${label} Fax : ${services.fax}`} 
									label = "Fax" 
									icon = { <Fax />}
								/>
								
                            )}

						{ services.email && props.show.showEmail &&(
                                <Contact 
									href={`mailto:${services.email}`} 
									tooltip = {`${label} Email : ${services.email}`} 
									label = "Email" 
									icon = { <Email />}
								/>
								
                        )}

						{ services.website && props.show.showWebsite &&(
                                <Contact 
									href={services.website} 
									tooltip = {`${label} Website : ${services.website}`} 
									label = "Website" 
									icon = { <Web />}
								/>
								
                        )}
					</div>

					{ services.address && props.show.showAddress && (
						<address className={clsx(`${blockClassName}__contact`, {
							[`${blockClassName}__contact--hide-label`] : true,
							[`${blockClassName}__contact--address`] : true
						})}>
							{services.address}
						</address>
					) }

					</>)}
			</div>
		)
	}

	function hasCommsOtherData(item){
		
		const filtered =  Object.keys(item).filter((key) => {
			return item[key].value;
		})	

		return (filtered.length > 0)
	}

	const CommsOther = (props) => {

		const {
			label = "Comms",
			services,
			show = {}
		} = props		

		if(!isAnyKeyTrue(show)){
			return null;
		}
		
		
		return (
			<div className={`${blockClassName}__comms-other`}>
				<div className={`${blockClassName}__label`}>{label}:</div>
				
				{services && (
					<dl className={`${blockClassName}__comms-other key-pair-list`} role="list">
						{Object.keys(services).filter((key) => {
							return !!services[key] && services[key].value
						}).filter( (key) => {
							return (show[key] ?? false)
						}).map( (key, value) => (<div key={key} className="key-pair-list__group" role="listitem">
							<dt className="key-pair-list__key" role="term">{services[key].label}</dt>
							<dd className="key-pair-list__value">{services[key].value}</dd>
						</div>))}
					</dl>)}
			</div>
		)
	}

	const ProfileLinks = (props) => {

		const {
			label = "Links",
			data,
			show
		} = props

		return (
			<div className={`${blockClassName}__comms`}>
				
				{props.data && (
					<ul className={`${blockClassName}__comms-icons wp-block-govpack-profile__icon-set`}>
					
						{Object.keys(data).filter( key => ( 
							(Object.keys(show).length === 0) 
							|| (show[key]))
						).map( (slug, index) => {
							
							
							let link = data[slug]
							
							let icon = null

							if(NPEIcons[slug]){
								icon = NPEIcons[slug]
							}
							
							if(!Icon){
								return false;
							}

							if(!link.href){
								return false;
							}
							return(
								<Contact 
									key = {`icon-${profile.id}-${index}`}
									href={link.href} 
									tooltip = {`Link : ${link.text}`} 
									label = {link.text}
									icon = { icon }
								/>
							)
						} )}
					</ul>
				)}
			</div>
		)
	}

	function hasCommsData(item){
		return item.phone || item.fax || item.email || item.website || item.address;
	}



		

	function hasLinksData(item){
		return (Object.keys(item).length > 0);	
	}	

	const maxWidth = (align !== "full" ? availableWidths.find( (w) => w.value === width)?.maxWidth : false)


	const excerptElement = document.createElement( 'div' );
	excerptElement.innerHTML = profile.bio;
	let bio = excerptElement.textContent || excerptElement.innerText || '';

	const doShowSocial = ((showSocial) && (selectedSocial.showOfficial || selectedSocial.showCampaign || selectedSocial.showPersonal) && (isValidCollection(profile.social)));	
	const doShowContact = ( (selectedContact.official || selectedContact.district || selectedContact.campaign) && (isValidCollection(profile.contact)));		


	const defaultRowProps = {
		showLabel : showLabels,
		labelAbove: labelsAbove
	}
		
	return (
		<div className= {clsx(`wp-block-govpack-profile__container`, {
            [`wp-block-govpack-profile__container--right`] : (avatarAlignment === "right"),
            [`wp-block-govpack-profile__container--left`] : (avatarAlignment === "left"),
            [`wp-block-govpack-profile__container--center`] : (className === "is-styled-center"),
            [`${blockClassName}__container--align-center`] : (align === "center"),
			[`${blockClassName}__container--align-right`] : (align === "right"),
            [`${blockClassName}__container--show-self`] : showSelf,
       })}
       style = {{
           maxWidth : maxWidth ?? "none"
       }}
	   role="list"
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
                    <div className={`${blockClassName}__line ${blockClassName}__line--name`} role="listitem">
                        {showName && (
							<>
                            <h3 className={`${blockClassName}__name`} ><Link>{profile.name.name}</Link></h3>
							</>
                        )}
						{(showStatusTag && profile.status) && (
							<div className={`${blockClassName}__status-tag`}>
								<div className="govpack-termlist">
									<span className="govpack-tag">{profile.status}</span>
								</div>
							</div>
						)}
						
                        {showBio && profile.bio && (
                            <>
                                <div>{bio}</div>
                            </>
                        )}
                        
                    </div>

					<Row {...defaultRowProps} key="party" id="party" label="Party" display={showParty} >
						{profile.party}
					</Row>

					<Row {...defaultRowProps} key="pos" id="position" label="Position" display={showPosition} >
						{profile.position}
					</Row>

					<Row {...defaultRowProps} key="leg_body" id="leg_body" label="Office" display={showLegislativeBody}>
						{profile.legislative_body}
					</Row>

					<Row {...defaultRowProps} key="status" id="status" label="Status" display={showStatus} >
						{profile.status}
					</Row>

					<Row {...defaultRowProps} key="age" id="age" label="Age" display={showAge && !! profile.age}>
						{profile.age}
					</Row>
                    
                    <Row {...defaultRowProps} key="states" id="states" label="State" display={showState} >
						{profile.state}
					</Row>
                    
					<Row {...defaultRowProps} key="district" id="district" label="District" display={showDistrict} >
						{profile.district} 
					</Row>
					
                    
					<Row {...defaultRowProps} key="endorsements" id="endorsements" display={showEndorsements}> 
						{profile.endorsements}
					</Row>

                    <Row {...defaultRowProps} key="social" id="social" label="Social Media"  display={doShowSocial} >
						<SocialMedia data={profile.social} label="Social Media" show={selectedSocial}/>
					</Row>

					<Row {...defaultRowProps} key="comms" id="comms" label="Contact Info" display={doShowContact}>
						<ContactInfo data={profile.contact} label="Social Media" show={selectedContact}/>
					</Row>

					{/**
					<Row {...defaultRowProps} key="comms_capitol" id="comms_capitol" label="Contact Info (Official)" display={showCapitolCommunicationDetails} value={hasCommsData(profile.comms.capitol) && <Comms data={profile.comms.capitol} label="Capitol" show={selectedCapitolCommunicationDetails}/>}  />
					<Row {...defaultRowProps} key="comms_district" id="comms_district" label="Contact Info (District)" display={showDistrictCommunicationDetails} value={hasCommsData(profile.comms.district) && <Comms data={profile.comms.district} label="District" show={selectedDistrictCommunicationDetails}/>}  />
					<Row {...defaultRowProps} key="comms_campaign" id="comms_campaign" label="Contact Info (Campaign)" display={showCampaignCommunicationDetails} value={hasCommsData(profile.comms.campaign) && <Comms data={profile.comms.campaign} label="Campaign" show={selectedCampaignCommunicationDetails}/>} />
					
					<Row {...defaultRowProps} key="comms_other" id="comms_other" label="Contact Info (Other)" display={showOtherCommunicationDetails} >
						<>
						{ hasCommsOtherData(profile.contact.other) && (
							<CommsOther data={profile.contact.other} label="Other" show={selectedOtherCommunicationDetails}/>
						)}
						</> 
					</Row>
					 */}
					<Row {...defaultRowProps} key="links" id="links" label="Links" display={showOtherLinks} >
						<> 
						{hasLinksData(profile.links) && (
							<ProfileLinks data={profile.links} show={selectedLinks}/>
						)}
						</>
					</Row>
					<Row {...defaultRowProps} key="url" id="more_about" label="More" display={showProfileLink} >
						<Link> More about {profile.title}</Link>
					</Row>
                </div>
		</div>
	)

}

export default SingleProfile;
