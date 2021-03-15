module.exports = function ( grunt ) {
	const sass = require( 'node-sass' );

	// Load all grunt tasks
	require( 'matchdep' ).filterDev( 'grunt-*' ).forEach( grunt.loadNpmTasks );
	grunt.loadNpmTasks( '@lodder/grunt-postcss' );

	// Project configuration
	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),

		concat: {
			options: {
				stripBanners: true,
				sourceMap: false,
			},
			admin: {
				src: [ 'assets/js/src/admin.js' ],
				dest: 'assets/js/admin.src.js',
			},
			main: {
				src: [ 'assets/js/src/main.js' ],
				dest: 'assets/js/main.src.js',
			},
		},

		uglify: {
			all: {
				files: {
					'assets/js/admin.min.js': [ 'assets/js/admin.src.js' ],
					'assets/js/main.min.js': [ 'assets/js/main.src.js' ],
				},
				options: {
					mangle: {
						reserved: [ 'jQuery' ],
					},
					sourceMap: false,
				},
			},
		},

		eslint: {
			src: [ 'assets/js/src/**/*.js' ],
			options: {
				fix: true,
				configFile: '.eslintrc.js',
			},
		},

		stylelint: {
			src: [ 'assets/css/src/**/*.scss' ],
			options: {
				fix: true,
				configFile: '.stylelintrc',
			},
		},

		sass: {
			theme: {
				options: {
					implementation: sass,
					imagePath: 'assets/images',
					outputStyle: 'expanded',
					sourceMap: true,
				},
				files: [
					{
						expand: true,
						cwd: 'assets/css/src',
						src: [ '*.scss', '!_*.scss' ],
						dest: 'assets/css',
						ext: '.src.css',
					},
				],
			},
		},

		/*
		 * Runs postcss plugins
		 */
		postcss: {
			/* Runs postcss + autoprefixer on the minified CSS. */
			theme: {
				options: {
					map: false,
					processors: [ require( 'autoprefixer' )() ],
				},
				files: [
					{
						expand: true,
						cwd: 'assets/css',
						src: [ '*.src.css' ],
						dest: 'assets/css',
						ext: '.src.css',
					},
				],
			},
		},

		cssmin: {
			theme: {
				files: [
					{
						expand: true,
						cwd: 'assets/css',
						src: [ '*.src.css' ],
						dest: 'assets/css',
						ext: '.min.css',
					},
				],
			},
		},

		watch: {
			php: {
				files: [ '*.php', 'template-parts/**/*.php', 'includes/**/*.php', '!vendor/**' ],
				tasks: [ 'phplint', 'phpcbf' ],
			},

			css: {
				files: [ 'assets/css/src/**/*.scss' ],
				tasks: [ 'css' ],
				options: {
					debounceDelay: 500,
				},
			},

			scripts: {
				files: [ 'assets/js/src/**/*.js', 'assets/js/vendor/**/*.js' ],
				tasks: [ 'js' ],
				options: {
					debounceDelay: 500,
				},
			},
		},

		phplint: {
			phpArgs: {
				'-lf': null,
			},
			files: [ '*.php', 'template-parts/**/*.php', 'includes/**/*.php' ],
		},

		git_modified_files: {
			options: {
				diffFiltered: 'ACMRTUXB', // Optional: default is 'AMC',
				regexp: /\.php$/, // Optional: default is /.*/
			},
		},

		phpcs: {
			application: {
				src: '<%= gmf.filtered %>',
			},
			options: {
				bin: 'vendor/bin/phpcs',
			},
		},

		phpcbf: {
			options: {
				bin: 'vendor/bin/phpcbf',
				noPatch: false,
			},
			files: {
				src: [ '*.php', 'template-parts/**/*.php', 'includes/**/*.php' ],
			},
		},

		wp_readme_to_markdown: {
			theme: {
				files: {
					'readme.md': 'readme.txt',
				},
				options: {
					screenshot_url: 'screenshot.png',
				},
			},
		},
	} );

	// PHP Only
	grunt.registerTask( 'php', [ 'phplint', 'phpcs' ] );

	// JS Only
	grunt.registerTask( 'js', [ 'eslint', 'concat', 'uglify' ] );

	// CSS Only
	grunt.registerTask( 'css', [ 'stylelint', 'sass', 'postcss', 'cssmin' ] );

	// CSS & JS Only
	grunt.registerTask( 'css-js', [ 'css', 'js' ] );

	// Default task.
	grunt.registerTask( 'default', [ 'js', 'css', 'php' ] );
};
