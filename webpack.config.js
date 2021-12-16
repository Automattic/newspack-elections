/**
 **** WARNING: No ES6 modules here. Not transpiled! ****
 */
/* eslint-disable import/no-nodejs-modules */

/**
 * External dependencies
 */
const getBaseWebpackConfig = require( '@automattic/calypso-build/webpack.config.js' );
const path = require( 'path' );
const webpack = require( 'webpack' );
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );

process.env.NODE_ENV = "development"
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
		},
		plugins: [
			...parentConfig.plugins,
			new DependencyExtractionWebpackPlugin()
		]

	}
}

//console.log(webpackConfig)

module.exports = webpackConfig;
