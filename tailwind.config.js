const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {},
        colors: {
            'custom_blue': '#093773',
            'lightskyblue': '#87cefa',
            'info': '#11cdef',
            'dark': '#344767',
            'rebecca_purple': '#663399',
            'light_purple': '#9d65d0',
            'whitesmoke': '#f5f5f5',
            'transparent': 'transparent',
            'black': '#000',
            'white': '#fff',
            'red': '#f00',
            'danger': '#DC2626',
            'baseGray': '#9c9c9c',
            'success' : '#16a34a'
        },
        fontFamily: {
            sans: ['Poppins', ...defaultTheme.fontFamily.sans],
        },
        backgroundImage: {
            'auth': "url('/img/backgrounds/auth-bg.jpg')",
            'profileHeader': "url('/img/profile-header.jpg')",
            'homeHeader': "url('/img/backgrounds/home-header-bg.jpg')",
            'welcome': "url(/img/backgrounds/welcome-bg.jpg)"
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
