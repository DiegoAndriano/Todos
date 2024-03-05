/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        './app/Filament/**/*.php'
    ],
    theme: {
        extend: {
            transitionProperty: {
                DEFAULT: 'padding, box-shadow,background-color, border-color, color, fill, stroke, opacity, transform',
                'spacing': 'padding',
            },
        },
    },
    plugins: [],
    variants: {
        extend: {},
        placeholderColor: ['hover', 'focus', 'responsive'],
        padding: ['hover', 'focus', 'responsive'],
        cursor: ['hover', 'focus', 'responsive'],
    },
}
