const webpack = require("webpack");
const path = require("path");
const VueLoaderPlugin = require("vue-loader/lib/plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

const config = {
	entry: {
		app: "./resources/js/app.js",
		auth: "./resources/js/auth.js",
	},
	output: {
		path: path.resolve(__dirname, "./public/js"),
		filename: "[name].bundle.js",
	},
	module: {
		rules: [
			{
				test: /\.vue$/,
				loader: "vue-loader",
			},
			{
				test: /\.js$/,
				use: "babel-loader",
				exclude: /node_modules/,
			},
			{
				test: /\.css$/,
				use: ["vue-style-loader", "css-loader"],
			},
			{
				test: /\.s(c|a)ss$/,
				use: [
					"vue-style-loader",
					"css-loader",
					{
						loader: "sass-loader",
						options: {
							implementation: require("sass"),
							sassOptions: {
								includePaths: ["./resources/sass"],
								fiber: require("fibers"),
							},
						},
					},
				],
			},
			{
				test: /\.(woff|woff2|eot|ttf|otf)$/,
				loader: "file-loader",
				options: {
					outputPath: "../fonts",
				},
			},
		],
	},
	resolve: {
		extensions: [".js", ".vue"],
		alias: {
			"@": path.resolve(__dirname, "./resources"),
		},
	},
	plugins: [
		new VueLoaderPlugin(),
		new MiniCssExtractPlugin({
			filename: "../css/[name].css",
			chunkFilename: "[id].css",
		}),
	],
};

module.exports = config;
