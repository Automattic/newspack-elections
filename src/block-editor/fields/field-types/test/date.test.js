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
import DateField from '../date';

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

	it( 'reads a bare four-digit year as January 1 of that year', () => {
		const value = field.value( '1982' );

		expect( value.getUTCFullYear() ).toBe( 1982 );
		expect( value.getUTCMonth() ).toBe( 0 );
		expect( value.getUTCDate() ).toBe( 1 );
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
