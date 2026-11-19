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
        'dental-blue': '#1E6F9F',
        'dental-lilac': '#C8B6E2',
        'dental-lilac-dark': '#9F7AEA',
      },
    },
  },
  plugins: [],
}
