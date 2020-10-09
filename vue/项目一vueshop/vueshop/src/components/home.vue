<template>
	<div>
		<mt-swipe :auto="4000">
			<mt-swipe-item v-for="(value,k) in urlData">
				<a :href="value" target="_blank">
					<img v-bind:src="value">
				</a>
			</mt-swipe-item>
		</mt-swipe>
		<div class="mui-content">
			<ul class="mui-table-view mui-grid-view mui-grid-9">
				<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">
					<router-link to="/home/news_list">
						<span class="mui-icon" style="position: relative;background: url(../source/image/news.png);width: 50px;height: 50px;background-size: cover;"></span>
						<div class="mui-media-body">新闻资讯</div>
					</router-link>
				</li>
				<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">
					<router-link to="/home/phoshare">
						<span class="mui-icon" style="position: relative;background: url(../source/image/share.png);width: 60px;height: 50px;background-size: cover;"></span>
						<div class="mui-media-body">图片分享</div>
					</router-link>
				</li>
				<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">
					<a href="#">
						<span class="mui-icon" style="position: relative;background: url(../source/image/cart.png);width: 50px;height: 50px;background-size: cover;"></span>
						<div class="mui-media-body">商品购买</div>
					</a>
				</li>
				<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">
					<a href="#">
						<span class="mui-icon" style="position: relative;background: url(../source/image/messege.png);width: 50px;height: 50px;background-size: cover;"></span>
						<div class="mui-media-body">留言反馈</div>
					</a>
				</li>
				<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">
					<a href="#">
						<span class="mui-icon" style="position: relative;background: url(../source/image/video.png);width: 50px;height: 50px;background-size: cover;"></span>
						<div class="mui-media-body">视频专区</div>
					</a>
				</li>
				<li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3"><a href="#">
						<span class="mui-icon" style="position: relative;background: url(../source/image/care.png);width: 50px;height: 50px;background-size: cover;"></span>
						<div class="mui-media-body">练习我们</div>
					</a>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
	import {
		Toast
	} from 'mint-ui';

	export default {
		data() {
			return {
				time: new Date().valueOf(),
				did: this.COM.GenNonDuplicateID(),
				urlData: {},
			}
		},
		created: function() {
			this.axios.post('http://www.vueshop.com/index.php/api/home/home_index', {
				id: 1
			}, {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
					"sign": this.AES._encrypt("time=" + this.time + "&did=" + this.did),
					"app-type": "ios",
					"version": "1.0",
					"did": this.did,
					"os": "3.4",
					"model": "sanxing1.2",
					"access_user_token": ""
				}
			}).then(response => {
					var data = response.data;
					if (data.status == 1) {
						this.urlData = data.data;
					} else {
						Toast({
							message: '获取失败',
							position: 'middle'
						});
					}
				}

			).catch(function(error) { // 请求失败处理
				console.log(error);
			});
		},
	}
</script>

<style scoped>
	.mint-swipe {
		height: 3.5rem;
	}

	.mint-swipe img {
		height: 100% !important;
		width: 100% !important;
	}

	.mui-table-view.mui-grid-view.mui-grid-9 {
		background-color: white;
		border: none;
	}

	.mui-table-view.mui-grid-view.mui-grid-9 li {
		border: none;
	}

	/* 	.mint-swipe-items-wrap>div:nth-child(1) {
		background-color: #007AFF !important;
	}

	.mint-swipe-items-wrap>div:nth-child(2) {
		background-color: #2AC845 !important;
	}

	.mint-swipe-items-wrap>div:nth-child(3) {
		background-color: #ff6208 !important;
	} */
</style>
