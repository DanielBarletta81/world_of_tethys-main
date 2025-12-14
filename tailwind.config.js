const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.html',
    './src/**/*.{html,js,ts,jsx,tsx}',
    './public/**/*.html',
    './templates/**/*.html',
    './scripts/**/*.{js,ts}',
    './tethys-theme/**/*.{php,html}'
  ],
  theme: {
    extend: {
      colors: {
        abyss: {
          DEFAULT: '#040a13',
          900: '#03060f',
          950: '#010308'
        },
        lava: {
          100: '#ffe8dc',
          200: '#ffd3c1',
          300: '#ffb08a',
          400: '#ff7f5c',
          450: '#ff6d3d',
          500: '#ff3d1f'
        },
        ember: {
          300: '#f8a06b',
          400: '#ff885d',
          500: '#ff6233'
        },
        aurora: {
          300: '#5de0ff',
          400: '#37b7ff'
        }
      },
      backgroundImage: {
        'tethys-radial':
          'radial-gradient(circle at 25% 20%, rgba(255,111,72,0.28), transparent 60%), radial-gradient(circle at 80% 0%, rgba(72,149,239,0.22), transparent 45%), radial-gradient(circle at 10% 90%, rgba(255,48,15,0.18), transparent 55%), linear-gradient(180deg, rgba(1,4,10,0.98), rgba(2,8,18,0.95))'
      },
      fontFamily: {
        display: ['"Cinzel"', ...defaultTheme.fontFamily.serif],
        body: ['"Space Grotesk"', ...defaultTheme.fontFamily.sans]
      },
      boxShadow: {
        'soft-bronze': '0 10px 40px rgba(255, 118, 94, 0.25)',
        'lava-ring': '0 0 25px rgba(255, 100, 60, 0.45)',
        'ember-line': '0 0 45px rgba(242, 121, 75, 0.35)'
      },
      dropShadow: {
        'ember': ['0 0 12px rgba(255, 106, 80, 0.65)'],
        'aurora': ['0 0 20px rgba(55, 183, 255, 0.55)']
      },
      borderImage: {
        lava: 'linear-gradient(180deg, rgba(255,110,72,0.8), rgba(255,61,31,0.3)) 1'
      }
    }
  },
  plugins: []
};
