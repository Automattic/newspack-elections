/**
 **** WARNING: No ES6 modules here. Not transpiled! ****
 */
/* eslint-disable import/no-nodejs-modules */

/**
 * External dependencies
 */
const CopyWebpackPlugin = require( 'copy-webpack-plugin' );
const getBaseWebpackConfig = require( '@automattic/calypso-build/webpack.config.js' );
const path = require( 'path' );

function getWebpackConfig( env, argv ) {
	const webpackConfig = getBaseWebpackConfig( env, argv );

	console.log("called")
	
	return {
		...webpackConfig,
		plugins: [
			...webpackConfig.plugins,
			new CopyWebpackPlugin( [
				{
					from: 'src/index.json',
					to: 'index.json',
				},
			] ),
		],
	};
}

console.log("asfas")
/**
 * Internal variables
 */

/*
const editor = path.join( __dirname, 'assets', 'js', 'src', 'editor' );
const importer = path.join( __dirname, 'assets', 'js', 'src', 'importer' );

const parentConfig = getWebpackConfig()

console.log(parentConfig)

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

module.exports = webpackConfig;
*/

module.exports = getWebpackConfig;

