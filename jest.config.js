const defaultConfig = require( '@wordpress/scripts/config/jest-unit.config' );

// The date readers promise UTC calendar days. In a UTC process a local-time
// parse and a UTC parse are indistinguishable, so a run with no zone set
// defaults to a positive-offset one, where that regression fails. CI sets TZ
// itself to cover both signs.
process.env.TZ ??= 'Asia/Tokyo';

/**
 * The build treats @wordpress/* packages as webpack externals (supplied by the
 * editor at runtime), so they are absent from node_modules. Unit tests map them
 * to thin pass-through mocks in test/mocks/ — the plugin's own components and
 * logic under test stay real.
 */
module.exports = {
	...defaultConfig,
	moduleNameMapper: {
		...( defaultConfig.moduleNameMapper || {} ),
		'^@wordpress/components$': '<rootDir>/test/mocks/wp-components.js',
		'^@wordpress/compose$': '<rootDir>/test/mocks/wp-compose.js',
		'^@wordpress/core-data$': '<rootDir>/test/mocks/wp-core-data.js',
		'^@wordpress/data$': '<rootDir>/test/mocks/wp-data.js',
	},
};
