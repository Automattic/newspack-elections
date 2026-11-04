/**
 * WordPress dependencies
 */
import { useMemo } from '@wordpress/element';

/**
 * Internal dependencies
 */
import { getProfileTerms } from './profile-terms';

/**
 * Get a profile field's terms for one taxonomy, from the profile record the
 * block already has. This sends no request of its own.
 *
 * @param {Array}  terms    The field's value from the `profile` REST field.
 * @param {Object} taxonomy Taxonomy object from core-data.
 */
export default function useProfileTerms( terms, taxonomy ) {
	const profileTerms = useMemo(
		() => getProfileTerms( terms, taxonomy ),
		[ terms, taxonomy ]
	);

	return {
		profileTerms,
		hasProfileTerms: profileTerms.length > 0,
	};
}
