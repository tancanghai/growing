<!DOCTYPE html>
<html class="x-admin-sm">

<head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.2</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8" />
<!--    <meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0">-->
    <link rel="stylesheet" href="/assets/css/font.css">
    <link rel="stylesheet" href="/assets/css/xadmin.css">
    <link rel="stylesheet" href="/assets/common/custom.css">
    <script type="text/javascript" src="/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="/assets/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/assets/js/xadmin.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="layui-fluid">
    <div class="layui-row">
        <div class="guide">
            <div class="guide-item on">
                <span>1</span>
                <p>填写活动信息</p>
            </div>
            <!-- /.guide-item -->
            <div class="guide-item">
<!--            <div class="guide-item  over   on">-->
                <span>2</span>
                <p>创建问卷(问卷星)</p>
            </div>
            <!-- /.guide-item -->
            <div class="guide-item ">
                <span>3</span>
                <p>抽奖配置</p>
            </div>
            <div class="guide-item ">
                <span>4</span>
                <p>完成</p>
            </div>
            <!-- /.guide-item -->
        </div>
        <!-- /.guide -->
    </div>
    <div class="layui-row">
        <div class="layui-col-md9 layui-col-md-offset3">

            <form class="layui-form" >
                <div class="layui-form-item">
                    <label for="act_name" class="layui-form-label">
                        <span class="x-red">*</span>活动名称：
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="act_name" name="act_name" lay-verify="required|act_name"
                               autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>活动名称必填
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label for="act_name" class="layui-form-label">
                            <span class="x-red">*</span>活动时间：
                        </label>
                        <div class="layui-inline" id="test6">
                            <div class="layui-input-inline">
                                <input type="text" lay-verify="required" autocomplete="off" id="test-startDate-1" name="begin_time" class="layui-input" placeholder="开始日期" >
                            </div>
                            <div class="layui-form-mid">-</div>
                            <div class="layui-input-inline">
                                <input type="text" autocomplete="off" id="test-endDate-1" lay-verify="required"  name="end_time"  class="layui-input" placeholder="结束日期" >
                            </div>
                            <div class="layui-form-mid layui-word-aux">
                                <span class="x-red">*</span>活动时间必填
                            </div>
                        </div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="act_name" class="layui-form-label">
                        <span class="x-red">*</span>业务部门：
                    </label>
                    <div class="layui-input-inline">
                        <select name="deptId" lay-verify="required" lay-search="">
                            <option value="">业务部门</option>
                            <option value="1">信息部</option>
                            <option value="2">生产部</option>
                        </select>
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>业务部门必填
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="act_name" class="layui-form-label">
                        <span class="x-red">*</span>参与用户：
                    </label>
                    <div class="layui-input-inline">
                        <select name="user_identity" lay-verify="required" lay-search="">
                            <option value="">参与用户</option>
                            <option value="0">消费者</option>
                            <option value="1">零售户</option>
                            <option value="3">零售户店长</option>
                            <option value="9">零售户店主</option>
                        </select>
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>参与用户必填
                    </div>
                </div>


                <div class="layui-form-item x-city" id="start">
                    <label  class="layui-form-label">
                        <span class="x-red">*</span>活动区域：
                    </label>
                    <div class="layui-input-inline">
                        <select name="province" lay-filter="province" lay-verify="required">
                            <option value="">请选择省</option>
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select name="city" lay-filter="city" lay-verify="required">
                            <option value="">请选择市</option>
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select name="area" lay-filter="area" lay-verify="required">
                            <option value="">请选择县/区</option>
                        </select>
                    </div>
                </div>

                <div class="layui-form-item layui-row">
                    <label class="layui-form-label">活动描述：</label>
