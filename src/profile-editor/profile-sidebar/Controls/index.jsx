import { TextControl, TextareaControl, SelectControl, Spinner } from "@wordpress/components";
import { compose } from "@wordpress/compose";
import { withSelect } from "@wordpress/data";
import { useEntityId, useEntityProp } from "@wordpress/core-data";



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
	const {onChange = null, value, ...restProps} = props

	
	const postId = useEntityId("postType", "govpack_profiles")
	const [meta, setMeta] = useEntityProp("postType", "govpack_profiles", "meta", postId)
	
	if(!meta){
		return
	}

    return (
        <Control
			key = {`npe-field-input-${props.meta_key}`}
			__nextHasNoMarginBottom = {true}
            label = {props.label}
            value={ meta[props.meta_key] }
            onChange={ ( value ) => {
                setMeta( { [props.meta_key]: value } )
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
			props.onChange(value)
		},
		
	}, TextControl)
}

export const PanelTextControl = (props) => {
	return DefaultControl(props, TextControl)
}

export const PanelTextareaControl = (props) => {
	return DefaultControl(props, TextareaControl)
}

/**
 * A native date input via TextControl's `type` pass-through (the same
 * mechanism PanelUrlControl uses). The input's value IDL attribute is
 * guaranteed by the HTML spec to be the ISO `yyyy-MM-dd` string (or empty)
 * regardless of the locale the browser displays — the same canonical form
 * the profile meta stores, so the string passes through with no parse/format
 * step and no timezone math.
 *
 * A stored value in a non-canonical legacy format (millisecond-epoch strings
 * from the previous control) renders as an empty field: the browser rejects
 * it and keeps the meta untouched until the user picks a new date.
 */
export const PanelDateControl = (props) => {
	return DefaultControl({ ...props, type: "date" }, TextControl)
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

