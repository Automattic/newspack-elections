/**
 * External dependencies
 */
import { debounce } from 'lodash';


/**
 * WordPress dependencies
 */
import { FormTokenField, Spinner, Button } from '@wordpress/components';
import { useEffect, useState } from '@wordpress/element';
import { __, _x, sprintf } from '@wordpress/i18n';

const AutocompleteField = (props) => {
	
	let [suggestions, setSuggestions] = useState([])
	let [suggestionsRequest, setSuggestionsRequest] = useState()
	let [loading, setLoading] = useState(false)
	let [validValues, setValidValues] = useState({})

	const {
		label = false,
		help = false,
		maxLength,
		tokens = [],
		onChange,
		returnFullObjects,
		fetchSuggestions
	} = props


	/**
	 * Refresh the autocomplete dropdown.
	 *
	 * @param {string} input Input to fetch suggestions for
	 */
	const updateSuggestions = ( input ) => {
		
		if ( ! fetchSuggestions ) {
			return;
		}

		setLoading(true)
		const request = fetchSuggestions( input );
		request
			.then( suggestions => {

				console.log("then", suggestions, suggestionsRequest)
				
					// A fetch Promise doesn't have an abort option. It's mimicked by
					// comparing the request reference in on the instance, which is
					// reset or deleted on subsequent requests or unmounting.
					//if ( suggestionsRequest !== request ) {
					//	return;
					//}

					const currentSuggestions = [ ...suggestions ];
					const currentValidValues = {};

					suggestions.forEach( suggestion => {
						currentValidValues[ suggestion.value ] = suggestion.label;
					} );

					console.log("currentSuggestions", currentSuggestions)

					setSuggestions(currentSuggestions);
					setValidValues(currentValidValues);
					setLoading(false);
			}).catch( () => {
				console.log("catch", request)
				if ( suggestionsRequest === request ) {
					setLoading(false);
				}
			} );

		console.log("??")

		setSuggestionsRequest(request);
		
	}
	
	const debouncedUpdateSuggestions = debounce( updateSuggestions, 500 );

	/**
	 * Get a list of labels for input values.
	 *
	 * @param {Array} values Array of values (ids, etc.).
	 * @return {Array} array of valid labels corresponding to the values.
	 */
	const getLabelsForValues = ( values ) => {
		return values.reduce( ( accumulator, value ) => {
			if ( ! value ) {
				return accumulator;
			}
			if ( value.label ) {
				return [ ...accumulator, value.label ];
			}

			return validValues[ value ] ? [ ...accumulator, validValues[ value ] ] : accumulator;
		}, [] );
	}

	/**
	 * Get a list of values for input labels.
	 *
	 * @param {Array} labels Array of labels from the tokens.
	 * @return {Array} Array of valid values corresponding to the labels.
	 */
	 const getValuesForLabels = ( labels ) =>  {
		
		if ( returnFullObjects ) {
			return labels.reduce( ( acc, label ) => {
				Object.keys( validValues ).forEach( key => {
					if ( validValues[ key ] === label ) {
						acc.push( { value: key, label } );
					}
				} );

				return acc;
			}, [] );
		}

		return labels.map( label =>
			Object.keys( validValues ).find( key => validValues[ key ] === label )
		);
	}

	/**
	 * When a token is selected, we need to convert the string label into a recognized value suitable for saving as an attribute.
	 *
	 * @param {Array} tokenStrings An array of token label strings.
	 */
	const handleOnChange = ( tokenStrings ) => {
		onChange( getValuesForLabels( tokenStrings ) );
	}


	/**
	 * To populate the tokens, we need to convert the values into a human-readable label.
	 *
	 * @return {Array} An array of token label strings.
	 */
	 
	const getTokens = () => {
		return getLabelsForValues( tokens );
	}

	console.log("Suggestions",  suggestions.map( suggestion => suggestion.label ))
	console.log("tokens",  getTokens())
	return (
			<div className="govpack-autocomplete-tokenfield">
				<FormTokenField
					value={ getTokens() }
					suggestions={ suggestions.map( suggestion => suggestion.label ) }
					onChange={ tokens => handleOnChange( tokens ) }
					onInputChange={ input => debouncedUpdateSuggestions( input ) }
					label={ label }
		
				/>
				{ loading && <Spinner /> }
				{ help && <p className="govpack-autocomplete-tokenfield__help">{ help }</p> }
			</div>
	);
	
}


