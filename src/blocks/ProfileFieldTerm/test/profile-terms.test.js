/**
 * Mechanism tests for the term block's term reader (NPPM-3832).
 *
 * The term block used to send its own terms request for every block, so a
 * post with many profiles sent hundreds of requests each time it opened. It
 * now reads the terms from the `profile` REST field of the profile record the
 * block already has. That field holds WP_Term data (`term_id`, no `id`) plus
 * the archive `link`, and the block renders `id`, `name`, `slug`, `taxonomy`,
 * `parent` and `link`.
 *
 * The block's loading state follows the profile request from `useProfile()`,
 * so a profile that fails to load, such as a deleted one, shows the empty
 * state instead of a spinner that never stops.
 */
import { getProfileTerms, isProfileLoading } from '../profile-terms';

const party = {
	slug: 'govpack_party',
	visibility: { publicly_queryable: true },
};

const independent = {
	term_id: 7,
	name: 'Independent',
	slug: 'independent',
	taxonomy: 'govpack_party',
	parent: 0,
	link: 'https://example.org/party/independent/',
};

const profile = {
	id: 12,
	profile: {
		party: [ independent ],
		status: [],
		name: 'A Candidate',
	},
};

describe( 'getProfileTerms()', () => {
	it( 'returns the field terms from the profile record, each with an id', () => {
		expect( getProfileTerms( profile, 'party', party ) ).toEqual( [
			{ ...independent, id: 7 },
		] );
	} );

	it( 'keeps an id the record already carries', () => {
		const withId = { profile: { party: [ { ...independent, id: 9 } ] } };

		expect( getProfileTerms( withId, 'party', party )[ 0 ].id ).toBe( 9 );
	} );

	it( 'returns no terms while the profile or the taxonomy is still loading', () => {
		expect( getProfileTerms( undefined, 'party', party ) ).toEqual( [] );
		expect( getProfileTerms( profile, 'party', undefined ) ).toEqual( [] );
	} );

	it( 'returns no terms for a taxonomy that is not publicly queryable', () => {
		const hidden = { ...party, visibility: { publicly_queryable: false } };

		expect( getProfileTerms( profile, 'party', hidden ) ).toEqual( [] );
	} );

	it( 'returns no terms when the field is empty, missing or not a term list', () => {
		expect( getProfileTerms( profile, 'status', party ) ).toEqual( [] );
		expect( getProfileTerms( profile, 'missing', party ) ).toEqual( [] );
		expect( getProfileTerms( profile, 'name', party ) ).toEqual( [] );
	} );

	it( 'ignores terms from another taxonomy', () => {
		const status = { slug: 'govpack_officeholder_status', visibility: { publicly_queryable: true } };

		expect( getProfileTerms( profile, 'party', status ) ).toEqual( [] );
	} );
} );

describe( 'isProfileLoading()', () => {
	it( 'is loading while the profile request is in flight', () => {
		const inFlight = {
			hasStartedLoading: true,
			hasFinishedLoading: false,
			hasFailed: false,
			hasLoaded: false,
			isLoading: true,
		};

		expect( isProfileLoading( inFlight ) ).toBe( true );
	} );

	it( 'stops loading once the profile has loaded', () => {
		const loaded = {
			hasStartedLoading: true,
			hasFinishedLoading: true,
			hasFailed: false,
			hasLoaded: true,
			isLoading: false,
		};

		expect( isProfileLoading( loaded ) ).toBe( false );
	} );

	it( 'stops loading when the profile request failed', () => {
		const failed = {
			hasStartedLoading: true,
			hasFinishedLoading: true,
			hasFailed: true,
			hasLoaded: false,
			isLoading: false,
		};

		expect( isProfileLoading( failed ) ).toBe( false );
		expect( isProfileLoading( { isLoading: true, hasFailed: true } ) ).toBe( false );
	} );

	it( 'is not loading without a profile request', () => {
		expect( isProfileLoading( undefined ) ).toBe( false );
		expect( isProfileLoading( {} ) ).toBe( false );
	} );
} );
