const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin');
module.exports = {
  plugins: [
    new VuetifyLoaderPlugin(),
  ],
  /*
  module: {
    rules: [
      {
        test: /\.s(c|a)ss$/,
        use: [
          'vue-style-loader',
          'css-loader',
          {
            loader: 'sass-loader',
            options: {
              implementation: require('sass'),
              fiber: require('fibers'),
              indentedSyntax: true // optional
            }
          }
        ]
      }
    ]
  },
  */
};