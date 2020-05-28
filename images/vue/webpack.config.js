var HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
    mode: 'development',
    resolve: {
        extensions: ['.js', '.vue']
    },
    module: {
        rules: [
            {
                test: /\.vue?$/,
                exclude: /(node_modules)/,
                use: 'vue-loader'
            },
            {
                test: /\.js?$/,
                exclude: /(node_modules)/,
                use: 'babel-loader'
            }
        ]
    },
    plugins: [new HtmlWebpackPlugin({
        template: './public/index.html'
    })],
    devServer: {
        historyApiFallback: true,
        host: '0.0.0.0',
        port: 8080
    },
    externals: {
        // global app config object
        config: JSON.stringify({
            apiUrl: process.env.VUE_APP_API_URL
        })
    },
}