const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const { getWebpackEntryPoints, getPackageProp, hasPackageProp} = require("@wordpress/scripts/utils")
const { basename } = require( 'path' );


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

module.exports = {
    ...defaultConfig,
	"entry": getEntryPoints
};  