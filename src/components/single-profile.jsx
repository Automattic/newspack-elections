


import {ReactComponent as FacebookIconSVG} from "./../images/facebook.svg"
import {ReactComponent as TwitterIconSVG} from "./../images/twitter.svg"
import {ReactComponent as XIconSVG} from "./../images/x.svg"
import {ReactComponent as LinkedinIconSVG} from "./../images/linkedin.svg"
import {ReactComponent as EmailIconSVG} from "./../images/email.svg"
import {ReactComponent as InstagramIconSVG} from "./../images/instagram.svg"
import {ReactComponent as PhoneIconSVG} from "./../images/phone.svg"
import {ReactComponent as WebIconSVG} from "./../images/globe.svg"
import {ReactComponent as FaxIconSVG} from "./../images/fax.svg"
import {ReactComponent as YouTubeIconSVG} from "./../images/youtube.svg"
import {ReactComponent as GoogleIconSVG} from "./../images/google.svg"
import {ReactComponent as WikipediaIconSVG} from "./../images/wikipedia.svg"
import {ReactComponent as GabIconSVG} from "./../images/gab.svg"
import {ReactComponent as OpenStatesIconSVG} from "./../images/openstates.svg"
import {ReactComponent as OpenSecretsIconSVG} from "./../images/opensecrets.svg"
import {ReactComponent as RumbleIconSVG} from "./../images/rumble.svg"
import {ReactComponent as FecIconSVG} from "./../images/fec.svg"

import { Icon } from '@wordpress/components';
/**
 * External dependencies
 */
 import classnames from 'classnames';

import { normalize_profile } from './NormaliseProfile';
import ProfileCommsPanel from "./Panels/ProfileCommsPanel"
 



const TwitterIcon = () => ( <Icon icon={ TwitterIconSVG } /> )
const XIcon = () => ( <Icon icon={ XIconSVG } /> )
const LinkedinIcon = () => ( <Icon icon={ LinkedinIconSVG } /> )
const EmailIcon = () => ( <Icon icon={ EmailIconSVG } /> )
const InstagramIcon = () => ( <Icon icon={ InstagramIconSVG } /> )
const PhoneIcon = () => ( <Icon icon={ PhoneIconSVG } /> )
const WebIcon = () => ( <Icon icon={ WebIconSVG } /> )
const FaxIcon = () => ( <Icon icon={ FaxIconSVG } /> )
const FacebookIcon = () => ( <Icon icon={ FacebookIconSVG } /> )
const YouTubeIcon = () => ( <Icon icon={ YouTubeIconSVG } /> )
const WikipediaIcon = () => ( <Icon icon={ WikipediaIconSVG } /> )
const GoogleIcon = () => ( <Icon icon={ GoogleIconSVG } /> )
const GabIcon = () => ( <Icon icon={ GabIconSVG } /> )
const OpenStatesIcon = () => ( <Icon icon={ OpenStatesIconSVG } /> )
const OpenSecretsIcon = () => ( <Icon icon={ OpenSecretsIconSVG } /> )
const RumbleIcon = () => ( <Icon icon={ RumbleIconSVG } /> )
const FecIcon = () => ( <Icon icon={ FecIconSVG } /> )

