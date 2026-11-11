<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Fields;

defined( 'ABSPATH' ) || exit;

/**
 * Normalizes stored date-field meta values.
 *
 * Date meta has been written in several formats over the plugin's life:
 * canonical `Y-m-d` strings from the current editor control, millisecond
 * epoch strings from the previous control generation (negative for pre-1970
 * dates), and free-form strings — bare years, compact `Ymd` dates, locale
 * dates — from CSV imports. The sidebar and block readers resolve those
 * formats through this helper so an unparseable or implausible value becomes
 * null instead of leaking "now" or a current-year guess into output.
 *
 * The JS twin of this contract is src/block-editor/fields/field-types/date.js
 * — the two resolve the same stored formats and change together.
 */
class DateValue {

	/**
	 * Convert a stored meta value to a DateTime, or null when it does not
	 * carry an unambiguous, plausible date.
	 *
	 * @param mixed $value Raw meta value.
	 */
	public static function to_datetime( mixed $value ): ?\DateTime {

		if ( ! is_string( $value ) && ! is_int( $value ) && ! is_float( $value ) ) {
			return null;
		}

		$value = trim( (string) $value );

		if ( '' === $value ) {
			return null;
		}

		// ISO calendar dates, padded or not: the canonical editor format and
		// CSV cells written as 2021-2-3. Validated component-wise so an
		// impossible day (2021-2-31) is rejected rather than handed to
		// strtotime, which would roll it over to a different real date.
		if ( preg_match( '/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $value, $iso_shape ) ) {
			[ , $year, $month, $day ] = array_map( 'intval', $iso_shape );
			return self::calendar_date( $year, $month, $day );
		}

		// Bare year (e.g. a congress_year CSV cell): January 1 of that year.
		if ( preg_match( '/^\d{4}$/', $value ) ) {
			return self::calendar_date( (int) $value, 1, 1 );
		}

		// Compact Ymd. A valid calendar date resolves; an invalid one whose
		// leading digits read as a plausible year is a malformed date, not an
		// epoch — it must not fall through and render as January 1970. Digits
		// that cannot be a year (86400000) continue to the epoch branch.
		if ( preg_match( '/^\d{8}$/', $value ) ) {
			$compact = self::strict_from_format( '!Ymd', $value );
			if ( null !== $compact ) {
				return self::plausible( $compact );
			}
			$leading_year = (int) substr( $value, 0, 4 );
			if ( $leading_year >= 1500 && $leading_year <= 2500 ) {
				return null;
			}
		}

		// Remaining digit strings are millisecond epochs from the previous
		// editor control (negative for pre-1970 dates). No seconds support:
		// nothing in this codebase ever wrote epoch seconds, and a unit
		// heuristic misreads near-epoch milliseconds — the 1966-1973 band,
		// the demographic center of officeholder birth dates — as seconds.
		// The instant's time of day is dropped so every branch emits UTC
		// midnight, keeping the age math on calendar days rather than instants.
		//
		// Policy: the instant resolves to its UTC calendar day. The retired
		// writer stored browser-local midnight without recording the offset,
		// so a day authored at a positive UTC offset can read one day early —
		// that ambiguity is unrecoverable here and belongs to the import-time
		// migration follow-up; any individual profile is correctable in the
		// editor.
		if ( preg_match( '/^-?\d+$/', $value ) ) {
			$milliseconds = (int) $value;
			$timestamp    = intdiv( $milliseconds, 1000 );
			// intdiv truncates toward zero; milliseconds-to-seconds needs the
			// floor, or a negative instant just before midnight lands on the
			// next day and disagrees with the JS reader.
			if ( $milliseconds % 1000 < 0 ) {
				--$timestamp;
			}
			$date = ( new \DateTime( 'now', self::utc() ) )->setTimestamp( $timestamp );
			$date->setTime( 0, 0, 0 );
			return self::plausible( $date );
		}

		// US-format m/d/Y (or m-d-Y) dates are validated component-wise:
		// strtotime rolls an impossible 02/31/2021 into March instead of
		// rejecting it.
		if ( preg_match( '#^(\d{1,2})[/-](\d{1,2})[/-](\d{4})$#', $value, $us_shape ) ) {
			[ , $month, $day, $year ] = array_map( 'intval', $us_shape );
			return self::calendar_date( $year, $month, $day );
		}

		// Free-form fallback (CSV-imported values). Require an explicit
		// 4-digit year so a partial value like "08/06" is rejected instead of
		// being silently completed with the current year; reject a leading
		// year of five or more digits, which the parser reads as a different
		// year (10000-01-01 as 2000-01-01); and reject anything the parser
		// cannot read instead of defaulting to now. The parsed instant is taken
		// in UTC and its time of day dropped like every other branch.
		if ( ! preg_match( '/\d{4}/', $value ) || preg_match( '/^\d{5,}-/', $value ) ) {
			return null;
		}

		$date = date_create( $value, self::utc() );
		if ( false === $date ) {
			return null;
		}

		$date->setTimezone( self::utc() );
		$date->setTime( 0, 0, 0 );
		return self::plausible( $date );
	}

	/**
	 * Midnight UTC of a calendar day, or null when the components do not name
	 * a real, plausible day. checkdate() rejects an impossible day (February 31)
	 * that DateTime would otherwise roll over into the next month.
	 *
	 * @param int $year  Year.
	 * @param int $month Month, 1-12.
	 * @param int $day   Day of the month.
	 */
	private static function calendar_date( int $year, int $month, int $day ): ?\DateTime {
		if ( ! checkdate( $month, $day, $year ) ) {
			return null;
		}
		return self::plausible(
			self::strict_from_format( '!Y-m-d', sprintf( '%04d-%02d-%02d', $year, $month, $day ) )
		);
	}

	/**
	 * Every date here is built and read in UTC explicitly, so the calendar day
	 * matches the JS reader whatever the process default timezone is.
	 */
	private static function utc(): \DateTimeZone {
		return new \DateTimeZone( 'UTC' );
	}

	/**
	 * createFromFormat that also rejects rollover parses: PHP turns
	 * `2021-02-31` into 2021-03-03 with only a warning, which would render a
	 * different date than the one stored.
	 *
	 * @param string $format Date format.
	 * @param string $value  Value to parse.
	 */
	private static function strict_from_format( string $format, string $value ): ?\DateTime {
		$date = \DateTime::createFromFormat( $format, $value, self::utc() );
		if ( false === $date ) {
			return null;
		}
		$errors = \DateTime::getLastErrors();
		if ( is_array( $errors ) && ( $errors['warning_count'] > 0 || $errors['error_count'] > 0 ) ) {
			return null;
		}
		return $date;
	}

	/**
	 * Accept only results a profile date could plausibly hold; anything
	 * outside renders as "no date" instead of an absurd year.
	 *
	 * @param \DateTime|null $date Parsed date.
	 */
	private static function plausible( ?\DateTime $date ): ?\DateTime {
		if ( null === $date ) {
			return null;
		}
		$year = (int) $date->format( 'Y' );
		return ( $year >= 1500 && $year <= 2500 ) ? $date : null;
	}
}
