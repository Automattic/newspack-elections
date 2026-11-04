const EMPTY_ARRAY = [];

/**
 * Get a profile's terms for one taxonomy from the profile record.
 *
 * The `profile` REST field already carries the terms of each taxonomy field,
 * so the term block reads them here instead of requesting them separately.
 *
 * @param {Object} profile  Profile record from core-data.
 * @param {string} fieldKey Key of the taxonomy field in the `profile` REST field.
 * @param {Object} taxonomy Taxonomy object from core-data.
 * @return {Array} The terms, each with the `id` the block renders.
 */
export function getProfileTerms( profile, fieldKey, taxonomy ) {
	if ( ! taxonomy?.visibility?.publicly_queryable ) {
		return EMPTY_ARRAY;
	}

	const terms = profile?.profile?.[ fieldKey ];
	if ( ! Array.isArray( terms ) || terms.length === 0 ) {
		return EMPTY_ARRAY;
	}

	return terms
		.filter( ( term ) => term?.taxonomy === taxonomy.slug )
		.map( ( term ) => ( {
			...term,
			id: term.id ?? term.term_id,
		} ) );
}

/**
 * Whether the term block is still waiting for its profile.
 *
 * Follows the profile request from `useProfile()`. A failed request, such as
 * for a deleted profile, is not loading, so the block shows its empty state
 * instead of a spinner.
 *
 * @param {Object} profileQuery Loading state from `useProfile()`.
 * @return {boolean} True while the profile request is in flight.
 */
export function isProfileLoading( profileQuery ) {
	return !! profileQuery?.isLoading && ! profileQuery?.hasFailed;
}
