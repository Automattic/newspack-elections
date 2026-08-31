const defaultConfig = require( '@wordpress/scripts/config/jest-unit.config' );

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
