/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { RichText } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { ComboboxControl, SelectControl, Spinner } from '@wordpress/components';

const ProfileSelector = ( { props } ) => {
	// prettier-ignore
	const profiles = useSelect( select => select( 'core' ).getEntityRecords( 'postType', 'govpack_profiles', { per_page: 100 } ) );

	const profilesMapped = () => {
		if ( profiles ) {
			const mapped = profiles.map( profile => {
				return {
					value: profile.id,
					label: `${ profile.cmb2.id.first_name } ${ profile.cmb2.id.last_name }`,
				};
			} );

			return mapped;
		}
	};

	/**
	 * Handle profile selection.
	 *
	 * @param {number} profileId The selected Profile.
	 */
	const handleSelect = profileId => {
		if ( ! profileId ) {
			return;
		}

		props.setAttributes( { id: Number( profileId ) } );
	};

	const OutputControl = () => {
		const label = __( 'Pick a profile', 'govpack' );
		const options = profilesMapped();

		if ( ! options ) {
			return <Spinner />;
		}

		if ( options.length === 0 ) {
			return (
				<RichText tagName={ 'p' } value={ __( 'No profiles have been created', 'govpack' ) } />
			);
		}

		if ( options.length >= 25 ) {
			return (
				<ComboboxControl
					label={ label }
					options={ options }
					value={ props.attributes.id }
					onChange={ handleSelect }
					isLoading={ false }
					allowReset={ true }
				/>
			);
		}

		return (
			<SelectControl
				label={ label }
				options={ options }
				onChange={ handleSelect }
				value={ props.attributes.id }
			/>
		);
	};

	return <OutputControl />;
};

export default ProfileSelector;
