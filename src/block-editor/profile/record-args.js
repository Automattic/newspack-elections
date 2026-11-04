import { PROFILE_POST_TYPE } from './constants';

/**
 * Arguments for core-data's `getEntityRecord()` when loading a profile.
 *
 * Core blocks inside a profile, such as the featured image, load the record
 * with these same arguments and no query, so core-data fetches each profile
 * once. Adding a query here, such as `_embed` or `context`, gives the profile
 * blocks a second request per profile.
 *
 * @param {number|string} profileId ID of the profile.
 * @return {Array} Arguments for `getEntityRecord()`.
 */
export function getProfileRecordArgs( profileId ) {
	return [ 'postType', PROFILE_POST_TYPE, profileId ];
}
