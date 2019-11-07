const path = require('path');

//在终端的项目目录下webpack就能按照配文件执行
//参考webpack官方文档的配置说明
//这个配置文件，其实就是一个js文件，通过node中的模块操作，向外暴露了一个配置对象
//报错的话就仔细对比错误核查一下  ；
module.exports = {
	mode: "production", // "production" | "development" | "none"
	  mode: "production", // enable many optimizations for production builds
	  mode: "development", // enabled useful tools for development
	  mode: "none", // no defaults
  entry: path.resolve(__dirname,'src/main.js'), // string | object | array  // 这里应用程序开始执行//入口表示使用webpack打包哪个文件
  // webpack 开始打包

  output: {
    // webpack 如何输出结果的相关选项

    path: path.resolve(__dirname, "dist"), // string
    // 所有输出文件的目标路径
    // 必须是绝对路径（使用 Node.js 的 path 模块）

    filename: "bundle.js", // string    // 「入口分块(entry chunk)」的文件名模板（出口分块？）//指定输出文件的名称
  },
}