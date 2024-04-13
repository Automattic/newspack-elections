/**
 * External dependencies
 */
 import InputMask from 'react-input-mask';
 import classnames from 'classnames';


 /**
  * WordPress dependencies
  */
 import { useInstanceId } from '@wordpress/compose';
 import { forwardRef } from '@wordpress/element';
 
 import { BaseControl } from '@wordpress/components';
 
 function UnforwardedTextControl(
	 props,
	 ref
 ) {
	 const {
		 label,
		 hideLabelFromVision,
		 value,
		 help,
		 className,
		 onChange,
		 type = 'text',
		 isValid,
		 isTouched,
		 maskProps = {},
		 ...additionalProps
	 } = props;
	 const instanceId = useInstanceId( MaskedTextControl );
	 const id = `inspector-text-control-${ instanceId }`;
	 const onChangeValue = ( event ) =>
		 onChange( event.target.value );
	 
	let inputBaseClassName = 'components-text-control__input'
	const inputClassName = classnames(
		inputBaseClassName,
		{
			[`${inputBaseClassName}--invalid`]: (!props.isValid && props.isTouched)
		}
	)

	 return (
		 <BaseControl
			 label={ label }
			 hideLabelFromVision={ hideLabelFromVision }
			 id={ id }
			 help={ help }
			 className={ className }
		 >
			 <InputMask
			 	
				className={inputClassName}
				type={ type }
				id={ id }
				value={ value }
				onChange={ onChangeValue }
				aria-describedby={ !! help ? id + '__help' : undefined }
				inputRef={ ref }
				{ ...maskProps }
				{ ...additionalProps }

			 />
		 </BaseControl>
	 );
 }
 
 /**
  * TextControl components let users enter and edit text.
  *
  *
  * @example
  * ```jsx
  * import { TextControl } from '@wordpress/components';
  * import { useState } from '@wordpress/element';
  *
  * const MyTextControl = () => {
  *   const [ className, setClassName ] = useState( '' );
  *
  *   return (
  *     <TextControl
  *       label="Additional CSS Class"
  *       value={ className }
  *       onChange={ ( value ) => setClassName( value ) }
  *     />
  *   );
  * };
  * ```
  */
 export const MaskedTextControl = forwardRef( UnforwardedTextControl );
 
 export default MaskedTextControl;