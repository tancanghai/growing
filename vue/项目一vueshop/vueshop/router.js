import home from "./src/components/home.vue";
import member from "./src/components/member.vue";
import cart from "./src/components/cart.vue";
import search from "./src/components/search.vue";
import news_list from "./src/components/news/news_list.vue";
import news_list_info from "./src/components/news/news_list_info.vue";
import phoshare from "./src/components/photo-share/phoshare.vue";

var routerobj = [
					{
						path: '/', 
						redirect: "/home"
				    },
					{
						path: '/home', 
						component: home
					},
					{
						path: '/member', 
						component: member
					},
					{
						path: '/cart', 
						component: cart
					},
					{
						path: '/search', 
						component: search
					},
					{
						path: '/home/news_list', 
						component: news_list
					},
					{
						path: '/home/news_list/news_list_info', 
						component: news_list_info
					},
					{
						path: '/home/phoshare', 
						component: phoshare
					},
				];
export default routerobj;