// Using ESNext syntax
//import { PluginSidebar, PluginSidebarMoreMenuItem } from '@wordpress/edit-post';
import "./view.scss"

import { registerPlugin } from '@wordpress/plugins';
import { more } from '@wordpress/icons';
import { useState } from 'react';
import { dateI18n, __experimentalGetSettings as getSettings } from "@wordpress/date"

import { TextControl, TextareaControl, DatePicker,PanelRow, SelectControl, Spinner, Dropdown, Button, BaseControl } from "@wordpress/components";

import {GovPackSidebarPanel} from "./../../components/sidebar-panel"
 
import { compose } from "@wordpress/compose";
import { withSelect, withDispatch, select } from "@wordpress/data";



function withPanel(component) {

    return compose([ 
        withSelect( ( select ) => {		
            return {
                meta: select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
                type: select( 'core/editor' ).getCurrentPostType(),
            };
        }),
        withDispatch( ( dispatch ) => {
            return {
                setPostMeta( newMeta ) {
                    console.log("setPostMeta", newMeta)
                    dispatch( 'core/editor' ).editPost( { meta: newMeta } );
                },
                setTerm(taxonomy, term ) {

                    const { getTaxonomy } = select( 'core' );
                    const _taxonomy = getTaxonomy(taxonomy)

                    dispatch( 'core/editor' ).editPost( { [ _taxonomy.rest_base ]: term } );
                }

            };
        } ) 
    ])(component)
}

const AboutPanel = (props) => {

    let { setPostMeta } = props

    return (
        <GovPackSidebarPanel 
            title="About"
            name="gov-profile-about"
        >
			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Name" meta_key="name" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Prefix" meta_key="name_prefix" onChange={setPostMeta} />
            </PanelRow>

            <PanelRow>
                <PanelTextControl meta={props.meta} label = "First Name" meta_key="name_first" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Middle Name" meta_key="name_middle" onChange={setPostMeta} />
            </PanelRow>

            <PanelRow>
                <PanelTextControl meta={props.meta} label = "Last Name" meta_key="last_middle" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Suffix" meta_key="name_suffix" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Nickname" meta_key="nickname" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Occupation" meta_key="occupation" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Education" meta_key="education" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Gender" meta_key="gender" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Race" meta_key="race" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Ethnicity" meta_key="ethnicity" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelDatePickerControl meta={props.meta} label = "Date of Birth" meta_key="date_of_birth" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelDatePickerControl meta={props.meta} label = "Date of Death" meta_key="date_of_death" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Party" meta_key="party" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "State" meta_key="state" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "Status" meta_key="status" onChange={setPostMeta} />
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label = "District" meta_key="district" onChange={setPostMeta} />
            </PanelRow>


        </GovPackSidebarPanel>
    )
}

const PanelTextControl = (props) => {

	const {onChange, meta, meta_key, ...restProps} = props

    return (
        <TextControl
			
            label = {props.label}
            value={ props.meta?.[props.meta_key] ?? "" }
            onChange={ ( value ) => {
                onChange( { [props.meta_key]: value } )
            }}
			
			{...restProps}
			
        />
    )
}

const PanelTextareaControl = (props) => {

	const {onChange, meta, ...restProps} = props

    return (
        <TextareaControl
			
            label = {props.label}
            value={ props.meta?.[props.meta_key] ?? "" }
            onChange={ ( value ) => {
                onChange( { [props.meta_key]: value } )
            }}
			
			{...restProps}
			
        />
    )
}

const PanelDatePickerControl = (props) => {

	const {onChange, meta, ...restProps} = props
	const [ date, setDate ] = useState( new Date() );

	let settings = getSettings()
	

	return (
		<>
			<span>{ props.label }</span>
		
			<Dropdown
				renderToggle={ ( { isOpen, onToggle } ) => (
					<Button
						onClick={ onToggle }
						aria-expanded={ isOpen }
						variant="tertiary"
					>
						{dateI18n(settings.formats.date, date)}
					</Button>
				) }
				renderContent={ ( { onClose } ) => (
					<DatePicker
						currentDate={ date }
						onChange={ ( newDate ) => setDate( newDate ) }
						onClose={ onClose }
					/>
				) }
			/>

		</>
	
    )
}

const PanelSelectControl = (props) => {
    return (
        <SelectControl
            label = {props.label}
            value={ props.meta?.[props.meta_key] ?? "" }
            onChange={ ( value ) => {
                props.onChange( { [props.meta_key]: value } )
             } }
            options={ props.options }
        />
    )
}

