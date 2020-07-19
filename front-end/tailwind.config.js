/*
** TailwindCSS Configuration File
**
** Docs: https://tailwindcss.com/docs/configuration
** Default: https://github.com/tailwindcss/tailwindcss/blob/master/stubs/defaultConfig.stub.js
*/
module.exports = {
  theme: {
    extend: {
      colors: {
        primary          : '#e40914',
        background       : '#1e1e1e',
        overlay_color    : '#000',
        form_bg          : '#7c7c7c',
        form_Slash_color : '#7c7c7c',
        facebook         : '#3b5998',
      },
      fontFamily: {
        primary_font : 'Ubuntu, sans-serif',
        second_font  : 'Lato, sans-serif',
      },
      fontSize: {
        '16' : '16px',
        '18' : '18px',
        '20' : '20px',
        '25' : '25px',
        '32' : '32px',
      },
      padding: {
        rl          : '0 5px',
        form_header : '1.5rem 0',
        '15'        : '15px',
      },
      margin: {
        '15': '15px',
        '30': '30px',
      },
      height: {
        login_form          : '41.55rem',
        register_form       : '52.65rem',
        forgot_form         : '38rem', // & Resend Verify Form Height
        reset_password_form : '42rem',
        profile_img         : '25rem',
        '20'                : '20rem'
      },
      width: {
        '27': '27rem',
        '15': '15rem'
      },
      inset: { // Top Left
        '1'  : '1rem',
        '2'  : '2.1rem',
        '3'  : '3rem',
        '4'  : '4rem',
        '6'  : '6px',
        '8'  : '8rem',
        '9'  : '9px',
        '10' : '10px',
        '11' : '11rem',
        '13' : '13px',
        '16' : '16rem',
        '025': '0.25rem',
      },
      zIndex: {
        '3': '3',
      },
      letterSpacing: { //tracking
        '1/2' : '1.2px',
        '1'   :  '1px',
      },
      lineHeight: { //leading-
        '0/7': '0.7',
        '3'  : '3',
        '4'  : '4.5',
      },
      screens: {
        'sm' : {'min': '576px',  'max': '767px'},
        'md' : {'min': '768px',  'max': '1023px'},
        'lg' : {'min': '1024px', 'max': '1279px'},
        'xl' : {'min': '1280px'},
      },
    },
  },
  variants: {},
  plugins: [],
  purge: {
    // Learn more on https://tailwindcss.com/docs/controlling-file-size/#removing-unused-css
    enabled: process.env.NODE_ENV === 'production',
    content: [
      'components/**/*.vue',
      'layouts/**/*.vue',
      'pages/**/*.vue',
      'plugins/**/*.js',
      'nuxt.config.js'
    ]
  }
}
