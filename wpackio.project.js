const packageJson = require('./package.json')

module.exports = {
	appName: 'jackpine',
	type: 'theme',
	slug: 'jackpine',
	bannerConfig: {
		name: packageJson.name,
		author: packageJson.author,
		license: packageJson.license,
		link: packageJson.homepage,
		version: packageJson.version,
		copyrightText: `This software is released under the ${packageJson.license} License (https://opensource.org/licenses/${packageJson.license})`,
		credit: true
	},
	files: [
		{
			name: 'app',
			entry: {
				main: ['./assets/js/app.js', './assets/sass/app.scss']
			},
			webpackConfig: undefined
		}
	],
	outputPath: 'dist',
	hasReact: false,
	disableReactRefresh: false,
	hasSass: true,
	hasLess: false,
	hasFlow: false,
	externals: {},
	alias: undefined,
	errorOverlay: true,
	optimizeSplitChunks: true,
	watch: [
		'assets/templates/**/*.twig',
		'src/**/*.php',
		'theme/**/*.php',
		'views/blocks/*.twig'
	],
	packageFiles: [
		'dist/**',
		'assets/templates/**',
		'theme/**',
		'vendor/**',
		'*.md',
		'LICENSE'
	],
	packageDirPath: 'package'
}
