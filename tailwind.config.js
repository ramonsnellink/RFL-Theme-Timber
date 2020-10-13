module.exports = {
    purge: ["./templates/**/*.twig"],
    plugins: [
        require('@tailwindcss/typography')
    ],
    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true,
        defaultLineHeights: true,
        standardFontWeights: true,
    },
};
