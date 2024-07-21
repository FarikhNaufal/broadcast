/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        fontFamily: {
            Inter: ['Inter', 'sans-serif']
        },
        extend: {
            colors: {
                'alert-success': '#EFFCEF',
                'body': '#f0f4f8'
            },
            fontSize: {
                '2xs': '0.625rem',
            },
        },
    },
    plugins: [
        require('daisyui'),
        require('@tailwindcss/typography')
    ],
    important: true,
    daisyui: {
        base: false,
        themes: [{
            light: {
                ...require("daisyui/src/theming/themes")["light"],
                // primary: "#153448",
                primary: '#212F3C',
            },
        }]
    }
}
