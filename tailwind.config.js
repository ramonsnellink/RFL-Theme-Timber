module.exports = {
	darkMode: 'media',
	purge: ['assets/templates/**/*.twig'],
	plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
	theme: {
		container: {
			padding: {
				DEFAULT: '1rem',
				sm: '2rem',
				lg: '0rem'
			}
		}
	}
}
