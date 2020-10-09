<template>
	<div class="cmt-container">
		<h3>发表评论</h3>
		<hr>
		<textarea placeholder="请输入内容(最多120字)" maxlength="120"></textarea>
		<mt-button type="primary" size="large">发表评论</mt-button>
		<div v-if="list.length>0">
			<ul class="ul-infinite-scroll" 
			v-infinite-scroll="loadMore" 
			infinite-scroll-disabled="loading"
			infinite-scroll-distance="distance">
				<li v-for="item in list">
					<div class="mui-card">
						<div class="mui-card-content">
							<div class="cmt-list">
								<div class="cmt-item">
									<div class="cmt-title">
										{{ item }}楼&nbsp;&nbsp;用户：匿名用户&nbsp;&nbsp;发表时间：2020-09-08
									</div>
									<div class="cmt-body"></div>
								</div>
							</div>
							<div class="mui-card-content-inner">
								这是第<span style="color: red;"><b>{{ item }}</b></span>篇文章的预览图、作者信息、点赞数量等
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
		<div v-else>
			<div style="margin: 10px;text-align: center;">很遗憾此人什么都没留下</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				list: [1,2,3,4,5],
				loading: false,
				distance: 10, //距离底部的距离
			}
		},
		created: function() {
			// this.loadMore();
		},
		methods: {
			loadMore: function() {
				this.loading = true;
				setTimeout(() => {
					let last = this.list[this.list.length - 1];
					for (let i = 1; i <= 5; i++) {
						this.list.push(last + i);
					}
					this.loading = null;
				}, 2500);
			},
		}
	}
</script>

<style scoped="scoped">
	.cmt-container {
		font-size: 18px;
	}

	textarea {
		font-size: 14px;
		height: 85px;
		margin: 0;
	}

	.cmt-list {
		margin: 5px 0;
	}

	.cmt-item {
		font-size: 13px;
	}

	.cmt-list .cmt-item .cmt-title {
		line-height: 35px;
		background-color: #aaffff;
	}

	.cmt-list .cmt-item .cmt-body {
		line-height: 35px;
		text-indent: 2em;
	}

	.ul-infinite-scroll {
		padding-left: 0;
	}

	li {
		list-style-type: none;
	}
</style>
