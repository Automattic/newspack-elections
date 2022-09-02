


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

import { normalize_profile } from './NormaliseProfile';
 



const Row = (props) => {

    const {display, value} = props

    if(!display){
        return null
    }

    if(!value){
        return null
    }

    return (
        <div className="wp-block-govpack-profile__line" role="listitem">
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

    profile = normalize_profile(profile)

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
        showSocial,
		selectedSocial,
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

    const SocialMedia = (props) => {

		const SocialRow = (props) => {

			const {
				show = true,
				label
			} = props

			if(!show || !(props.services.facebook || props.services.twitter || props.services.instagram)){
				return null;
			}

			return (
				<li className={`${blockClassName}__social_group`}>
					<div className={`${blockClassName}__label`}>{label}: </div>
					<ul className='inline-list'>
						{ props.services.facebook && (
							<Contact 
								href={props.services.facebook} 
								label = "Facebook"
								icon = { <FacebookIcon />}
							/>
						)}

						{ props.services.twitter && (
							<Contact 
								href={props.services.twitter} 
								label = "Twitter" 
								icon = { <TwitterIcon />}
							/>
						)}

						{ props.services.instagram && (
							<Contact 
								href={props.services.instagram} 
								label = "Instagram" 
								icon = { <InstagramIcon />}
							/>
						)}
					</ul>
				</li>
			)
		}

		
		

        return (
           
            <div className={`${blockClassName}__social`}>
                <ul className={`${blockClassName}__services`}>
					<SocialRow services={props.data.official} show={props.show.showOfficial} label="Offical" />
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
					<ul className={`${blockClassName}__comms-icons inline-list`}>
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

	function hasCommsData(item){
		return item.phone || item.fax || item.email || item.website || item.address;
	}

	function hasCommsOtherData(item){
		return Object.keys(item).filter((key) => {
			return item[key].value;
		}).length;		
	}	

	const maxWidth = (align !== "full" ? props.availableWidths.find( (w) => w.value === width)?.maxWidth : false)
    const excerptElement = document.createElement( 'div' );
    excerptElement.innerHTML = profile.bio;

    let bio = excerptElement.textContent || excerptElement.innerText || '';

	const doShowSocial = selectedSocial.showOfficial || selectedSocial.showCampaign || selectedSocial.showPersonal;		

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
                    <div className={`${blockClassName}__line`} role="listitem">
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

                    <Row key="social" value={<SocialMedia data={profile.social} label="Social Media" show={selectedSocial}/>} display={(showSocial && doShowSocial)}/>
					<Row key="comms_capitol" value={hasCommsData(profile.comms.capitol) && <Comms data={profile.comms.capitol} label="Capitol" show={selectedCapitolCommunicationDetails}/>} display={showCapitolCommunicationDetails} />
					<Row key="comms_district" value={hasCommsData(profile.comms.district) && <Comms data={profile.comms.district} label="District" show={selectedDistrictCommunicationDetails}/>} display={showDistrictCommunicationDetails} />
					<Row key="comms_campaign" value={hasCommsData(profile.comms.campaign) && <Comms data={profile.comms.campaign} label="Campaign" show={selectedCampaignCommunicationDetails}/>} display={showCampaignCommunicationDetails} />
					<Row key="comms_other" value={hasCommsOtherData(profile.comms.other) && <CommsOther data={profile.comms.other} label="Other" show={selectedOtherCommunicationDetails}/>} display={showOtherCommunicationDetails} />

					<Row key="url" value={<Link> More about {profile.title}</Link>} display={showProfileLink}/>
                </div>
            </div>  
     
    )
}

export default SingleProfile;