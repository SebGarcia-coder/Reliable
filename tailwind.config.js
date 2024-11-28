/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './index.html',
    './src/**/*.{vue,js,ts,jsx,tsx}',
  ],
  theme: {
    extend: {
      colors: {
        "custom-green": "#85B633",
        "custom-green-hover": "#B0EF47",
        "custom-blue": "#3A606E",
        "custom-green-cluebox": "#C2D8B9",
        "custom-burgondy": "#773838",
        "custom-burgondy-hover": "#b25858",
        "custom-dark-green": "#4B5842"

      },
      fontFamily: {
        sans: ['Impact', 'sans-serif'],
      },
      transitionDelay: {
        100: '100ms',
        200: '200ms',
        300: '300ms',
        1000: '1000ms',
      },
    },
  },
  plugins: [],
  safelist: [
    'bg-custom-green',
    'hover:bg-custom-green-hover',
    "bg-custom-blue",
    "bg-custom-green-cluebox",
    "bg-custom-burgondy",
    "hover:bg-custom-burgondy-hover",
    "bg-custom-dark-green"

  ],
}

