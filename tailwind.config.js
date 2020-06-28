module.exports = {
  purge: [
    './resources/views/**/*.blade.php',
    './resources/css/**/*.css',
  ],
  theme: {
    extend: {
        width: {
            '80': '20rem',
            '96': '24rem',
            '112': '28rem',
            '128': '32rem',
            '144': '36rem',
            '160': '40rem',
        },
        height: {
            '22': '5.5rem',
            '80': '20rem',
            '96': '24rem',
            '112': '28rem',
            '128': '32rem',
            '144': '36rem',
            '160': '40rem',
        }
    }
  },
  variants: {},
  plugins: [
    require('@tailwindcss/custom-forms')
  ]
}
