// Stateful meta mock: lets component tests exercise DefaultControl's real
// persist decision (value read + setMeta write) without a REST layer.
let currentMeta = {};

export const __setMockMeta = ( meta ) => {
	currentMeta = meta;
};

export const __mockSetMeta = jest.fn( ( edits ) => {
	currentMeta = { ...currentMeta, ...edits };
} );

export const useEntityProp = () => [ currentMeta, __mockSetMeta ];
export const useEntityId = () => 1;
