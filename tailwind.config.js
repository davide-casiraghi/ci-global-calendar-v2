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


    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],
};
