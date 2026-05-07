/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    './index.php',
    './api/**/*.php',
    './app/**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          DEFAULT: '#9c3800',
          dark: '#7e2c00',
          light: '#ffdbce',
        },
        accent: {
          DEFAULT: '#2e6a3a',
          light: '#b1f2b5',
        },
        canvas: '#fef8f1',
      },
      fontFamily: {
        headline: ['Plus Jakarta Sans', 'sans-serif'],
        body: ['Be Vietnam Pro', 'sans-serif'],
        inter: ['Inter', 'sans-serif'],
      },
      boxShadow: {
        soft: '0 20px 45px rgba(29, 27, 23, 0.08)',
      },
      zIndex: {
        '99999': '99999',
      },
    },
  },
  plugins: [],
};
