/**
 * The term block reads its terms from the `profile` REST field of the profile
 * record it already has, so it sends no terms request of its own. That field
 * holds WP_Term data (`term_id`, no `id`) plus the archive `link`, and the
 * block renders `id`, `name`, `slug`, `taxonomy`, `parent` and `link`.
 */
import { getProfileTerms } from '../profile-terms';

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
	link: 'https://example.test/party/independent/',
};

describe( 'getProfileTerms()', () => {
	it( 'returns the field terms, each with an id', () => {
		expect( getProfileTerms( [ independent ], party ) ).toEqual( [
			{ ...independent, id: 7 },
		] );
	} );

	it( 'returns no terms while the taxonomy is still loading', () => {
		expect( getProfileTerms( [ independent ], undefined ) ).toEqual( [] );
	} );

	it( 'returns no terms for a taxonomy that is not publicly queryable', () => {
		const hidden = { ...party, visibility: { publicly_queryable: false } };

		expect( getProfileTerms( [ independent ], hidden ) ).toEqual( [] );
	} );

	it( 'returns no terms when the field is empty or not a term list', () => {
		expect( getProfileTerms( [], party ) ).toEqual( [] );
		expect( getProfileTerms( null, party ) ).toEqual( [] );
		expect( getProfileTerms( 'A Candidate', party ) ).toEqual( [] );
	} );

	it( 'ignores terms from another taxonomy', () => {
		const status = { slug: 'govpack_officeholder_status', visibility: { publicly_queryable: true } };

		expect( getProfileTerms( [ independent ], status ) ).toEqual( [] );
	} );
} );
