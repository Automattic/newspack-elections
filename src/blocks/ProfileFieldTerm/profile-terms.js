const EMPTY_ARRAY = [];

/**
 * Get one taxonomy's terms from a profile field, shaped for the term block.
 *
 * The `profile` REST field carries each taxonomy field's terms as WP_Term data
 * (`term_id`, plus `link`), so the term block reads them from the profile
 * record instead of requesting them for each block. The block renders `id`.
 *
 * @param {Array}  terms    The field's value from the `profile` REST field.
 * @param {Object} taxonomy Taxonomy object from core-data.
 * @return {Array} The field's terms in that taxonomy, each with an `id`.
 */
export function getProfileTerms( terms, taxonomy ) {
	if ( ! taxonomy?.visibility?.publicly_queryable ) {
		return EMPTY_ARRAY;
	}

	if ( ! Array.isArray( terms ) || terms.length === 0 ) {
		return EMPTY_ARRAY;
	}

	return terms
		.filter( ( term ) => term?.taxonomy === taxonomy.slug )
		.map( ( term ) => ( {
			...term,
			id: term.term_id,
		} ) );
}
