module.exports = {
    module: {
      rules: [
        {
          test: /\.styl$/,
          loader: "stylus-loader", // compiles Styl to CSS
        },
      ],
    },
    externals: {
      // .. other externals if any
      'vuejs-dialog': 'VuejsDialog'
    }
  };