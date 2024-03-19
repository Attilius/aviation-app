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
            aspectRatio: {
                '1/3': '1 / 3',
            },
            spacing: {
                '1300': '130vh',
                '600': '60vh',
                '500': '50vh',
                '1/11': '95%',
                '9/1': '90%',
                '4/5.2': '82%',
                '1/13.5': '79%',
                '1/13': '77%',
                '1/19': '48.5%',
                '1/15': '45%',
                '1/3.3': '30%',
                '1/5': '20%',
                '1/7': '16.7%',
                '1/8': '12%',
                '1/10.5': '10.5%',
                '1/10': '10%',
                '1/24': '6%',
                '1/20': '5%',
                '1/33': '3%',
                '16.5': '66px',
                '137.5': '550px',
                '133': '532px',
                '130': '520px',
                '125': '500px',
                '120': '480px',
                '110': '440px',
                '38': '152px',
                '30': '120px',
                '29.5': '118px',
                '26': '104px',
                '22': '88px',
                '18': '69px',
                '0.25': '1px'
            },
            boxShadow: {
                '3xl': '2px 2px 5px rgba(0, 0, 0, 1)',
                'danger': ''
            },
            animation: {
                'slider-1': 'slider-1 12s linear infinite',
                'slider-2': 'slider-2 12s linear infinite',
                'slider-3': 'slider-3 12s linear infinite',
                'slider-4': 'slider-4 12s linear infinite',
                'spin': 'spin 1s linear infinite',
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
                spin: {
                    'from': { transform: 'rotate(0deg)' },
                    'to': { transform: 'rotate(360deg)' },
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
            'dirtiLightBlue': '#8bc5e8',
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
            'textGray': '#ced4da',
            'linghtGray': '#ececec',
            'success' : '#16a34a',
            'shadow-skin': 'rgba(1, 1, 1, .6)',
            'custom-blue-alfa-1': 'rgba(9, 55, 115, .1)',
            'custom-blue-alfa-5': 'rgba(9, 55, 115, .5)',
            'custom-blue-alfa-8': 'rgba(9, 55, 115, .8)',
            'custom-blue-alfa-9': 'rgba(9, 55, 115, .9)',
            'travel-guide-skin': 'rgba(5, 16, 57, .6)',
            'white-alfa-8': 'rgba(255, 255, 255, .8)',
            'white-alfa-6': 'rgba(255, 255, 255, .6)',
            'black-alfa-6': 'rgba(0, 0, 0, .3)'
        },
        fontFamily: {
            sans: ['Poppins', ...defaultTheme.fontFamily.sans],
        },
        backgroundImage: {
            'auth': "url('/img/backgrounds/auth-bg.jpg')",
            'profileHeader': "url('/img/profile-header.jpg')",
            'homeHeader': "url('/img/backgrounds/home-header-bg.jpg')",
            'welcome': "url('/img/backgrounds/welcome-bg.jpg')",
            'userProfileImage': "url('/img/persons/demo_user.jpg')",
            'aboutImageBox': "url('/img/backgrounds/plane-front.jpg')",
            'aboutBottomBox': "url('/img/backgrounds/sky.jpg')",
            'services': "url('/img/backgrounds/services-bg.jpg')",
            'contact': "url('/img/backgrounds/contact-bg.jpg')",
            'booking': "url('/img/backgrounds/airport.jpg')",
            'ancillariesHeader': "url('/img/header/airport.jpg')",
            'payment': "url('/img/payment/online-payments.jpg')",
            'paymentSuccesfull': "url('/img/payment/payment-success.jpg')",
            'paymentCancel': "url('/img/payment/payment-cancel.jpg')",
            'tripSummaryHeader': "url('/img/header/trip-summary.jpg')",
            'paris': "url('/img/cities/paris.jpg')",
            'london': "url('/img/cities/london.jpeg')",
            'rome': "url('/img/cities/rome.jpg')",
            'montreal': "url('/img/cities/montreal.jpg')",
            'athens': "url('/img/cities/athens.jpg')",
            'barcelona': "url('/img/cities/barcelona.jpg')",
            'cairo': "url('/img/cities/cairo.jpg')",
            'istanbul': "url('/img/cities/istanbul.jpg')",
            'lisbon': "url('/img/cities/lisbon.png')",
            'munich': "url('/img/cities/munich.jpg')",
            'new_york': "url('/img/cities/new-york.jpg')",
            'zurich': "url('/img/cities/zurich.jpg')",
            'rental_car': "url('/img/services/car.jpg')",
            'booking_hotel': "url('/img/services/hotel.jpg')"
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'), require('flowbite/plugin')],
};
