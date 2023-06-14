/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.tsx",
    "./templates/**/*.html.twig"
  ],
  theme: {
    extend: {
      fontSize: {
        '2xs': '0.5rem'
      },
      lineHeight: {
        '2xs': '0.5rem'
      }
    },
  },
  plugins: [
  ],
}

