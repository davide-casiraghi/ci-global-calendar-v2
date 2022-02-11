const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
    content: [
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
        },
       colors: {
            // Brand colors
            primary: colors.cyan,
            secondary: colors.amber,
            neutral: colors.neutral,

            // Direct colors
            gray: colors.neutral,
            amber: colors.amber,
            cyan: colors.cyan,
            red: colors.red,
            blue: colors.sky,
            yellow: colors.amber,
            green: colors.green,
            indigo: colors.indigo,
            violet: colors.violet,

            black: '#000',
            white: '#fff',
            calendarGold: '#B5A575',
            calendarGoldHover: '#7f7454',
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
