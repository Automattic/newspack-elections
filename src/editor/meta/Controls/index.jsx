import { useState } from "@wordpress/element"
import Moment from "moment"

import { TextControl, TextareaControl, DatePicker, SelectControl, Spinner, Dropdown, Button } from "@wordpress/components";
import { compose } from "@wordpress/compose";
import { withSelect, } from "@wordpress/data";
import { dateI18n, getSettings } from "@wordpress/date"
import {MaskedTextControl} from "./MaskedTextControl"


export const PanelFieldset = ({legend = null, children}) => {

	return (
		<fieldset className="components-panel__fieldset">
			{(legend) && (
				<legend  className="components-panel__legend">{legend}</legend>
			)}
			{children}
		</fieldset>
	)
}

const DefaultControl = (props, Control) => {
	const {onChange, meta, ...restProps} = props
    return (
        <Control
            label = {props.label}
            value={ props.meta?.[props.meta_key] ?? "" }
            onChange={ ( value ) => {
                onChange( { [props.meta_key]: value } )
            }}
			{...restProps}
        />
    )
}

export const PanelUrlControl = (props) => {
	return DefaultControl({
		...props,
		"type": "url",
		onChange : (value, event) => {
			console.log("URL On Change", value, event)
			props.onChange(value)
		}
	}, TextControl)
}

export const PanelTextControl = (props) => {
	return DefaultControl(props, TextControl)
}

export const PanelTextareaControl = (props) => {
	return DefaultControl(props, TextareaControl)
}


export const PanelDateControl = (props) => {

	const {onChange, meta, ...restProps} = props
	const [ date, setDate ] = useState( new Date() );
	const [ inputValue, setInputValue ] = useState( null );
	const [ isValid, setIsValid ] = useState( false );
	const [ isTouched, setIsTouched ] = useState( false );

	let settings = getSettings()
	


	let dateValue = props.meta?.[props.meta_key]
	if(dateValue){
		dateValue = moment(parseInt(dateValue)).format("MM/DD/YYYY")
	}

	return (
		<MaskedTextControl
			
			label = {props.label}
			value={	inputValue ?? dateValue ?? "" }
			onChange={ ( value ) => {
				setInputValue(value)
				let timestamp = moment(value, "MM/DD/YYYY", true)
				if(timestamp.isValid()){
				onChange( { [props.meta_key]: timestamp.valueOf().toString() } )
					setIsValid(true)
				} else {
					setIsValid(false)
				}
			}}
			placeholder = "05/31/2021"
			help = "mm/dd/yyyy (eg 05/01/2021)"
			maskProps = {{
				mask : "99/99/9999",
				alwaysShowMask : true,
				permanents : [2, 5],
			}}
			isValid = {isValid}
			isTouched = {isTouched}
			onFocus={ () => {
				setIsTouched(true)
			} }
			{...restProps}
		/>
	)

	/*

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
	*/
}

export const PanelSelectControl = (props) => {
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

export const RawPanelTaxonomyControl = (props) => {

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
            value = { props.post_terms[0] ?? "" }
        />
    )
}

export const PanelTaxonomyControl = compose(

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