<!--                        <div class="layui-col-md9 layui-col-md-offset3">-->
                    <div class="layui-input-block layui-col-md6" style="margin: 0 1px;">
                        <textarea placeholder="活动描述" class="layui-textarea" name="descr"></textarea>
                    </div>
                </div>

                <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                    <legend>活动物资配置</legend>
                </fieldset>

                <div class="layui-btn-container">
                    <button type="button" class="layui-btn layui-btn-radius">添加物资</button>
                </div>

                <div class="layui-form-item layui-row">
                    <button type="button" class="layui-btn layui-btn-danger layui-btn-radius layui-col-md-offset3" title="删除">删除和币</button>
                    <label for="coin_quantity" class="layui-form-label">
                        <span class="x-red">*</span>和币总量：
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="coin_quantity" name="coin_quantity" required=""
                               autocomplete="off" class="layui-input"  lay-verify="required|number">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>和币总量必填
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="coin_user_quantity" class="layui-form-label">
                        <span class="x-red">*</span>和币奖励数：
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="coin_user_quantity" name="coin_user_quantity" required=""
                               autocomplete="off" class="layui-input" lay-verify="required|number">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>和币奖励数必填
                    </div>
                </div>

                <div class="layui-form-item layui-row">
                    <button type="button" class="layui-btn layui-btn-danger layui-btn-radius layui-col-md-offset3" title="删除">删除卡券</button>
                    <label for="coupon_name" class="layui-form-label">
                        <span class="x-red">*</span>卡卷名称：
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="coupon_name" name="coupon_name" required=""
                               autocomplete="off" class="layui-input" lay-verify="required">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>卡卷名称必填
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="coupon_code" class="layui-form-label">
                        <span class="x-red">*</span>卡卷编号：
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="coupon_code" name="coupon_code" required=""
                               autocomplete="off" class="layui-input" lay-verify="required">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>卡卷编号必填
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="coupon_quantity" class="layui-form-label">
                        <span class="x-red">*</span>卡卷总数：
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="coupon_quantity" name="coupon_quantity" required=""
                               autocomplete="off" class="layui-input" lay-verify="required|number">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>卡卷总数必填
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="coupon_user_quantity" class="layui-form-label">
                        <span class="x-red">*</span>卡卷奖励数：
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" id="coupon_user_quantity" name="coupon_user_quantity" required=""
                               autocomplete="off" class="layui-input" lay-verify="required|number">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>卡卷奖励数必填
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label">
                    </label>
                    <button  class="layui-btn" lay-filter="add" lay-submit="">
                        增加
                    </button>
                </div>
            </form>
<!--            <a href="https://www.baidu.com">baidu </a>-->
        </div>
    </div>
</div>
<script type="text/javascript" src="/assets/common/xcity-custom.js"></script>
<script>
    layui.use(['form', 'layer', 'laydate','code'],
        function() {
            $ = layui.jquery;
             form = layui.form;
             layer = layui.layer;
             laydate = layui.laydate;
            //日期范围
            laydate.render({
                elem: '#test-startDate-1'
            });
            //日期范围
            laydate.render({
                elem: '#test-endDate-1'
            });
            layui.code();
            $('#start').xcity();

            //自定义验证规则
            form.verify({
                act_name: function(value) {
                    if (value.length < 3) {
                        return '活动名称至少得三个字符';
                    }
                }
            });

            //监听提交
            form.on('submit(add)',function(data) {
                    console.log(data.field);
                    layer.load();
                    $.post("<?php echo site_url('act/save_act_add'); ?>", data.field, function (callback) {
                        if (callback.status == 1) {
                            layer.closeAll();
                            layer.msg(callback.msg, {
                                icon: 1,
                                time: 2000
                            }, function(){
                                 window.location.href='https://www.baidu.com';
                                // var indexs = parent.layer.getFrameIndex(window.name);//关闭当前iframe
                                // parent.layer.close(indexs);
                                // var obj={
                                //     "offset" : 0,
                                //     "num" : 10,
                                //     "pagetouse" : true,
                                //     "url" : "{:url('article/content')}",
                                //     "targetElem" : "#content",
                                //     "formElem" : "#article_form",
                                //     "pageCountElem" : "#page-count"
                                // };
                                // parent.list(obj);
                            });
                        }else{
                            layer.closeAll();
                            layer.msg(callback.msg, {time: 2000,icon: 2});
                        }
                    }, "json");
                return false;//防止点击submit本页面刷新默认事件

                    // //发异步，把数据提交给php
                    // layer.alert("增加成功", {
                    //         icon: 6
                    //     },
                    //     function() {
                    //         //关闭当前frame
                    //         xadmin.close();
                    //
                    //         // 可以对父窗口进行刷新
                    //         xadmin.father_reload();
                    //     });
                    // return false;
                });

            ////监听提交
            //form.on('submit(add)', function(data){
            //    // var data = $('form').serializeJson();
            //    layer.load();
            //    $.post("<?php //echo site_url("act/save_params");?>//", {"data":data.field}, function (callback) {
            //        if (callback.status == '1') {
            //            // parent.list();
            //            layer.closeAll();
            //            // parent.layer.closeAll();
            //            // parent.list();
            //            parent.layer.msg('保存成功！', {icon: 1, time: 2000});
            //            // parent.location.reload();
            //        } else {
            //            layer.closeAll();
            //            layer.msg('保存失败！', {icon: 1, time: 2000});
            //        }
            //    }, "json");
            //    return false;
            //});
        });
</script>
</body>

</html>
