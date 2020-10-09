import Vue from "vue/dist/vue.js";
import app from "./App.vue";
import VueRouter from 'vue-router';
import routers from "./router.js";
import axios from 'axios';
import AES from "./src/js/AES.js";
import COM from "./src/js/common.js";

import 'mint-ui/lib/style.css'
import "./src/lib/mui/css/mui.min.css";
import "./src/lib/mui/css/icons-extra.css";

//组件 按需导入组件写道一块
import {
	Header,
	Swipe,
	SwipeItem,
	Button,
} from 'mint-ui';
Vue.component(Header.name, Header);
Vue.component(Swipe.name, Swipe);
Vue.component(SwipeItem.name, SwipeItem);
Vue.component(Button.name, Button);

import { InfiniteScroll } from 'mint-ui';
Vue.use(InfiniteScroll);

//路由
Vue.use(VueRouter);
var router = new VueRouter({
	routes: routers,
	linkActiveClass: "mui-active" //覆盖默认的路由高亮的类，默认的类叫做router-link-active
});

(function(doc, win) {
	var html = document.querySelector('html');
	html.style.fontSize = document.documentElement.clientWidth / 10 + 'px';
})(document, window);

//全局变量
Vue.prototype.axios=axios;
Vue.prototype.AES=AES;
Vue.prototype.COM=COM;
new Vue({
	el: "#app",
	data: {
		info:{}
	},
	methods: {
       
	},
	router: router,
	render: function(createElements) {
		//createElements是一个方法，调用它能够把指定的组件模板，渲染为html
		return createElements(app); //替换掉el容器
	}
});
