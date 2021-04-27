<?php  
namespace Admin\Controller;
class OrderController extends BaseController{
// 订单列表页
// 
	public function order_list(){
		$where=array();
		//关键词搜索
		$word = I('get.word');
		if(!empty($word)){
			$where['order_telephone'] = array('like',"%$word%");
		}
		//订单状态搜索
		$where['order_status'] = array('neq',6);
		$order_status = I('get.order_status');
		if(!empty($order_status)){
			if($order_status != 8){
				$where['order_status'] = $order_status -1;
			}
		}
		//支付状态搜索
		$pay_status = I('get.pay_status');
		if(!empty($pay_status)){
			if($pay_status != 3){
				$where['pay_status'] = $pay_status -1;
			}
		}

		//排序;
		$order = 'id desc';
		$sort_type = I('get.sort_type');
		$order_type = I("get.order_type");
		if(!empty($sort_type)&&!empty($order_type)){
			if($sort_type == 'sort_name'){
				if($order_type == 'asc'){
					$order = "convert(order_username using gb2312) ASC";
				}else{
					$order = "convert(order_username using gb2312) DESC";
				}
			}elseif($sort_type == 'sort_address'){
				if($order_type == 'asc'){
					$order = "convert(order_address_mark using gb2312) ASC";
				}else{
					$order = "convert(order_address_mark using gb2312) DESC";
				}
			}elseif($sort_type == 'sort_reserve'){
				if($order_type == 'asc'){
					$order = "reserve_time ASC";
				}else{
					$order = "reserve_time DESC";
				}
			}elseif ($sort_type == 'sort_orderNum') {
				if($order_type == 'asc'){
					$order = "order_num ASC";
				}else{
					$order = "order_num DESC";
				}
			}
		}
		$where['is_annually'] = array('neq',2);


		$all_list = M('order')->where($where)->select();
		$all_money = 0;
		foreach ($all_list as  $v) {
			$all_money = $all_money +$v['order_price'];
		}
		

		// ORDER("convert(order_username using gb2312) ASC")
		$count = M('order')->where($where)->count();
		$page = new \Think\Page($count,15);
		$list = M('order')->where($where)->order($order)->limit($page->firstRow,$page->listRows)->select();
		
		###
        ##
        #订单首页判定每个未付款是否超时，超时取消该订单
        #
        $time = time();
        #20分钟
        $condition = $time - 1200;
        $where['order_status'] = 0;
        $where['pay_status'] = 0;
        $where['add_time'] = array('ELT',$condition);
        $order_all = M('order')->where($where)->select();
        if($order_all){
            foreach ($order_all as $k => $v) {
                $v['order_status'] = 6;
                $v['cancel_mark'] = '超时系统自动取消';
                $res = M('order')->save($v);
            }
        }
        ###
        ##
        #
        $this->assign('all_money',$all_money);
        $this->assign('count',$count);
		$this->assign('list',$list);
		$this->assign('page',$page->show());
		$this->display();
	}



public function order_reclaim(){
		$where=array();
		//关键词搜索
		$word = I('get.word');
		if(!empty($word)){
			$where['order_telephone'] = array('like',"%$word%");
		}
		//订单状态搜索
		$where['order_status'] = array('neq',6);
		$order_status = I('get.order_status');
		if(!empty($order_status)){
			if($order_status != 8){
				$where['order_status'] = $order_status -1;
			}
		}
		//支付状态搜索
		$pay_status = I('get.pay_status');
		if(!empty($pay_status)){
			if($pay_status != 3){
				$where['pay_status'] = $pay_status -1;
			}
		}

		//排序;
		$order = 'id desc';
		$sort_type = I('get.sort_type');
		$order_type = I("get.order_type");
		if(!empty($sort_type)&&!empty($order_type)){
			if($sort_type == 'sort_name'){
				if($order_type == 'asc'){
					$order = "convert(order_username using gb2312) ASC";
				}else{
					$order = "convert(order_username using gb2312) DESC";
				}
			}elseif($sort_type == 'sort_address'){
				if($order_type == 'asc'){
					$order = "convert(order_address_mark using gb2312) ASC";
				}else{
					$order = "convert(order_address_mark using gb2312) DESC";
				}
			}elseif($sort_type == 'sort_reserve'){
				if($order_type == 'asc'){
					$order = "reserve_time ASC";
				}else{
					$order = "reserve_time DESC";
				}
			}elseif ($sort_type == 'sort_orderNum') {
				if($order_type == 'asc'){
					$order = "order_num ASC";
				}else{
					$order = "order_num DESC";
				}
			}
		}

		$where['is_annually'] = 2;

		$all_list = M('order')->where($where)->select();
		$all_money = 0;
		foreach ($all_list as  $v) {
			$all_money = $all_money +$v['order_price'];
		}
		

		// ORDER("convert(order_username using gb2312) ASC")
		$count = M('order')->where($where)->count();
		$page = new \Think\Page($count,15);
		$list = M('order')->where($where)->order($order)->limit($page->firstRow,$page->listRows)->select();
		
		###
        ##
        #订单首页判定每个未付款是否超时，超时取消该订单
        #
        $time = time();
        #20分钟
        $condition = $time - 1200;
        $where['order_status'] = 0;
        $where['pay_status'] = 0;
        $where['add_time'] = array('ELT',$condition);
        $order_all = M('order')->where($where)->select();
        if($order_all){
            foreach ($order_all as $k => $v) {
                $v['order_status'] = 6;
                $v['cancel_mark'] = '超时系统自动取消';
                $res = M('order')->save($v);
            }
        }
        ###
        ##
        #
        $this->assign('all_money',$all_money);
        $this->assign('count',$count);
		$this->assign('list',$list);
		$this->assign('page',$page->show());
		$this->display();
	}






