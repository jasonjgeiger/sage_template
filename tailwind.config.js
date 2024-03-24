/** @type {import('tailwindcss').Config} config */
const config = {
  content: ['./app/**/*.php', './resources/**/*.{php,vue,js}'],
  theme: {
    screens: {
      sm: '480px',
      md: '768px',
      lg: '976px',
      xl: '1440px',
    },
    colors: {
      'Mint' 			  :'#86C8BC',
      'Gray' 			  :'#63666A',
      'Dark-Blue'		:'#005587',
      'Green' 		  :'#6FA287',
      'Teal' 			  :'#00B2A9',
      'Brown' 		  :'#6B4C4C',
      'Light-Blue' 	:'#6CACE4',
      'Tan' 			  :'#B7A99A',
      'Medium-Blue' :'#4E87A0',
      'Orange' 		  :'#E04E39',
      
    },
    fontFamily: {
      titillium: ['Titillium Web','sans-serif'],
      opensans: ['Open Sans', 'sans-serif'],
    },
    fontWeight: {
      light: '300',
      normal: '400',
      semibold: '600',
      bold: '700',
      black: '900'
    },
    fontSize:{
      xs: '0.5rem',
      sm: '0.75rem',
      base: '1rem',
      md: '1.25rem',
      lg: '2em',
      xl: '4rem',
    },
    extend: {

    }, // Extend Tailwind's default colors
  },
  plugins: [],
};

export default config;
