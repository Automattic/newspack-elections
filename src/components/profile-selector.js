/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { RichText } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { ComboboxControl, Spinner } from '@wordpress/components';

const ProfileSelector = ( { props } ) => {
	// prettier-ignore
	const profiles = useSelect( select => select( 'core' ).getEntityRecords( 'postType', 'govpack_profiles', { per_page: 100 } ) );


	const profilesMapped = () => {
		if ( profiles ) {
			const mapped = profiles.map( profile => {
				return {
					value: profile.id,
					label: `${ profile.meta.first_name } ${ profile.meta.last_name }`,
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
		const label = __( 'Select a profile', 'newspack-elections' );
		const options = profilesMapped();

		if ( ! options ) {
			return <Spinner />;
		}

		if ( options.length === 0 ) {
			return (
				<RichText tagName={ 'p' } value={ __( 'No profiles have been created', 'newspack-elections' ) } />
			);
		}

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
	};

	return <OutputControl />;
};

export default ProfileSelector;
