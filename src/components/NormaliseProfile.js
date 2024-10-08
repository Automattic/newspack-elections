import { decodeEntities } from '@wordpress/html-entities';
import {isURL} from "@wordpress/url";
import { isArray, isEmpty, isNil } from 'lodash';

export function normalize_profile(profile){

	if(isNil(profile)){
		return {}
	}
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

  const getAgeFromEpoch = (dateOfBirthMs) => {
	
    // dateOfBirth is in milliseconds since the epoch.
    let today = new Date();
    let dateOfBirth = new Date(Number(dateOfBirthMs));
    // Did the birthday pass this month yet?
    let birthdayThisYearYet = (today.getMonth() > dateOfBirth.getMonth() ||
                               (today.getMonth() == dateOfBirth.getMonth() && today.getDate() >= dateOfBirth.getDate()));
    return today.getFullYear() - dateOfBirth.getFullYear() - (birthdayThisYearYet ? 0 : 1) + " Years";
  }


  	let generated_name = [
		profile.meta?.name_prefix, 
		profile.meta?.name_first,
		profile.meta?.name_middle, 
		profile.meta?.name_last,
		profile.meta?.name_suffix,
	].join(" ")

    return {
        title : decodeEntities(profile?.title?.rendered ?? profile?.title),
        featured_image : featured_image,
        featured_image_thumbnail :  featured_image?.source_url ?? null,
        legislative_body : getFromEmbedded("govpack_legislative_body")?.name ?? null,
        position : getFromEmbedded("govpack_officeholder_title")?.name ?? null,
        state : getFromEmbedded("govpack_state")?.name ?? null,
        party : getFromEmbedded("govpack_party")?.name ?? null,
		status : getFromEmbedded("govpack_officeholder_status")?.name ?? null,
        email :  decodeEntities(profile.meta?.email ?? null),
        link :  profile.link,
		district :  profile.meta?.district ?? null,
		endorsements :  profile.meta?.endorsements ?? null,
		social : {
        	official : {
				x : profile.meta?.x_official ??  profile.meta?.twitter_official ?? null,
				twitter : profile.meta?.twitter_official ?? null,
				facebook : profile.meta?.facebook_official ?? null,
				instagram : profile.meta?.instagram_official ?? null,
				youtube : profile.meta?.youtube_official ?? null
			},
			campaign :  {
				x : profile.meta?.x_campaign ??  profile.meta?.twitter_campaign ?? null,
				twitter : profile.meta?.twitter_campaign ?? null,
				facebook : profile.meta?.facebook_campaign ?? null,
				instagram : profile.meta?.instagram_campaign ?? null,
				youtube : profile.meta?.youtube_campaign ?? null
			},
			personal :  {
				x : profile.meta?.x_personal ??  profile.meta?.twitter_personal ?? null,
				twitter : profile.meta?.twitter_personal ?? null,
				facebook : profile.meta?.facebook_personal ?? null,
				instagram : profile.meta?.instagram_personal ?? null,
				youtube : profile.meta?.youtube_personal ?? null
			},
		},

		address : {
			default 	: (createAddress("capitol") ?? createAddress("district") ?? null),
			capitol 	: createAddress("capitol"),
			district 	: createAddress("district")
		},
		name : {
			name 	: profile.meta?.name || profile.title?.rendered || generated_name,
			full 	: generated_name,
			first 	: profile.meta?.first_name ?? null,
			last 	: profile.meta?.last_name ?? null
		},
        age : profile.meta?.date_of_birth ? getAgeFromEpoch(Number(profile.meta?.date_of_birth)) : null,
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
				website_other :  {
					label : "Website (Personal)",
					value : profile.meta?.website_personal,
				},				
				email_other :  {
					label : "Email (Other)",
					value : profile.meta?.email_other,
				},
				rss :  {
					label : "RSS Feed URL",
					value : profile.meta?.rss
				}, 
				contact_form_url : {
					label : "Contact Form URL",
					value : profile.meta?.contact_form_url
				}
			}
		},
		links : generateLinks(),
		link_services : profile.link_services ?? {}
    }

	function generateLinks(){

		const services = Object.keys(profile.link_services).filter( (key) => {

			let service = profile.link_services[key]
			return service?.enabled ?? false;

		}).filter( (key) => {

			let service = profile.link_services[key]

			if (typeof profile.meta[service.meta_key] === "undefined"){
				return false;
			}
			if (profile.meta[service.meta_key] === false){
				return false;
			}
			
			if (profile.meta[service.meta_key] === ""){
				return false;
			} 

			if (!profile.meta[service.meta_key]){
				return false;
			}

			return true
		}).reduce( (prev, current) => {

			let service = profile.link_services[current]

			const link = {
				'meta'   : profile.meta[service.meta_key],
				'target' : '_blank',
				'href'   : isURL(profile.meta[service.meta_key]) ? profile.meta[service.meta_key] : service.template.replace('{' + service.meta_key+ '}', profile.meta[service.meta_key] ),
				'text'   : service.label,
				'slug'   : service.slug,
				'id'     : null,
				'rel'    : null,
				'class'  : "",
			}
			return {
				...prev,
				...{
					[current] : link
				}
			}
		}, {})

		
		return services
	}
}