	// 年包订单
	public function	annually_order(){
		$where=array();
		//关键词搜索
		$word = I('get.word');
		if(!empty($word)){
			$where['order_telephone'] = array('like',"%$word%");
		}
		//订单状态搜索
		$where['order_status'] = array('neq',6);
		$order_status = I('get.order_status');
		if(!empty($order_status)){
			if($order_status != 8){
				$where['order_status'] = $order_status -1;
			}
		}
		//支付状态搜索
		$pay_status = I('get.pay_status');
		if(!empty($pay_status)){
			if($pay_status != 3){
				$where['pay_status'] = $pay_status -1;
			}
		}

		//排序;
		// $order = 'id desc';
		// $sort_type = I('get.sort_type');
		// $order_type = I("get.order_type");
		// if(!empty($sort_type)&&!empty($order_type)){
		// 	if($sort_type == 'sort_name'){
		// 		if($order_type == 'asc'){
		// 			$order = "convert(order_username using gb2312) ASC";
		// 		}else{
		// 			$order = "convert(order_username using gb2312) DESC";
		// 		}
		// 	}elseif($sort_type == 'sort_address'){
		// 		if($order_type == 'asc'){
		// 			$order = "convert(order_address_mark using gb2312) ASC";
		// 		}else{
		// 			$order = "convert(order_address_mark using gb2312) DESC";
		// 		}
		// 	}elseif($sort_type == 'sort_reserve'){
		// 		if($order_type == 'asc'){
		// 			$order = "reserve_time ASC";
		// 		}else{
		// 			$order = "reserve_time DESC";
		// 		}
		// 	}elseif ($sort_type == 'sort_orderNum') {
		// 		if($order_type == 'asc'){
		// 			$order = "order_num ASC";
		// 		}else{
		// 			$order = "order_num DESC";
		// 		}
		// 	}
		// }

		$all_list = M('annually_order')->where($where)->select();
		$all_money = 0;
		foreach ($all_list as  $v) {
			$all_money = $all_money +$v['order_price'];
		}
		$order = 'id desc';

		// ORDER("convert(order_username using gb2312) ASC")
		$count = M('annually_order')->where($where)->count();
		$page = new \Think\Page($count,15);
		$list = M('annually_order')->where($where)->order($order)->limit($page->firstRow,$page->listRows)->select();
		
		###
        ##
        #订单首页判定每个未付款是否超时，超时取消该订单
        #
        $time = time();
        #20分钟
        $condition = $time - 1200;
        $where['order_status'] = 0;
        $where['pay_status'] = 0;
        $where['add_time'] = array('ELT',$condition);
        $order_all = M('annually_order')->where($where)->select();
        if($order_all){
            foreach ($order_all as $k => $v) {
                $v['order_status'] = 6;
                $v['cancel_mark'] = '超时系统自动取消';
                $res = M('annually_order')->save($v);
            }
        }
        ###
        ##
        #
        $this->assign('all_money',$all_money);
        $this->assign('count',$count);
		$this->assign('list',$list);
		$this->assign('page',$page->show());
		$this->display();
	}







//订单添加
	public function order_add(){
		if(IS_POST){
			$data = I('post.');
			if($data['id'] >0){
				$res = M('order')->save($data);
			}else{
				$data['add_time'] = time();
				$res = M('order')->add($data);
			}
			if($res !== false){
				$this->ajaxreturn(array('status'=>'y','info'=>'操作成功'));
			}else{
				$this->ajaxreturn(array('status'=>'n','info'=>'操作失败'));
			}
		}
		#师傅列表显示。
        $technician_list = M('technician')->where('is_rest = 0')->select();
        $id = I('id');
        $row = M('order')->find($id);
        $this->assign($row);
        $this->assign('technician_list',$technician_list);
		$this->display();
	}

//// 订单查看页
// 
	public function order_look(){
		$id = I('id');
		$row = M('order')->find($id);
		$newArray = explode(',', $row['goods_id']);
        $goods_list = array();
        foreach ($newArray as $k => $v) {
            $goods_list[$k] = M('goods')->where('id ='.$v)->find();
        }
		// $goods_list = M('goods')->select($row['goods_id']);
		$this->assign('goods_list',$goods_list);
		$this->assign($row);
		$this->display();
	}
//订单删除功能
//
	public function order_del(){
		$id = trim(I('id'),',');
		$res = M('order')->delete($id);
		if($res){
			$this->ajaxreturn(array('status'=>'y','info'=>'删除成功'));
		}else{
			$this->ajaxreturn(array('status'=>'n','info'=>'删除失败'));
		}
	}

//佣金审核
//
	public function check_money(){
		$count = M('order_money_log')->count();
		$page = new \Think\Page($count,20);
		$list = M('order_money_log')->order('id desc')->limit($page->firstRow,$page->listRows)->select();
		#通过订单id 查询订单相关信息。
		foreach ($list as $k => $v) {
			$order = M('order')->find($v['id']);
			$list[$k]['order_num'] = $order['order_num'];
			$list[$k]['order_telephone'] = $order['order_telephone'];
			$list[$k]['my_id'] = $order['user_id'];
		}
		if(IS_POST){
			$data['id'] = I('post.id');
			$data['status'] =1 ;
			$res = M('order_money_log')->save($data);
			// 审核后，返佣。
			$row = M('order_money_log')->find($data['id']);
			//返佣给师傅
			$row_technician = M('technician')->find($row['technician_id']);
			$row_technician['money'] = intval(floatval($row_technician['money'])*100);
			$row_technician['money'] = $row_technician['money'] +intval(floatval($row['technician_money'])*100);
			$row_technician['money'] = $row_technician['money']/100;
			#总推广金额
			$row_technician['money_summary'] = intval(floatval($row_technician['money_summary'])*100);
			$row_technician['money_summary'] = $row_technician['money_summary'] +intval(floatval($row['technician_money'])*100);
			$row_technician['money_summary'] = $row_technician['money_summary']/100;
			$res = M('technician')->save($row_technician);
			//返佣给用户
			//
			$row_user = M('user')->find($row['user_id']);
			#推广金额
			$row_user['money_distribution'] = intval(floatval($row_user['money_distribution'])*100);
			$row_user['money_distribution'] = $row_user['money_distribution'] +intval(floatval($row['user_money'])*100);
			$row_user['money_distribution'] = $row_user['money_distribution']/100;
			#累计推广金额
			$row_user['money_distribution_summary'] = intval(floatval($row_user['money_distribution_summary'])*100);
			$row_user['money_distribution_summary'] = $row_user['money_distribution_summary'] +intval(floatval($row['user_money'])*100);
			$row_user['money_distribution_summary'] = $row_user['money_distribution_summary']/100;
			//存储数据
			$res = M('user')->save($row_user);
			if($res){
				$this->ajaxreturn(array('status'=>'y','info'=>'成功'));
			}else{
				$this->ajaxreturn(array('status'=>'n','info'=>'失败'));
			}
		}
		$this->assign('list',$list);
		$this->assign('count',$count);
		$this->assign('page',$page->show());
		$this->display();
	}


//提现审核
//
	public function check_get_money(){
		$where['technician_id'] = array('neq',0);
		if(IS_POST){
			$id = I('post.id');
			$row = M('get_money_log')->find($id);
			#查询相应提现申请人
			// $technician = M('technician')->find($row['technician_id']);
			// $technician['money'] = intval(floatval($technician['money'])*100);
			// $technician['money'] = $technician['money'] - intval(floatval($row['money'])*100);
			// if($technician['money'] < intval(floatval($row['money'])*100)){
			// 	$this->ajaxreturn(array('status'=>'n','info'=>'提现金额不能大于拥有金额'));
			// 	exit;
			// }
			// $technician['money'] = $technician['money']/100;
			$row['status'] = 1;
			$res = M('get_money_log')->save($row);
			// $res = M('technician')->save($technician);
			if($res){
				$this->ajaxreturn(array('status'=>'y','info'=>'成功'));
			}else{
				$this->ajaxreturn(array('status'=>'n','info'=>'失败'));
			}

		}
		$list = M('get_money_log')->where($where)->select();
		$count = M('get_money_log')->where($where)->count();
		$this->assign('count',$count);
		$this->assign('list',$list);
		$this->display();
	}

