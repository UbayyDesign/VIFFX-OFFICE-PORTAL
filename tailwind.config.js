/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        gold: {
          DEFAULT: '#c9a227',
          light: '#e8bc38',
          dark: '#9e7e1e',
        },
        dark: {
          DEFAULT: '#0d0d0d',
          card: '#161616',
          sidebar: '#111111',
          card2: '#1a1a1a',
        }
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      }
    },
  },
  plugins: [],
}
