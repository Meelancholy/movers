module.exports = {
    content: [
      './resources/**/*.blade.php', // Ensure this scans Blade files
      './resources/**/*.js',
      './resources/**/*.vue',
      './resources/views/hr1/**/*.blade.php', // Include specific hr1 folder
    ],
    theme: {
      extend: {},
    },
    plugins: [],
  }
