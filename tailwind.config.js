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
            '124': '31rem',
            '128': '32rem',
            '144': '36rem',
            '148': '37rem',
            '152': '38rem',
            '156': '39rem',
            '160': '40rem',
            '224': '56rem',
            '240': '60rem',
        },
        height: {
            '22': '5.5rem',
            '80': '20rem',
            '84': '21rem',
            '88': '22rem',
            '92': '23rem',
            '96': '24rem',
            '112': '28rem',
            '124': '31rem',
            '128': '32rem',
            '132': '33rem',
            '136': '34rem',
            '140': '35rem',
            '144': '36rem',
            '160': '40rem',
            '224': '56rem',
            '240': '60rem',
        }
    }
  },
  variants: {},
  plugins: [
    require('@tailwindcss/custom-forms'),
    require('@tailwindcss/ui'),
  ]
}
