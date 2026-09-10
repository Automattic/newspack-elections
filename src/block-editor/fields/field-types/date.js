import FieldType from "./field"

const inPlausibleRange = ( year ) => year >= 1500 && year <= 2500

// Accept only results a profile date could plausibly hold; anything outside
// renders as "no date" instead of an absurd year.
const plausible = ( dateValue ) => {
	if( isNaN( dateValue.getTime() ) ){
		return null
	}
	return inPlausibleRange( dateValue.getUTCFullYear() ) ? dateValue : null
}

// UTC midnight of a calendar day, or null when the components do not name a
// real, plausible day. The year is checked before construction because
// Date.UTC remaps years 0-99 into 1900-1999, and the round-trip check rejects
// an impossible day (February 31) instead of letting Date roll it over.
const calendarDate = ( year, month, day ) => {
	if( ! inPlausibleRange( year ) ){
		return null
	}
	const date = new Date( Date.UTC( year, month - 1, day ) )
	if( date.getUTCMonth() !== month - 1 || date.getUTCDate() !== day ){
		return null
	}
	return date
}

/**
 * Resolve a stored date-field meta value to a UTC-midnight Date, or null.
 *
 * The PHP twin of this contract is includes/Fields/DateValue.php — the two
 * resolve the same stored formats and change together.
 */
export function normalizeDate( value = null ){

	value = String( value ?? "" ).trim()

	if( ! value ){
		return null
	}

	// ISO calendar dates, padded or not: the canonical editor format and CSV
	// cells written as 2021-2-3. UTC midnight, deliberately: the block
	// consumer formats via gmdate (UTC), and the PHP renderer parses the same
	// string as UTC midnight — all three then agree on the calendar day
	// regardless of the editor's timezone.
	const isoShape = value.match( /^(\d{4})-(\d{1,2})-(\d{1,2})$/ )
	if( isoShape ){
		const [ , year, month, day ] = isoShape.map( Number )
		return calendarDate( year, month, day )
	}

	// Bare year (e.g. a congress_year CSV cell): January 1 of that year.
	if( /^\d{4}$/.test(value) ){
		return calendarDate( Number( value ), 1, 1 )
	}

	// Compact yyyyMMdd. A valid calendar date resolves; an invalid one
	// whose leading digits read as a plausible year is a malformed date,
	// not an epoch — it must not fall through and render as January 1970.
	// Digits that cannot be a year (86400000) continue to the epoch branch.
	if( /^\d{8}$/.test(value) ){
		const compact = new Date( `${value.slice(0,4)}-${value.slice(4,6)}-${value.slice(6,8)}T00:00:00Z` )
		if( ! isNaN( compact.getTime() ) && compact.getUTCDate() === Number( value.slice(6,8) ) ){
			return plausible( compact )
		}
		if( inPlausibleRange( Number( value.slice(0,4) ) ) ){
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
		return plausible( new Date( Date.UTC( instant.getUTCFullYear(), instant.getUTCMonth(), instant.getUTCDate() ) ) )
	}

	// US-format m/d/Y (or m-d-Y) dates are validated component-wise: the
	// generic Date parser rolls an impossible 02/31/2021 into March
	// instead of rejecting it.
	const usShape = value.match( /^(\d{1,2})[/-](\d{1,2})[/-](\d{4})$/ )
	if( usShape ){
		const [ , month, day, year ] = usShape.map( Number )
		return calendarDate( year, month, day )
	}

	// Free-form fallback (CSV-imported values). Require an explicit 4-digit
	// year so a partial value like "08/06" is rejected instead of being
	// silently completed with the current year.
	if( ! /\d{4}/.test(value) ){
		return null
	}

	// Rebuild the parsed calendar day at UTC midnight: every branch of this
	// reader emits UTC midnight so the block's gmdate consumer shows the same
	// day in any timezone. Out of scope here, because no writer in this
	// plugin produces them: ISO strings carrying a time or zone, year-month
	// values, and dotted d.m.Y dates can resolve to a different day than the
	// PHP reader.
	const parsed = new Date(value)
	if( isNaN( parsed.getTime() ) ){
		return null
	}
	return plausible( new Date( Date.UTC( parsed.getFullYear(), parsed.getMonth(), parsed.getDate() ) ) )
}

/**
 * Whole years between a stored date of birth and `now`, counted on UTC
 * calendar days — the basis the PHP age uses (CPT::age_from_epoc), so the
 * editor preview and the published page agree. Null when the value is not a
 * usable date or lies in the future.
 */
export function ageInYears( value, now = new Date() ){
	const birth = normalizeDate( value )
	if( ! birth || birth > now ){
		return null
	}
	const beforeBirthday = now.getUTCMonth() < birth.getUTCMonth()
		|| ( now.getUTCMonth() === birth.getUTCMonth() && now.getUTCDate() < birth.getUTCDate() )
	return now.getUTCFullYear() - birth.getUTCFullYear() - ( beforeBirthday ? 1 : 0 )
}

export default class DateField extends FieldType {

	static slug = "date"

	constructor(...args) {
		super(...args);
	}

	value( value = null ){
		return normalizeDate( value )
	}
}
