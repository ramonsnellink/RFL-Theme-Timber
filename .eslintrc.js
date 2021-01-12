module.exports = {
	root: true,
	env: {
		browser: true,
		es6: true,
		node: true,
	},
	parserOptions: {
		ecmaVersion: 6,
		sourceType: 'module',
	},
	extends: ['eslint:recommended', 'plugin:vue/recommended'],
	plugins: ['prettier'],
	rules: {
		'prettier/prettier': 'error',
	},
}
