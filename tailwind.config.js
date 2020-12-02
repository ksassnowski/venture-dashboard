module.exports = {
    future: {
        // removeDeprecatedGapUtilities: true,
        // purgeLayersByDefault: true,
    },
    purge: {
        content: [
            "./resources/views/**/*.blade.php",
            "./resources/js/**/*.vue",
        ],
        whitelistPatternsChildren: [/nprogress/],
    },
    theme: {
        extend: {
            colors: {
                laravel: "#ff2d20",
            },
        },
    },
    variants: {},
    plugins: [],
};
