const webpack = require("webpack");
const path = require("path");
const VueLoaderPlugin = require("vue-loader/lib/plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

const config = {
	target: "web",
	entry: {
		app: "./resources/js/app.js",
		auth: "./resources/js/auth.js",
		tsapp: "./resources/ts/app.ts",
	},
	output: {
		path: path.resolve(__dirname, "./public/js"),
		filename: "[name].bundle.js",
		publicPath: "http://localhost:8088/js/",
	},
	module: {
		rules: [
			{
				test: /\.vue$/,
				loader: "vue-loader",
			},
			{
				test: /\.tsx?$/,
				use: "ts-loader",
				exclude: /node_modules/,
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
		extensions: [".js", ".ts"],
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
		new webpack.HotModuleReplacementPlugin(),
	],

	devServer: {
		port: 8088,
		contentBase: path.resolve(__dirname, "./public"),
		hot: true,
		headers: {
			"Access-Control-Allow-Origin": "*",
		},
	},
};

module.exports = config;