const AutocompleteWithSuggestions = (props) => {

	const {
		selectedItems = [], // Array of saved items.
		label = "",
		help = false,
		hideHelp = false, // If true, all help text will be hidden.
		fetchSuggestions,
		postTypes = [ { slug: 'post', label: 'Post' } ], // If passed, will render a selector to change the post type queried for suggestions.
		postTypeLabel = __( 'item', 'newspack' ), // String to describe the data being shown.
		postTypeLabelPlural = __( 'items', 'newspack' ), // Plural string to describe the data being shown.
		maxItemsToSuggest = 0, // If passed, will be used to determine "load more" state. Necessary if you want "load more" functionality when using a custom `fetchSuggestions` function.
		selectedPost = 0, // Legacy prop when single-select was the only option.
		onChange = false, // Function to call when selections change.
	} = props

	const [ postTypeToSearch, setPostTypeToSearch ] = useState( postTypes[ 0 ].slug );
	const [ isLoading, setIsLoading ] = useState( true );
	const [ isLoadingMore, setIsLoadingMore ] = useState( false );
	const [ suggestions, setSuggestions ] = useState( [] );

	/**
 	* Fetch recent posts to show as suggestions.
 	*/
	useEffect( () => {
		
		setIsLoading( true );
		handleFetchSuggestions( null, 0, postTypeToSearch )
			.then( _suggestions => {
				if ( 0 < _suggestions.length ) {
					setSuggestions( _suggestions );
				}
			} )
			.finally( () => setIsLoading( false ) );
	}, [ postTypeToSearch ] );


	/**
	 * Render a single suggestion object that can be clicked to select it immediately.
	 *
	 * @param {Object} suggestion Suggestion object with value and label keys.
	 */
	 const renderSuggestion = suggestion => {
		
		return (
			<Button isLink key={ suggestion.value } onClick={ () => handleOnChange( [ suggestion ] ) }>
				{ suggestion.label }
			</Button>
		);
	};

	/**
	 * Intercept onChange callback so we can decide whether to allow multiple selections.
	 */
	 const handleOnChange = _selections => {
		
		// Handle legacy `selectedPost` prop.
		const selections = selectedPost ? [ ...selectedItems, selectedPost ] : [ ...selectedItems ];

		// Loop through new selections to determine whether to add or remove them.
		_selections.forEach( _selection => {
			const existingSelection = selections.findIndex(
				selection => parseInt( selection.value ) === parseInt( _selection.value )
			);

			if ( -1 < existingSelection ) {
				// If the selection is already selected, remove it.
				selections.splice( existingSelection, 1 );
			} else {
				// Otherwise, add it.
				selections.push( _selection );
			}
		} );

		// Include currently selected post type in selection results.
		onChange( selections.map( selection => ( { ...selection, postType: postTypeToSearch } ) ) );
	};


	/**
	 * Render a list of suggestions that can be clicked to select instead of searching by title.
	 */
	 const RenderSuggestions = () => {
		if ( isLoading ) {
			return (
				<div className="newspack-autocomplete-with-suggestions__suggestions-spinner">
					<Spinner />
				</div>
			);
		}

		if ( 0 === suggestions.length ) {
			return null;
		}

		const className = 'newspack-autocomplete-with-suggestions__search-suggestions';

		return (
			<>
				{ ! hideHelp && (
					<p className="newspack-autocomplete-with-suggestions__label">
						{
							/* Translators: %s: the name of a post type. */ sprintf(
								__( 'Or, select a recent %s:', 'newspack' ),
								postTypeLabel
							)
						}
					</p>
				) }
				<div className={ className }>
					{ suggestions.map( renderSuggestion ) }
					{ suggestions.length < ( maxItemsToSuggest || maxSuggestions ) && (
						<Button
							disabled={ isLoadingMore }
							isSecondary
							onClick={ () => setIsLoadingMore( true ) }
						>
							{ isLoadingMore ? __( 'Loading…', 'newspack' ) : __( 'Load more', 'newspack' ) }
						</Button>
					) }
				</div>
			</>
		);
	};

	const classNames = [ 'govpack-autocomplete-with-suggestions' ];

	if ( hideHelp ) {
		classNames.push( 'hide-help' );
	}


	/**
	 * If passed a `fetchSuggestions` prop, use that, otherwise, build it based on the selected post type.
	 */
	const handleFetchSuggestions = fetchSuggestions
	 	? fetchSuggestions
	 	: async ( search = null, offset = 0, searchSlug = null ) => {
			const postTypeSlug = searchSlug || postTypeToSearch;
			const endpoint =
				 'post' === postTypeSlug || 'page' === postTypeSlug
					 ? postTypeSlug + 's' // Default post type endpoints are plural.
					 : postTypeSlug; // Custom post type endpoints are singular.
			const response = await apiFetch( {
				 parse: false,
				 path: addQueryArgs( '/wp/v2/' + endpoint, {
					 search,
					 offset,
					 per_page: suggestionsToFetch,
					 _fields: 'id,title',
				 } ),
			} );

			const total = parseInt( response.headers.get( 'x-wp-total' ) || 0 );
			const posts = await response.json();

			setMaxSuggestions( total );

			// Format suggestions for FormTokenField display.
			return posts.reduce( ( acc, post ) => {
				acc.push( {
					value: parseInt( post.id ),
					label: decodeEntities( post?.title.rendered ) || __( '(no title)', 'newspack' ),
				} );

				return acc;
			}, [] );
	   };


    return (
		<div className={ classNames.join( ' ' ) }>
			{ (selectedItems.length > 0) && (
				<div>Has Selected Items</div>
			)}
				<AutocompleteField 
					label = {label}
					help={ ! hideHelp && help }
					fetchSuggestions={ async search => handleFetchSuggestions( search, 0, postTypeToSearch ) }
					fetchSavedInfo={ postIds => handleFetchSaved( postIds ) }
					returnFullObjects
					onChange={ handleOnChange }
				/>
				< RenderSuggestions />
		</div>
	)
}

export {AutocompleteWithSuggestions}
export default AutocompleteWithSuggestions