	//订单导出功能excel
	public function order_excel(){
		// exit;
        $res  =  M('order')->where($where)->order('id asc')->select();
        // dump($data);                        
        $xlsName="订单列表";//表名
        $xlsCell  = array('订单编号','联系人','电话号码','预约时间','时间备注','预约地址','下单时间','接单人','订单总金额','实付金额','首单满减','洗二送一','洗三送二','会员折扣金额','订单状态','支付状态','下单商品');
        $xlsData=array(); 
        $savePath='./';
        $isDown=true;
        //接单师傅
            foreach ($res as $key=>$val){
                array_push($xlsData, array(
                    $val['order_num'],
                    $val['order_username'],
                    $val['order_telephone'],
                    $val['reserve_time'],
                    $val['order_mark'],
                    $val['order_address'].'-'.$val['order_address_mark'],
                    date('Y-m-d H:i:s',$val['add_time']),
					get_technician_name($val['technician_id']),
					$val['order_price'],
					$val['pay_money'],
					$val['promotions_money'],
					$val['sale_money_1'],
					$val['sale_money_2'],
					$val['discount'],
					get_order_status($val['order_status']),
					get_pay_status($val['pay_status']),
					$this->get_goods_name($val['goods_id']),
                ));
            }  
                  // dump($xlsCell);
                  // dump($xlsName);
                  // dump($xlsData);
                  // exit;                                  
        exportExcel($xlsCell, $xlsData, $xlsName, $savePath, $isDown);
        die(); 
     }



     //获取商品名称
     public function get_goods_name($id){
     	$list = M('goods')->select($id);
     	$goods_name = '';
     	foreach ($list as $k => $v) {
     		$goods_name = $goods_name .','.$v['name'];
     	}
     	return trim($goods_name,',');
     }

     public function order_user(){
        $order_id = I('get.id');
        $row = M('UserData')->where(array('order_id'=>$order_id))->find();
        $this->assign($row);
        $this->display();
     }

}


