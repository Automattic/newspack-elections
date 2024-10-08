/**
 **** WARNING: No ES6 modules here. Not transpiled! ****
 */
/* eslint-disable import/no-nodejs-modules */

//const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const getUpdatedWebpackConfig = require("./webpack.config.js")

const getProductionConfig = function(env, arg){
	let config = getUpdatedWebpackConfig(env, arg)
	config.mode = "production"
	config.devtool = false
	config.optimization.minimize = true
	//config.plugins.push( new BundleAnalyzerPlugin())
	return config
}

module.exports = getProductionConfig
