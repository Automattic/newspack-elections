/**
 * Mechanism tests for the date field-type reader (NPPM-3242).
 *
 * Stored values arrive in mixed formats: canonical `yyyy-MM-dd` strings from
 * the current editor, millisecond-epoch strings from the previous control
 * generation (negative for pre-1970 dates), bare years and compact `yyyyMMdd`
 * dates from CSV imports. The reader must resolve every parseable class to a
 * UTC-midnight-consistent Date and return null for everything else — never an
 * Invalid Date instance, never a current-date guess.
 *
 * The PHP twin of this contract is includes/Fields/DateValue.php; the two
 * change together.
 */
import DateField, { ageInYears } from '../date';

const field = new DateField( { slug: 'date', label: 'Date' } );

describe( 'DateField.value()', () => {
	it( 'parses a canonical yyyy-MM-dd string to UTC midnight', () => {
		const value = field.value( '2026-08-11' );

		expect( value ).toBeInstanceOf( Date );
		expect( value.getUTCFullYear() ).toBe( 2026 );
		expect( value.getUTCMonth() ).toBe( 7 );
		expect( value.getUTCDate() ).toBe( 11 );
	} );

	it( 'parses a legacy millisecond-epoch string', () => {
		// 397526400000 ms = 4601 days = 1982-08-07T00:00:00Z.
		const value = field.value( '397526400000' );

		expect( value.getUTCFullYear() ).toBe( 1982 );
		expect( value.getUTCMonth() ).toBe( 7 );
	} );

	it( 'returns null for an impossible calendar date instead of rolling it over', () => {
		expect( field.value( '2021-02-31' ) ).toBeNull();
	} );

	it( 'reads an unpadded ISO date the same way the PHP reader does', () => {
		// The CSV importer stores cells as written, and the published page
		// renders 2021-2-3 as February 3, 2021; the editor must agree.
		const value = field.value( '2021-2-3' );

		expect( value.getUTCFullYear() ).toBe( 2021 );
		expect( value.getUTCMonth() ).toBe( 1 );
		expect( value.getUTCDate() ).toBe( 3 );
		expect( field.value( '1982-8-6' ).getUTCDate() ).toBe( 6 );
	} );

	it( 'ignores whitespace around a stored value, as the PHP reader does', () => {
		// The Date parser tolerates padding around most shapes; around an
		// epoch it gives up, so this is the shape that proves the trim.
		expect( field.value( ' 397526400000 ' ).getUTCDate() ).toBe( 7 );
	} );

	it( 'returns null for an impossible unpadded ISO date instead of rolling it over', () => {
		expect( field.value( '2021-2-31' ) ).toBeNull();
	} );

	it( 'returns null for an impossible US-format date instead of rolling it over', () => {
		expect( field.value( '02/31/2021' ) ).toBeNull();
	} );

	it( 'rejects a US-format year outside the plausible range instead of letting Date.UTC remap it', () => {
		// Date.UTC maps years 0-99 into 1900-1999; 01/01/0099 must not become 1999.
		expect( field.value( '01/01/0099' ) ).toBeNull();
	} );

	it( 'parses a negative millisecond-epoch string (a pre-1970 birth date)', () => {
		// -631152000000 ms = 1950-01-01T00:00:00Z.
		expect( field.value( '-631152000000' ).getUTCFullYear() ).toBe( 1950 );
	} );

	it( 'parses millisecond values near the epoch as milliseconds, not seconds', () => {
		// The 1966-1973 band is the demographic center of officeholder birth
		// dates; a magnitude cutoff misreads these as seconds.
		expect( field.value( '31536000000' ).getUTCFullYear() ).toBe( 1971 );
		expect( field.value( '77414400000' ).getUTCFullYear() ).toBe( 1972 );
		expect( field.value( '-63158400000' ).getUTCFullYear() ).toBe( 1968 );
	} );

	it( 'reads a bare four-digit year as January 1 of that year, within the plausible range', () => {
		const value = field.value( '1982' );

		expect( value.getUTCFullYear() ).toBe( 1982 );
		expect( value.getUTCMonth() ).toBe( 0 );
		expect( value.getUTCDate() ).toBe( 1 );
		expect( field.value( '0999' ) ).toBeNull();
	} );

	it( 'reads a compact yyyyMMdd date', () => {
		const value = field.value( '19820806' );

		expect( value.getUTCFullYear() ).toBe( 1982 );
		expect( value.getUTCMonth() ).toBe( 7 );
		expect( value.getUTCDate() ).toBe( 6 );
	} );

	it( 'returns null for an impossible compact date instead of reading it as an epoch', () => {
		// 20210231 (Feb 31) must not fall through to the millisecond branch,
		// where 20,210,231 ms would render as January 1970.
		expect( field.value( '20210231' ) ).toBeNull();
	} );

	it( 'normalizes an epoch value with a time of day to UTC midnight', () => {
		// 397551600000 ms = 1982-08-07T07:00:00Z; the age math and the gmdate
		// consumer both need the calendar day, not the instant.
		const value = field.value( '397551600000' );

		expect( value.getUTCDate() ).toBe( 7 );
		expect( value.getUTCHours() ).toBe( 0 );
	} );

	it( 'parses a free-form imported value to UTC midnight in any timezone', () => {
		// The block consumer formats via gmdate (UTC); a local-midnight parse
		// would preview one day early in positive-offset browsers.
		const value = field.value( '08/06/1982' );

		expect( value.getUTCFullYear() ).toBe( 1982 );
		expect( value.getUTCMonth() ).toBe( 7 );
		expect( value.getUTCDate() ).toBe( 6 );
		expect( value.getUTCHours() ).toBe( 0 );
	} );

	it( 'returns null for a digit string whose resulting year is implausible', () => {
		expect( field.value( '12345678901234567' ) ).toBeNull();
	} );

	it( 'returns null, never an Invalid Date, for unparseable input', () => {
		expect( field.value( 'not a date at all' ) ).toBeNull();
	} );

	it( 'returns null for a partial date with no year, instead of inventing one', () => {
		expect( field.value( '08/06' ) ).toBeNull();
	} );
} );

describe( 'ageInYears()', () => {
	// 17:00 UTC on 2026-09-10 is already 2026-09-11 in Asia/Tokyo and still
	// 2026-09-10 in America/Chicago, so a local-time reading splits from the
	// UTC day the published page uses, in either direction.
	const now = new Date( '2026-09-10T17:00:00Z' );

	it( 'counts whole years on UTC calendar days, matching the published age', () => {
		expect( ageInYears( '1988-09-11', now ) ).toBe( 37 );
		expect( ageInYears( '1988-09-10', now ) ).toBe( 38 );
	} );

	it( 'reads a legacy millisecond-epoch date of birth', () => {
		// 397526400000 ms = 1982-08-07.
		expect( ageInYears( '397526400000', now ) ).toBe( 44 );
	} );

	it( 'returns null for a future or unusable date of birth', () => {
		expect( ageInYears( '2030-01-01', now ) ).toBeNull();
		expect( ageInYears( 'not a date at all', now ) ).toBeNull();
		expect( ageInYears( '', now ) ).toBeNull();
	} );
} );
