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

		// Bare year (e.g. a congress_year CSV cell): January 1 of that year.
		if ( preg_match( '/^\d{4}$/', $value ) ) {
			return self::plausible( self::strict_from_format( '!Y-m-d', $value . '-01-01' ) );
		}

		// Compact Ymd, only when it is a real calendar date; otherwise the
		// digits fall through to the epoch branch.
		if ( preg_match( '/^\d{8}$/', $value ) ) {
			$compact = self::strict_from_format( '!Ymd', $value );
			if ( null !== $compact ) {
				return self::plausible( $compact );
			}
		}

		// Remaining digit strings are millisecond epochs from the previous
		// editor control (negative for pre-1970 dates). No seconds support:
		// nothing in this codebase ever wrote epoch seconds, and a unit
		// heuristic misreads near-epoch milliseconds — the 1966-1973 band,
		// the demographic center of officeholder birth dates — as seconds.
		if ( preg_match( '/^-?\d+$/', $value ) ) {
			return self::plausible(
				( new \DateTime() )->setTimestamp( intdiv( (int) $value, 1000 ) )
			);
		}

		// A value shaped like Y-m-d is decided by the strict parse alone —
		// letting an invalid one (2021-02-31) fall through would hand it to
		// strtotime, which rolls it over to a different real date.
		if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $value ) ) {
			return self::plausible( self::strict_from_format( '!Y-m-d', $value ) );
		}

		// Free-form fallback (CSV-imported values). Require an explicit
		// 4-digit year so a partial value like "08/06" is rejected instead of
		// being silently completed with the current year, and reject anything
		// strtotime cannot parse instead of defaulting to now.
		if ( ! preg_match( '/\d{4}/', $value ) ) {
			return null;
		}

		$timestamp = strtotime( $value );
		if ( false === $timestamp ) {
			return null;
		}

		return self::plausible( ( new \DateTime() )->setTimestamp( $timestamp ) );
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
		$date = \DateTime::createFromFormat( $format, $value );
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
