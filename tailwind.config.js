const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    mode: 'jit',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                body: ['Open Sans'],
                avenir: ['Avenir Next'],
            },
            gridTemplateColumns: {
                // Simple 12 column grid - Odd, this was missing, probably it can be removed in new versions.
                // Used in the HP search result table for md:grid-cols-12
                '12': 'repeat(12, minmax(0, 1fr))',
            }
        },
       colors: {
            // Brand colors
            primary: colors.cyan,
            secondary: colors.amber,
            neutral: colors.trueGray,

            // Direct colors
            gray: colors.trueGray,
            amber: colors.amber,
            cyan: colors.cyan,
            red: colors.red,
            blue: colors.sky,
            yellow: colors.amber,
            green: colors.green,
            indigo: colors.indigo,

            black: '#000',
            white: '#fff',
            transparent: 'transparent',
            current: 'currentColor',
        }
    },

    corePlugins: {
        tableLayout: true, // Enable table-fixed class for hp search result table
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],
};
