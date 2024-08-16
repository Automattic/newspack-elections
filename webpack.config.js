let defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const { getWebpackEntryPoints, getPackageProp, hasPackageProp,getWordPressSrcDirectory } = require("@wordpress/scripts/utils")
const { basename } = require( 'path' );
const CopyWebpackPlugin = require("copy-webpack-plugin");
const { optimize } = require('svgo');
const TerserPlugin = require( 'terser-webpack-plugin' );

function getEntryPoints(){
	return {
		...getWebpackEntryPoints("script")(),
		...getEntryPointsFromPackage()
	}
}

function pathToEntry(path){
	const entryName = basename( path, '.js' );

	if ( ! path.startsWith( './' ) ) {
		path = './' + path;
	}

	return [ entryName, path ];
};

const terserOptions = {
	parallel: true,
	terserOptions: {
		output: {
			comments: /translators:/i,
		},
		compress: {
			passes: 2,
			drop_console: true
		},
		mangle: {
			reserved: [ '__', '_n', '_nx', '_x' ],
		},
	},
	extractComments: false,
}

/*
const minifier = new TerserPlugin( terserOptions )
*/

function getEntryPointsFromPackage(){
	
	let entryPoints = {}
	
	
	if(!hasPackageProp('config')){
		return entryPoints
	}

	const pkgConfig = getPackageProp("config")
	if(!pkgConfig.hasOwnProperty("entrypoints")){
		return entryPoints
	}

	if(Array.isArray(pkgConfig.entrypoints)){

		pkgConfig.entrypoints.forEach( (path, index) => {
			const [ entryName, entryPath ] = pathToEntry(path)
			entryPoints[entryName] = entryPath
		});

	} else if(typeof pkgConfig.entrypoints === "object"){

		entryPoints = {
			...entryPoints,
			...pkgConfig.entrypoints
		}
	}
	


	return entryPoints

}

defaultConfig = {
	...defaultConfig,
	optimization : {
		...defaultConfig.optimization,
		minimizer : [
			new TerserPlugin( terserOptions )
		]
	},
	plugins: [
		...defaultConfig.plugins,
		new CopyWebpackPlugin({
			patterns: [{
				context: getWordPressSrcDirectory(),
				from : "assets/icons/**/*.svg",
				to : "icons/[name][ext]",
				transform : {
					transformer(content, absoluteFrom) {
						//console.log(content.toString())
						//return content.toString();
						let result = optimize(content.toString())
						return result.data;
					}
				}
			}]
		})
	]
}

module.exports = {
    ...defaultConfig,
	"entry": getEntryPoints
};  