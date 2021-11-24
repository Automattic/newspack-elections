/**
 **** WARNING: No ES6 modules here. Not transpiled! ****
 */
/* eslint-disable import/no-nodejs-modules */

/**
 * External dependencies
 */
const getBaseWebpackConfig = require( '@automattic/calypso-build/webpack.config.js' );
const path = require( 'path' );

/**
 * Internal variables
 */
const editor = path.join( __dirname, 'assets', 'js', 'src', 'editor' );
const importer = path.join( __dirname, 'assets', 'js', 'src', 'importer' );

const parentConfig = getBaseWebpackConfig()

const webpackConfig = {
	...parentConfig,
	...{
		entry: { editor, importer },
		'output': {
			...parentConfig.output,
			...{"path" : path.join( __dirname, 'dist' )}
		},
		"resolve" : {
			...parentConfig.resolve,
			fallback: { 
				"path": require.resolve("path-browserify"),
				"util": require.resolve("util/")
			}
		},
		externals: {
			"react": "React",
			"react-dom": "ReactDOM"
		}

	}
}

console.log(webpackConfig)
module.exports = webpackConfig;
