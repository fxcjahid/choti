/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./vendor/**/laravel-editor-js-html/resources/**/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                theme: {
                    color: 'rgb(38 38 38)',
                    light: 'rgb(35 56 118)',
                },
                primary: { "50": "#eff6ff", "100": "#dbeafe", "200": "#bfdbfe", "300": "#93c5fd", "400": "#60a5fa", "500": "#3b82f6", "600": "#2563eb", "700": "#1d4ed8", "800": "#1e40af", "900": "#1e3a8a" }
            },
            screens: {
                '-2xl': { 'max': '1535px' },
                // => @media (max-width: 1535px) { ... }

                '-xl': { 'max': '1279px' },
                // => @media (max-width: 1279px) { ... }

                '-lg': { 'max': '1023px' },
                // => @media (max-width: 1023px) { ... }

                '-md': { 'max': '767px' },
                // => @media (max-width: 767px) { ... }

                '-sm': { 'max': '639px' },
                // => @media (max-width: 639px) { ... }
            },
            keyframes: {
                wiggle: {
                    '0%': { transform: 'rotate(0deg)' },
                    '80%': { transform: 'rotate(0deg)' },
                    '85%': { transform: 'rotate(2deg)' },
                    '95%': { transform: 'rotate(-2deg)' },
                    '100%': { transform: 'rotate(0deg)' }
                },
                shake: {
                    '10%, 90%': { transform: 'translate3d(-1px, 0, 0)' },
                    '20%, 80%': { transform: 'translate3d(2px, 0, 0)' },
                    '30%, 50%, 70%': { transform: 'translate3d(-4px, 0, 0)' },
                    '40%, 60%': { transform: 'translate3d(4px, 0, 0)' }
                }
            },
            animation: {
                wiggle: 'wiggle 4s infinite;',
                shake: 'shake 7s cubic-bezier(.36,.07,.19,.97) both',
            }
        },
    },
    plugins: [
        require('preline/plugin'),
        require('flowbite/plugin'),
        require("tailwindcss-animate"),
    ],
}
