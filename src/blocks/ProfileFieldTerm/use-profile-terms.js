/**
 * WordPress dependencies
 */
import { useMemo } from '@wordpress/element';

/**
 * Internal dependencies
 */
import { getProfileTerms, isProfileLoading } from './profile-terms';

/**
 * Get a profile's terms for one taxonomy, from the profile record the block
 * already has. This sends no request of its own.
 *
 * @param {Object} profile      Profile record from core-data.
 * @param {Object} profileQuery Loading state from `useProfile()`.
 * @param {string} fieldKey     Key of the taxonomy field in the `profile` REST field.
 * @param {Object} taxonomy     Taxonomy object from core-data.
 */
export default function useProfileTerms( profile, profileQuery, fieldKey, taxonomy ) {
	const profileTerms = useMemo(
		() => getProfileTerms( profile, fieldKey, taxonomy ),
		[ profile, fieldKey, taxonomy ]
	);

	return {
		profileTerms,
		isLoading: isProfileLoading( profileQuery ),
		hasProfileTerms: profileTerms.length > 0,
	};
}
