import FieldType from "./field"

import {isMatch} from "date-fns"

const MYSQL_DATE_FORMAT = "yyyy-MM-dd"

export default class DateField extends FieldType {

	static slug = "date"

	constructor(...args) {
		super(...args);
	}

	// Accept only results a profile date could plausibly hold; anything
	// outside renders as "no date" instead of an absurd year.
	plausible( dateValue ){
		if( isNaN( dateValue.getTime() ) ){
			return null
		}
		const year = dateValue.getUTCFullYear()
		return ( year >= 1500 && year <= 2500 ) ? dateValue : null
	}

	// The PHP twin of this contract is includes/Fields/DateValue.php — the
	// two resolve the same stored formats and change together.
	value( value = null){

		if(!value){
			return null
		}

		// Canonical editor format. UTC midnight, deliberately: the block
		// consumer formats via gmdate (UTC), and the PHP renderer parses the
		// same string as UTC midnight — all three then agree on the calendar
		// day regardless of the editor's timezone.
		if( isMatch(value, MYSQL_DATE_FORMAT) ) {
			return this.plausible( new Date( `${value}T00:00:00Z` ) )
		}

		// A value shaped like yyyy-MM-dd that failed the calendar-validity
		// check above (2021-02-31) is decided here — never handed to the
		// free-form fallback.
		if( /^\d{4}-\d{2}-\d{2}$/.test(value) ){
			return null
		}

		// Bare year (e.g. a congress_year CSV cell): January 1 of that year.
		if( /^\d{4}$/.test(value) ){
			return this.plausible( new Date( `${value}-01-01T00:00:00Z` ) )
		}

		// Compact yyyyMMdd. A valid calendar date resolves; an invalid one
		// whose leading digits read as a plausible year is a malformed date,
		// not an epoch — it must not fall through and render as January 1970.
		// Digits that cannot be a year (86400000) continue to the epoch branch.
		if( /^\d{8}$/.test(value) ){
			const compact = new Date( `${value.slice(0,4)}-${value.slice(4,6)}-${value.slice(6,8)}T00:00:00Z` )
			if( ! isNaN( compact.getTime() ) && compact.getUTCDate() === Number( value.slice(6,8) ) ){
				return this.plausible( compact )
			}
			const leadingYear = Number( value.slice(0,4) )
			if( leadingYear >= 1500 && leadingYear <= 2500 ){
				return null
			}
		}

		// Remaining digit strings are millisecond epochs from the previous
		// editor control (negative for pre-1970 dates). No seconds support:
		// nothing in this codebase ever wrote epoch seconds, and a unit
		// heuristic misreads near-epoch milliseconds — the 1966-1973 band —
		// as seconds. The instant's UTC calendar day is kept and its time of
		// day dropped, so every branch of this reader emits UTC midnight.
		if( /^-?\d+$/.test(value) ){
			const instant = new Date( Number(value) )
			if( isNaN( instant.getTime() ) ){
				return null
			}
			return this.plausible( new Date( Date.UTC( instant.getUTCFullYear(), instant.getUTCMonth(), instant.getUTCDate() ) ) )
		}

		// US-format m/d/Y (or m-d-Y) dates are validated component-wise: the
		// generic Date parser rolls an impossible 02/31/2021 into March
		// instead of rejecting it.
		const usShape = value.match( /^(\d{1,2})[/-](\d{1,2})[/-](\d{4})$/ )
		if( usShape ){
			const [ , month, day, year ] = usShape.map( Number )
			// Checked before construction: Date.UTC remaps years 0-99 into
			// 1900-1999, which would smuggle 0099 past the plausible() bound.
			if( year < 1500 || year > 2500 ){
				return null
			}
			const usDate = new Date( Date.UTC( year, month - 1, day ) )
			if( usDate.getUTCMonth() !== month - 1 || usDate.getUTCDate() !== day ){
				return null
			}
			return this.plausible( usDate )
		}

		// Free-form fallback (CSV-imported values). Require an explicit 4-digit
		// year so a partial value like "08/06" is rejected instead of being
		// silently completed with the current year.
		if( ! /\d{4}/.test(value) ){
			return null
		}

		// Rebuild the parsed calendar day at UTC midnight: the parse is
		// local-time, and every branch of this reader emits UTC midnight so
		// the block's gmdate consumer shows the same day in any timezone.
		const parsed = new Date(value)
		if( isNaN( parsed.getTime() ) ){
			return null
		}
		return this.plausible( new Date( Date.UTC( parsed.getFullYear(), parsed.getMonth(), parsed.getDate() ) ) )
	}
}

