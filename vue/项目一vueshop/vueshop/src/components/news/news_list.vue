<template>
	<div class="mui-content">
		<ul class="mui-table-view" >
			<li class="mui-table-view-cell mui-media" v-for="(v,k) in dataJson">
				<router-link :to="{ path: '/home/news_list/news_list_info', query: { plan: 'private',msg:'success',id:v.id}}">
					<!-- <img class="mui-media-object mui-pull-left" src="https://www.dcloud.net.cn/hellomui/images/shuijiao.jpg"> 带http可以加载-->
					<!-- <img class="mui-media-object mui-pull-left" src="../../source/image/shuijiao.png">  img相对路径不能加载-->
					<img class="mui-media-object mui-pull-left" v-bind:src="v.src">
					<div class="mui-media-body">
						<span class="span-head">{{v.spanHead}}</span>
						<p class='mui-ellipsis'>
							<span>{{v.time}}</span>
							<span>{{v.clickNum}}</span>
						</p>
					</div>
				</router-link>
			</li>
		</ul>
	</div>
</template>

<style scoped="scoped">
	.mui-table-view {
		font-size: 0.5rem;
	}

	.span-head {
		font-size: 0.4rem;
		font-weight: bold;
	}

	.mui-ellipsis {
		color: #226aff;
	}

	.mui-ellipsis>span:first-child {
		float: left;
	}

	.mui-ellipsis>span:nth-child(2) {
		float: right;
	}
</style>

<script>
	export default {
		data() {
			return {
				dataJson: {},
			}
		},
		created: function() {
			var clickNum="点击:100次";
			var time="发表时间:2020-09-26 11:24:00";
			var src="";
			var spanHead="";
			for(var i=0;i<20;i++){
				if(i%2==0){
					src="/src/source/image/cbd.jpg";
					spanHead="CBD";
				}else{
					src="/src/source/image/muwu.jpg";
					spanHead="木屋";
				}
				this.dataJson[i]={
					"clickNum":clickNum,
					"time":time,
					"src":src,
					"spanHead":spanHead,
					"id":i,
				};
			}
		},
	}
</script>
