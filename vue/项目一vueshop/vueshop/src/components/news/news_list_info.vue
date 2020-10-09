<template>
	<div class="newsinfo-container">
		<h3 class="title">新闻标题</h3>
		<p class="subtitle">
			<span>
				发表时间：2020-09-26 11:24:00
			</span>
			<span>
				点击：100次
			</span>
		</p>
		<hr>
			<pre style="color: red;">文章内容：
			接收参数：
			plan={{plan}}
			msg={{msg}}
			id={{id}}</pre>
		<comment-box></comment-box>
	</div>
</template>

<script>
	//导入评论区组件
	import comment from '../subcomponents/comment.vue';
	export default {
		data() {
			return {
				plan: "",
				msg: "",
			}
		},
		created: function() {
			this.plan = this.$route.query.plan;
			this.msg = this.$route.query.msg;
			this.id = this.$route.query.id;
		},
		components:{
			"comment-box":comment
		},
	}
</script>

<style>
.newsinfo-container{
	padding: 0 4px;
}
.newsinfo-container .title{
	font-size: 16px;
	text-align: center;
	margin: 15 0px;
	color: red;
}
.newsinfo-container .subtitle{
	font-size: 14px;
	color: #226AFF;
	display: flex;
	justify-content: space-between;
}
</style>
