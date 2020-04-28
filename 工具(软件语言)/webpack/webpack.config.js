const path = require('path');
const VueLoaderPlugin = require('vue-loader/lib/plugin')
module.exports = {
	 performance: {
	    hints: false
	  },
  mode: "production", // "production" | "development" | "none"  // Chosen mode tells webpack to use its built-in optimizations accordingly.

  entry: path.resolve(__dirname, "src/main.js"), // string | object | array  // 这里应用程序开始执行
  // webpack 开始打包

  output: {
    // webpack 如何输出结果的相关选项

    path: path.resolve(__dirname, "dist"), // string
    // 所有输出文件的目标路径
    // 必须是绝对路径（使用 Node.js 的 path 模块）

    filename: "bundle.js", // string    // 「入口分块(entry chunk)」的文件名模板（出口分块？）

     publicPath: "/dist/", // string    // 输出解析文件的目录，url 相对于 HTML 页面
    /* 高级输出配置（点击显示） */  },
	 module: {
	     rules: [
	       {
	         test: /\.css$/,
	         // use: [
	         //   { loader: 'style-loader' }, 
	         //   {
	         //     loader: 'css-loader',
	         //     options: {
	         //       modules: true
	         //     }
	         //   }
	         // ]
			 use: ['style-loader', 'css-loader']//webpack是从左向右加载的
	       },{
	         test: /\.(jpg|png|gif|bmp|jpeg)$/,
	         use: [
	           { loader: 'url-loader?limit=121450&name=[hash:8]-[name].[ext]' },
	         ]
	       },{
		   test: /\.vue$/,
		   loader: 'vue-loader'
		 },{
		   test: /\.(eot|woff|ttf)$/,
		   use: [
		     { loader: 'url-loader' },
			 { loader: 'file-loader' }
		   ]
		 }
	     ]
	   },
	   plugins: [
	       // 请确保引入这个插件！
	       new VueLoaderPlugin()
	     ]
	}