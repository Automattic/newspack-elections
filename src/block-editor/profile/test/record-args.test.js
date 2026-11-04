/**
 * The profile blocks and the core blocks inside them share one core-data
 * request per profile only while these arguments carry no query.
 */
import { getProfileRecordArgs } from '../record-args';

describe( 'getProfileRecordArgs()', () => {
	it( 'requests the plain profile record, with no query', () => {
		expect( getProfileRecordArgs( 12 ) ).toEqual( [ 'postType', 'govpack_profiles', 12 ] );
	} );
} );
