const path = require('path');
const webpack = require('webpack');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');
const WebpackChunkHash = require('webpack-chunk-hash');
const CleanWebpackPlugin = require('clean-webpack-plugin');

const useDevServer = false;
const useVersioning = true;
const publicPath = useDevServer ? 'http://localhost:8080/build/' : '/build/';
const isProduction = process.env.NODE_ENV === 'production';
const useSourcemaps = !isProduction;

const styleLoader = {
    loader: 'style-loader',
    options: {
        sourceMap: useSourcemaps
    }
};
const cssLoader = {
    loader: 'css-loader',
    options: {
        sourceMap: useSourcemaps,
        minimize: true
    }
};
const sassLoader = {
    loader: 'sass-loader',
    options: {
        sourceMap: true
    }
};
const resolveUrlLoader = {
    loader: 'resolve-url-loader',
    options: {
        sourceMap: useSourcemaps
    }
};

const webpackConfig = {
  entry: {
    acteur: './assets/js/acteur.js',
    layout: './assets/js/layout.js',
    login: './assets/js/login.js'
  },
   output: {
       path: path.resolve(__dirname, 'public', 'build'),
        filename: useVersioning ? '[name].[chunkhash:6].js' : '[name].js',
        publicPath: publicPath,
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
               use: ExtractTextPlugin.extract({
                   use: [
                       cssLoader
                   ],
                   // use this, if CSS isn't extracted
                   fallback: styleLoader
               }),
           },
           {
               test: /\.scss$/,
               use: ExtractTextPlugin.extract({
                   use: [
                       cssLoader,
                       resolveUrlLoader,
                       sassLoader,
                   ],
                   fallback: styleLoader
               }),
           },
           {
               test: /\.(png|jpg|jpeg|gif|ico|svg)$/,
               use: [
                   {
                       loader: 'file-loader',
                       options: {
                           name: '[name]-[hash:6].[ext]'
                       },
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
                       },
                   }
               ]
           }
       ]
   },
   plugins: [
       new webpack.ProvidePlugin({
           jQuery: 'jquery',
           $: 'jquery',
           'window.jQuery': 'jquery',
       }),
       new CopyWebpackPlugin([
           // copies to {output}/static
           { from: './assets/static', to: 'static' }
       ]),
       new webpack.optimize.CommonsChunkPlugin({
           name: [
               // "layout" is an entry file
               // anything included in layout, is not included in other output files
               'layout',
               // dumps the manifest into a separate file
               'manifest'
           ],
           minChunks: Infinity
       }),
       new ExtractTextPlugin(
          useVersioning ? '[name].[contenthash:6].css' : '[name].css'
       ),
       new ManifestPlugin({
           basePath: 'build/',
           // always dump manifest
           writeToFileEmit: true,
       }),
       new WebpackChunkHash(),

       // keep module ids consistent between builds
      // so that hashes doesn't suddenly change
      isProduction ? new webpack.HashedModuleIdsPlugin() : new webpack.NamedModulesPlugin(),

      new CleanWebpackPlugin('public/build/**/*.*')
   ],
   devtool: useSourcemaps ? 'inline-source-map' : false,
   devServer: {
       contentBase: './public',
       headers: { 'Access-Control-Allow-Origin': '*' },
   }
};
if (isProduction) {
   webpackConfig.plugins.push(
       new webpack.optimize.UglifyJsPlugin()
   );
   // passes these options to all loaders
   // but we should really pass these ourselves
   webpackConfig.plugins.push(
       new webpack.LoaderOptionsPlugin({
           minimize: true,
           debug: false
       })
   );
   webpackConfig.plugins.push(
       new webpack.DefinePlugin({
           'process.env.NODE_ENV': JSON.stringify('production')
       })
   );
}
module.exports = webpackConfig;
