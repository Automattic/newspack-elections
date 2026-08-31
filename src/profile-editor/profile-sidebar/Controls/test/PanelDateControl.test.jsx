/**
 * Mechanism tests for the profile-sidebar date field (NPPM-3242).
 *
 * PanelDateControl routes a native date input (TextControl type="date")
 * through DefaultControl's meta wiring. The input's value is the ISO
 * `yyyy-MM-dd` string by the HTML spec — the same canonical form the meta
 * stores — so the string passes through with no parse step, and the persist
 * decision is DefaultControl's setMeta call, exercised here through a
 * stateful core-data mock.
 */
import { render, fireEvent } from '@testing-library/react';

import { PanelDateControl } from '../index';
import { __setMockMeta, __mockSetMeta } from '@wordpress/core-data';

const renderControl = () =>
	render(
		<PanelDateControl label="Date of Birth" meta_key="date_of_birth" onChange={ null } />
	);

describe( 'PanelDateControl', () => {
	beforeEach( () => {
		__setMockMeta( {} );
		__mockSetMeta.mockClear();
	} );

	it( 'displays the stored yyyy-MM-dd value in a date input, committing nothing on mount', () => {
		__setMockMeta( { date_of_birth: '1982-08-06' } );

		const { container } = renderControl();
		const input = container.querySelector( 'input' );

		expect( input.type ).toBe( 'date' );
		expect( input.value ).toBe( '1982-08-06' );
		expect( __mockSetMeta ).not.toHaveBeenCalled();
	} );

	it( 'commits an entered date to meta exactly once, as the yyyy-MM-dd string', () => {
		const { container } = renderControl();

		fireEvent.change( container.querySelector( 'input' ), {
			target: { value: '1980-12-25' },
		} );

		expect( __mockSetMeta ).toHaveBeenCalledTimes( 1 );
		expect( __mockSetMeta ).toHaveBeenCalledWith( { date_of_birth: '1980-12-25' } );
	} );

	it( 'commits clearing the field as an empty string, exactly once', () => {
		__setMockMeta( { date_of_birth: '1982-08-06' } );

		const { container } = renderControl();
		fireEvent.change( container.querySelector( 'input' ), {
			target: { value: '' },
		} );

		expect( __mockSetMeta ).toHaveBeenCalledTimes( 1 );
		expect( __mockSetMeta ).toHaveBeenCalledWith( { date_of_birth: '' } );
	} );

	it( 'renders a legacy epoch-string value as an empty field without touching meta', () => {
		__setMockMeta( { date_of_birth: '397526400000' } );

		const { container } = renderControl();

		expect( container.querySelector( 'input' ).value ).toBe( '' );
		expect( __mockSetMeta ).not.toHaveBeenCalled();
	} );
} );
