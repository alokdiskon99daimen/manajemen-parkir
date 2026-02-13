import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    safelist: [
        'bg-green-500',
        'bg-red-500',
        'bg-yellow-500',
        'text-purple-600',
        'text-blue-600',
        'text-white',
        'px-2',
        'py-1',
        'rounded',
        'w-[80px]',
        'text-xs',
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}