const ProfileLinksIcons = {
	"google" : GoogleIcon,
	"wikipedia" : WikipediaIcon,
	"gab" : GabIcon,
	"openstates" : OpenStatesIcon,
	"opensecrets" : OpenSecretsIcon,
	"rumble" : RumbleIcon,
	"fec" : FecIcon,
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

	const Row = (props) => {

		const {
			display, 
			value, 
			id,
			label = ""
		} = props
	
		if(!display){
			return null
		}
	
		if(!value){
			return null
		}
		
		const classes = classnames(`${blockClassName}__line`, {
			"govpack-line" : true,
			"govpack-line--labels-above" : labelsAbove,
			"govpack-line--labels-beside" : !labelsAbove,
			[`${blockClassName}--${id}`] : (id ?? false)
		} )
	
		return (
			<div className={classes} role="listitem">
				{(showLabels) && (label !== "") && (
					<dt className="govpack-line__label">{label}</dt>
				)}
				<dd className="govpack-line__content">
					{value}
				</dd>
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
                        <span className={`${blockClassName}__contact__icon ${blockClassName}__contact__icon--${props.service}`}>{props.icon}</span>
                    )}
                    <span className = {`${blockClassName}__contact__label`}>{props.label}</span>
                </a>
            </li >
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
				<li className={`${blockClassName}__social_group`}>
					<div className={`${blockClassName}__label`}>{label}: </div>
					<ul className='govpack-inline-list'>
						{ props.services.facebook && (
							<Contact 
								service = "facebook"
								href={props.services.facebook} 
								label = "Facebook"
								icon = { <FacebookIcon />}
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

        return (
           
            <div className={`${blockClassName}__social`}>
                <ul className={`${blockClassName}__services`}>
					<SocialRow services={props.data.official} show={props.show.showOfficial} label="Official" />
					<SocialRow services={props.data.campaign} show={props.show.showCampaign} label="Campaign" />
					<SocialRow services={props.data.personal} show={props.show.showPersonal} label="Personal" />
                </ul>
            </div>
        )
    }


	const Comms = (props) => {

		const {
			label = "Comms"
		} = props

		if( !( props.data.phone || props.data.fax || props.data.email || props.data.website || props.data.address ) ){
			return null;
		}

		return (
			<div className={`${blockClassName}__comms`}>
				<div className={`${blockClassName}__label`}>{label}:</div>
				
				{props.data && (<>
					<ul className={`${blockClassName}__comms-icons govpack-inline-list`}>
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
									href={`mailto:${props.data.email}`} 
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

		return (
			<div className={`${blockClassName}__comms-other`}>
				<div className={`${blockClassName}__label`}>{label}:</div>
				
				{props.data && (
					<dl className={`${blockClassName}__comms-other key-pair-list`} role="list">
						{Object.keys(data).filter((key) => {
							return !!data[key] && data[key].value
						}).filter( (key) => {
							return (props.show[key] ?? true)
						}).map( (key, value) => (<div key={key} className="key-pair-list__group" role="listitem">
							<dt className="key-pair-list__key" role="term">{data[key].label}</dt>
							<dd className="key-pair-list__value">{data[key].value}</dd>
						</div>))}
					</dl>)}
			</div>
		)
	}

	const ProfileLinks = (props) => {

		const {
			label = "Links",
			data
		} = props			

		return (
			<div className={`${blockClassName}__comms`}>
				<div className={`${blockClassName}__label`}>{label}:</div>
				{props.data && (
					<ul className={`${blockClassName}__comms-icons govpack-inline-list govpack-vertical-list`}>
					
						{Object.keys(data).filter( key => ( 
							(Object.keys(selectedLinks).length === 0) 
							|| (selectedLinks[key]))
						).map( (slug, index) => {
							let link = data[slug]
							let Icon = null
							if(ProfileLinksIcons[slug]){
								Icon = ProfileLinksIcons[slug]()
							}
							if(!Icon){
								return false;
							}
							return(
								<Contact 
									key = {`icon-${profile.id}-${index}`}
									href={link.href} 
									tooltip = {`Link : ${link.text}`} 
									label = {link.text}
									icon = { Icon }
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



	function hasCommsOtherData(item){
		return Object.keys(item).filter((key) => {
			return item[key].value;
		}).length;		
	}	

	function hasLinksData(item){
		return (Object.keys(item).length > 0);	
	}	

	const maxWidth = (align !== "full" ? availableWidths.find( (w) => w.value === width)?.maxWidth : false)
    const excerptElement = document.createElement( 'div' );
    excerptElement.innerHTML = profile.bio;

    let bio = excerptElement.textContent || excerptElement.innerText || '';

	
	const hasSocial = (testObj) => {
		let found = false

		for(const key in testObj){
			if (typeof testObj[key] === "object") {
				found = hasSocial(testObj[key])
			} else if(testObj[key] !== ""){
				found = true;
			}
			
			if(found){
				continue;
			}
		}

		return found
	}


	const doShowSocial = ((showSocial) && (selectedSocial.showOfficial || selectedSocial.showCampaign || selectedSocial.showPersonal) && (hasSocial(profile.social)));		

	
    return (
       <div className= {classnames(`${blockClassName}__container`, {
            [`${blockClassName}__container--right`] : (avatarAlignment === "right"),
            [`${blockClassName}__container--left`] : (avatarAlignment === "left"),
            [`${blockClassName}__container--center`] : (className === "is-styled-center"),
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

					<Row key="age" id="age" label="Age" value={profile.age} display={showAge}/>
                    <Row key="leg_body" id="leg_body" label="Legislative Body" value={profile.legislative_body} display={showLegislativeBody}/>
                    <Row key="pos" id="position" label="Position" value={profile.position}  display={showPosition}/>
                    <Row key="party" id="party" label="Party" value={profile.party}  display={showParty}/>
					<Row key="district" id="district" label="District" value={profile.district}  display={showDistrict}/>
					<Row key="status" id="status" label="Status" value={profile.status} display={showStatus}/>
                    <Row key="states" id="states" label="State" value={profile.state} display={showState}/>
					<Row key="endorsements" id="endorsements" value={profile.endorsements} display={showEndorsements}/>
                    <Row key="social" id="social" label="Social Media" value={<SocialMedia data={profile.social} label="Social Media" show={selectedSocial}/>} display={doShowSocial}/>
					<Row key="comms_capitol" id="comms_capitol" label="Contact Info (Capitol)" value={hasCommsData(profile.comms.capitol) && <Comms data={profile.comms.capitol} label="Capitol" show={selectedCapitolCommunicationDetails}/>} display={showCapitolCommunicationDetails} />
					<Row key="comms_district" id="comms_district" label="Contact Info (District)" value={hasCommsData(profile.comms.district) && <Comms data={profile.comms.district} label="District" show={selectedDistrictCommunicationDetails}/>} display={showDistrictCommunicationDetails} />
					<Row key="comms_campaign" id="comms_campaign" label="Contact Info (Campaign)" value={hasCommsData(profile.comms.campaign) && <Comms data={profile.comms.campaign} label="Campaign" show={selectedCampaignCommunicationDetails}/>} display={showCampaignCommunicationDetails} />
					<Row key="comms_other" id="comms_other" label="Contact Info (Other)" value={hasCommsOtherData(profile.comms.other) && <CommsOther data={profile.comms.other} label="Other" show={selectedOtherCommunicationDetails}/>} display={showOtherCommunicationDetails} />
					<Row key="links" id="links" label="Links" value={hasLinksData(profile.links) && <ProfileLinks data={profile.links} show={selectedLinks}/>} display={showOtherLinks} />
					<Row key="url" id="more_about" label="More" value={<Link> More about {profile.title}</Link>} display={showProfileLink}/>
                </div>
            </div>  
     
    )
}

export default SingleProfile;
