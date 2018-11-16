const path = require('path');
const webpack = require('webpack');
const CopyWebpackPlugin = require('copy-webpack-plugin');

const styleLoader = {
  loader: 'style-loader',
  options: {

  }
};

const cssLoader = {
  loader: 'css-loader',
  options: {

  }
};

const sassLoader = {
  loader: 'sass-loader',
  options: {
    sourceMap:true
  }
};

const resolveUrlLoader = {
  loader: 'resolve-url-loader',
  options: {

  }
};

module.exports = {
  entry: {
    acteur: './assets/js/acteur.js',
    layout: './assets/js/layout.js',
    login: './assets/js/login.js'
  },
  output: {
    path: path.resolve(__dirname, 'public', 'build'),
    filename: '[name].js',
    publicPath: '/build/'
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            cacheDirectory: true
          }
        }
      },
      {
        test: /\.css$/,
        use: [
          styleLoader,
          cssLoader
        ]
      },
      {
        test: /\.scss$/,
        use: [
          styleLoader,
          cssLoader,
          resolveUrlLoader,
          sassLoader
        ]
      },
      {
        test: /\.(png|jpg|jpeg|gif|ico|svg)$/,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: '[name]-[hash:6].[ext]'
            }
          }
        ]
      },
      {
        test: /\.(woff|woff2|eot|ttf|otf)$/,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: '[name]-[hash:6].[ext]'
            }
          }
        ]
      }
    ]
  },
  plugins: [
    new webpack.ProvidePlugin({
      jQuery: 'jquery',
      $: 'jquery',
    }),
    new CopyWebpackPlugin([
        // copies to {output}/static
        { from: './assets/static', to: 'static' }
    ]),
  ],
  devtool: 'inline-source-map'
};
