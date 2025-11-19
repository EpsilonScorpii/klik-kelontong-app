import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'kl-green': {
                    DEFAULT: '#6F8F72', // Warna Hijau Button (sesuai tebakan saya)
                    dark: '#3A5A40'     // Warna Hijau Logo (sesuai tebakan saya)
                },

                'primary': {
                    light: '#9EDF9C', // Sangat cerah
                    semi_dark: '#62825D', // Default shade/utama
                    dark: '#526E48', // Sangat gelap
                    DEFAULT: '#526E48', // Opsional: Tentukan default
                },
            }
        },
    },

    plugins: [forms],
};
