let instanceCount = 0;

export const useInstanceId = () => ++instanceCount;

export const compose = ( ...fns ) => ( value ) =>
	fns.reduceRight( ( acc, fn ) => fn( acc ), value );
