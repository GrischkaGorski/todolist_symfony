/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.tsx",
    "./templates/**/*.html.twig",
    "./node_modules/flowbite/**/*.js"
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
    require('flowbite/plugin')
  ],
}

