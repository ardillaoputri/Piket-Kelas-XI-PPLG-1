/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        piket: {
          charcoal: '#17231F',
          forest: '#26372F',
          sage: '#3D5547',
          muted: '#829B8E',
          soft: '#D8D2B6',
          neutral: '#D5D6CB',
          accent: '#10B981',
        }
      },
      fontFamily: {
        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
      }
    },
  },
  plugins: [],
}