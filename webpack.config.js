const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
  entry: "./src/js/main.js", // Your JS entry file
  output: {
    path: path.resolve(__dirname, "dist"), // Output directory for bundled files
    filename: "bundle.js", // Compiled JS file
  },
  module: {
    rules: [
      {
        test: /\.js$/, // Process JS files
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
          options: {
            presets: ["@babel/preset-env"],
          },
        },
      },
      {
        test: /\.scss$/, // Process SASS files
        use: [
          MiniCssExtractPlugin.loader,
          "css-loader",
          "sass-loader", // Compiles Sass to CSS
        ],
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "styles.css", // Compiled CSS file
    }),
  ],
  devServer: {
    proxy: {
      "/": {
        target: "http://localhost/interview-task/", // Your local WordPress site
        changeOrigin: true,
      },
    },
    watchFiles: ["./**/*.php"], // Reload on PHP file changes
    port: 3000, // Webpack Dev Server Port
    open: false, // Prevent auto-opening browser
  },
  mode: "development", // Change to 'production' for minified output
};