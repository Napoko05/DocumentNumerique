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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['"Plus Jakarta Sans"', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50:  '#EFF6FF',
                    100: '#DBEAFE',
                    200: '#BFDBFE',
                    300: '#93C5FD',
                    400: '#60A5FA',
                    500: '#3B82F6',
                    600: '#2563EB',
                    700: '#1D4ED8',
                    800: '#1E40AF',
                    900: '#1E3A8A',
                    950: '#172554',
                },
                accent: {
                    50:  '#FFFBEB',
                    100: '#FEF3C7',
                    200: '#FDE68A',
                    300: '#FCD34D',
                    400: '#FBBF24',
                    500: '#F59E0B',
                    600: '#D97706',
                    700: '#B45309',
                    800: '#92400E',
                    900: '#78350F',
                },
                surface: {
                    DEFAULT: '#FFFFFF',
                    soft:    '#F8FAFC',
                    muted:   '#F1F5F9',
                },
                ink: {
                    DEFAULT: '#0F172A',
                    soft:    '#334155',
                    muted:   '#64748B',
                    faint:   '#94A3B8',
                },
                sidebar: {
                    DEFAULT:       '#0F172A',
                    hover:         '#1E293B',
                    active:        '#1E40AF',
                    text:          '#CBD5E1',
                    'text-active': '#FFFFFF',
                },
            },
        },
    },

    plugins: [forms],
};