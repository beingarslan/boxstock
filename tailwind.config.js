/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.{vue,js}",
  ],

  // ./src/**/*.{vue,js,ts,jsx,tsx}
  extend: {
    fontFamily: {
      TTcommons: ['TTCommons', 'sans-serif'],
      Poppins: ['Poppins', 'sans-serif'],
    }, //end of fontFamily
  },
  theme: {
    extend: {},
  },
  plugins: [],
}