const RawPanelTaxonomyControl = (props) => {

    if ( null === props.terms ) {
        return <Spinner />
    }

    const options = props.terms.map( ( term ) => {
        return {
            label: term.name,
            value: term.id
        }
    });

    
    return (
        <SelectControl
            label = {props.label}
            onChange={ ( value ) => {
               props.onChange(props.taxonomy, value)
            } }
            options={ options }
            value = { props.post_terms ?? "" }
        />
    )
}

const PanelTaxonomyControl = compose(

    withSelect( ( select, ownProps ) => {

        const { 
            getEntityRecords,
            getTaxonomy 
        } = select( 'core' );

        const { 
            getEditedPostAttribute 
        } = select('core/editor');

        const _taxonomy = getTaxonomy( ownProps.taxonomy );
        
        return {
            terms: getEntityRecords( 'taxonomy', ownProps.taxonomy, { per_page: 100 } ),
            post_terms: _taxonomy ? getEditedPostAttribute( _taxonomy.rest_base ) : []
        };
    } )

)( RawPanelTaxonomyControl );

const OfficePanel = (props) => {

    let { setPostMeta } = props

    return (
        <GovPackSidebarPanel 
            title="Office"
            name="gov-profile-office"
        >
			
			<PanelRow>
                <PanelTextareaControl meta={props.meta} label= "Address (Capitol)" meta_key="address_capitol" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextareaControl meta={props.meta} label= "Address (District)" meta_key="address_district" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextareaControl meta={props.meta} label= "Address (Campaign)" meta_key="address_campaign" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Contact Form URL" meta_key="contact_form_url" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelDatePickerControl meta={props.meta} label= "Date assumed office" meta_key="date_assumed_office" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Appointed by" meta_key="appointed_by" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelDatePickerControl meta={props.meta} label= "Date appointed" meta_key="appointed_date" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelDatePickerControl meta={props.meta} label= "Date confirmed" meta_key="confirmed_date" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelDatePickerControl meta={props.meta} label= "Date term ends" meta_key="term_end_data" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Congress Year/Batch" meta_key="congress_year" onChange={setPostMeta}/>
            </PanelRow>

        </GovPackSidebarPanel>
    )
}

const SecondaryOfficePanel = (props) => {

    let { setPostMeta } = props

	return null
	/*
    return (
        <GovPackSidebarPanel 
            title="District Office"
            name="gov-profile-secondary-office"
        >
        
            <PanelRow>
                <PanelTextControl meta={props.meta} label= "Address" meta_key="district_office_address" onChange={setPostMeta}/>
            </PanelRow>

            <PanelRow>
                <PanelTextControl meta={props.meta} label = "City" meta_key="district_office_city" onChange={setPostMeta}/>
            </PanelRow>

            <PanelRow>
                <PanelTextControl meta={props.meta} label = "State" meta_key="district_office_state" onChange={setPostMeta}/>
            </PanelRow>

            <PanelRow>
                <PanelTextControl meta={props.meta} label = "Zip" meta_key="district_office_zip" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Phone" meta_key="district_phone" onChange={setPostMeta}/>
            </PanelRow>


        </GovPackSidebarPanel>
    )
	*/
}

const PositionPanel = (props) => {

    let { setTerm, setPostMeta } = props

    return (
        <GovPackSidebarPanel 
            title="Position"
            name="gov-profile-position"
        >
        
          
            <PanelRow>
                <PanelSelectControl options = {Object.keys(titles).map( (key) => {
                   return {
                    value : key,
                    label : titles[key]
                   }
                    } )} label = "Title" meta_key="title" onChange={setPostMeta} />
                </PanelRow>

            <PanelRow>
                <PanelTaxonomyControl 
                    meta={props.meta} 
                    label = "Legislative Body" 
                    taxonomy="govpack_legislative_body" 
                    onChange={setTerm}
                />
            </PanelRow>

            <PanelRow>
                <PanelTaxonomyControl 
                    meta={props.meta} 
                    label = "State" 
                    taxonomy="govpack_state" 
                    onChange={setTerm}
                />
            </PanelRow>

           

            <PanelRow>
                <PanelSelectControl 
                    meta={props.meta} 
                    label = "County" 
                    taxonomy="govpack_county" 
                    onChange={setTerm}
                />
            </PanelRow>

        </GovPackSidebarPanel>
    )
}

