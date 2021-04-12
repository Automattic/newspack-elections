/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { RichText } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { ComboboxControl, Spinner } from '@wordpress/components';

const IssueSelector = ( { props } ) => {
	// prettier-ignore
	const issues = useSelect( select => select( 'core' ).getEntityRecords( 'postType', 'govpack_issues', { per_page: 100 } ) );

	const issuesMapped = () => {
		if ( issues ) {
			const mapped = issues.map( issue => {
				return {
					value: issue.id,
					label: issue.title.rendered,
				};
			} );

			return mapped;
		}
	};

	/**
	 * Handle issue selection.
	 *
	 * @param {number} issueId The selected Issue.
	 */
	const handleSelect = issueId => {
		if ( ! issueId ) {
			return;
		}

		props.setAttributes( { id: Number( issueId ) } );
	};

	const OutputControl = () => {
		const label = __( 'Select an issue', 'govpack' );
		const options = issuesMapped();

		if ( ! options ) {
			return <Spinner />;
		}

		if ( options.length === 0 ) {
			return <RichText tagName={ 'p' } value={ __( 'No issues have been created', 'govpack' ) } />;
		}

		return (
			<ComboboxControl
				label={ label }
				options={ options }
				value={ props.attributes.id }
				onChange={ handleSelect }
				isLoading={ false }
				allowReset={ true }
				// Required as it was originally mistakenly implemented as a required prop: https://github.com/WordPress/gutenberg/issues/29566
				onFilterValueChange={ () => {} }
			/>
		);
	};

	return <OutputControl />;
};

export default IssueSelector;
