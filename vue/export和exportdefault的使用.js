export default{
	data:function(){
		return "this is a  function"
	},
	msg:"this is a msg",
	obj:{
		key:"key",value:"value"
	}
}
//通过export default暴露的成员通过import  com  from './exports.js'接收
export var titles={name:"name",ege:"old"}
export var num=12
//通过export 暴露的成员通过import {titles as title,num}  from './exports.js'接收
// console.log(com);
// console.log({title,num});

例如:
// import VueRouter from 'vue-router'
// import login from './vue/login.vue'
// import zuce from './vue/regit.vue'

//  Vue.use(VueRouter)
//  var routerobj = new VueRouter({
//  	routes: [ 
//  		{
//  			path: '/login',
//  			component: login
//  		}, 
//  		{
//  			path: '/zuce',
//  			component: zuce
//  		}
//  	]
//  });
//  export default routerobj;