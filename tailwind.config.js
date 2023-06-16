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
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            spacing: {
                '600': '60vh',
                '1/8': '12%'
            },
            animation: {
                'slider-1': 'slider-1 12s linear infinite',
                'slider-2': 'slider-2 12s linear infinite',
                'slider-3': 'slider-3 12s linear infinite',
                'slider-4': 'slider-4 12s linear infinite',
                'zoom-out': 'zoom-out 3s linear infinite',
                'zoom-in': 'zoom-in 3s linear infinite'
            },
            keyframes: {
                'slider-1': {
                    '25%': {visibility: 'visible'},
                    '0%, 50%, 75%, 100%': {visibility: 'hidden'}
                },
                'slider-2': {
                    '50%': {visibility: 'visible'},
                    '0%, 25%, 75%, 100%': {visibility: 'hidden'}
                },
                'slider-3': {
                    '75%': {visibility: 'visible'},
                    '0%, 25%, 50%, 100%': {visibility: 'hidden'}
                },
                'slider-4': {
                    '100%': {visibility: 'visible'},
                    '0%, 25%, 50%, 75%': {visibility: 'hidden'}
                },
                'zoom-in': {
                    '100%': {
                        width: '110%'
                    }
                },
                'zoom-out': {
                    '0%': {
                        width: '110%'
                    }
                }
            }
        },
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
            'welcome': "url('/img/backgrounds/welcome-bg.jpg')",
            'aboutImageBox': "url('/img/backgrounds/plane-front.jpg')",
            'aboutBottomBox': "url('/img/backgrounds/sky.jpg')",
            'services': "url('/img/backgrounds/services-bg.jpg')",
            'contact': "url('/img/backgrounds/contact-bg.jpg')",
            'travel-1': "url('/img/services/headers/travel-1.jpg')",
            'travel-2': "url('/img/services/headers/travel-2.jpg')",
            'travel-3': "url('/img/services/headers/travel-3.jpg')",
            'travel-4': "url('/img/services/headers/travel-4.jpg')",
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'), require('flowbite/plugin')],
};