const SocialPanel = (props) => {

	let { setPostMeta } = props

	return (
        <GovPackSidebarPanel 
            title="Social"
            name="gov-profile-social"
        >

			<PanelRow>
				<PanelTextControl meta={props.meta} label= "Twitter (Official)" meta_key="twitter_official" onChange={setPostMeta}/>
			</PanelRow>
			<PanelRow>
				<PanelTextControl meta={props.meta} label= "Twitter (Personal)" meta_key="twitter_personal" onChange={setPostMeta}/>
			</PanelRow>
			<PanelRow>
				<PanelTextControl meta={props.meta} label= "Twitter (Campaign)" meta_key="twitter_campaign" onChange={setPostMeta}/>
			</PanelRow>

			<PanelRow>
				<PanelTextControl meta={props.meta} label= "Instagram (Official)" meta_key="Instagram_official" onChange={setPostMeta}/>
			</PanelRow>
			<PanelRow>
				<PanelTextControl meta={props.meta} label= "Instagram (Personal)" meta_key="Instagram_personal" onChange={setPostMeta}/>
			</PanelRow>
			<PanelRow>
				<PanelTextControl meta={props.meta} label= "Instagram (Campaign)" meta_key="Instagram_campaign" onChange={setPostMeta}/>
			</PanelRow>

			<PanelRow>
				<PanelTextControl meta={props.meta} label= "facebook (Official)" meta_key="facebook_official" onChange={setPostMeta}/>
			</PanelRow>
			<PanelRow>
				<PanelTextControl meta={props.meta} label= "facebook (Personal)" meta_key="facebook_personal" onChange={setPostMeta}/>
			</PanelRow>
			<PanelRow>
				<PanelTextControl meta={props.meta} label= "facebook (Campaign)" meta_key="facebook_campaign" onChange={setPostMeta}/>
			</PanelRow>

			<PanelRow>
				<PanelTextControl meta={props.meta} label= "LinkedIn" meta_key="linkedin" onChange={setPostMeta}/>
			</PanelRow>
		</GovPackSidebarPanel>
	)
}

const CommunicationsPanel = (props) => {

    let { setPostMeta } = props

    return (
        <GovPackSidebarPanel 
            title="Communications"
            name="gov-profile-communications"
        >
        
        
            <PanelRow>
                <PanelTextControl meta={props.meta} label= "Email (Official)" meta_key="email_official" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Email (Campaign)" meta_key="email_campaign" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Email (Other)" meta_key="email_other" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Email" meta_key="email" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Phone (District)" meta_key="phone_district" onChange={setPostMeta}/>
            </PanelRow>
			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Phone (Campaign)" meta_key="phone_campaign" onChange={setPostMeta}/>
            </PanelRow>
			
			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Fax (District)" meta_key="fax_district" onChange={setPostMeta}/>
            </PanelRow>
			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Fax (Campaign)" meta_key="fax_campaign" onChange={setPostMeta}/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label="Website (Personal)" meta_key="website_personal" onChange={setPostMeta} placeholder="https://"/>
            </PanelRow>

            <PanelRow>
                <PanelTextControl meta={props.meta} label="Website (Campaign)" meta_key="website_campaign" onChange={setPostMeta} placeholder="https://"/>
            </PanelRow>

            <PanelRow>
                <PanelTextControl meta={props.meta} label="Website (Legislative)" meta_key="website_legislative" onChange={setPostMeta} placeholder="https://"/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "RSS" meta_key="rss" onChange={setPostMeta}/>
            </PanelRow>

        </GovPackSidebarPanel>
    )
}

const MetadataIdsPanel = (props) => {

    let { setPostMeta } = props

    return (
        <GovPackSidebarPanel 
            title="Metadata & IDS"
            name="gov-metadataids-communications"
        >
			  <PanelRow>
                <PanelTextControl meta={props.meta} label= "Govpack ID" meta_key="govpack_id" onChange={setPostMeta} placeholder="" disabled/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "FEC ID" meta_key="fec_ids" onChange={setPostMeta} placeholder="" disabled/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "US.IO ID" meta_key="usio_id" onChange={setPostMeta} placeholder="" disabled/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Opensecrets ID" meta_key="opensecrets_id" onChange={setPostMeta} placeholder="" disabled/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "District OCDID" meta_key="district_ocd_ic" onChange={setPostMeta} placeholder="" disabled/>
            </PanelRow>

			<PanelRow>
                <PanelTextControl meta={props.meta} label= "Open States ID" meta_key="openstates_id" onChange={setPostMeta} placeholder="" disabled/>
            </PanelRow>

		</GovPackSidebarPanel>
	)
}

const ComposedAboutPanel = withPanel(AboutPanel)
const ComposedOfficePanel = withPanel(OfficePanel)
const ComposedCommunicationsPanel = withPanel(CommunicationsPanel)
const ComposedSocialPanel = withPanel(SocialPanel)
const ComposedMetadataIds = withPanel(MetadataIdsPanel)




const GovPackProfileSidebar = () => (
    <>
        <ComposedAboutPanel />
        <ComposedOfficePanel />
        <ComposedCommunicationsPanel />
		<ComposedSocialPanel />
		<ComposedMetadataIds />
    </>

);
 
registerPlugin( 'profile-meta', {
    icon: more,
    render: GovPackProfileSidebar,
} );