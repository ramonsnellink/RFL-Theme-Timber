const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

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
		},
		colors: {
			transparent: 'transparent',
			current: 'currentColor',
			yellow: '#F6D15E',
			black: colors.black,
			white: colors.white,
			gray: {
				dark: '#1C1C1B',
				DEFAULT: '#807F7E',
				lighter: '#EBE9E6',
				light: '#F7F6F5'
			}
		},
		extend: {
			fontFamily: {
				sans: ['Inter', ...defaultTheme.fontFamily.sans]
			}
		}
	}
}
