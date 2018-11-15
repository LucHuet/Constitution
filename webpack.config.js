const path = require('path');
const webpack = require('webpack');

module.exports = {
  entry: {
    acteur: './public/assets/js/acteur.js',
    layout: './public/assets/js/layout.js'
  },
  output: {
    path: path.resolve(__dirname, 'public', 'build'),
    filename: '[name].js',
  },
  plugins: [
    new webpack.ProvidePlugin({
      jQuery: 'jquery',
      $: 'jquery',
    }),
  ]
};
