<?php
/* 加密 */
	function authcode($string, $operation = 'ENCODE', $key = '', $expiry = 0) {
		// 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
		$ckey_length = 4;

		// 密匙
		$key = md5($key ? $key : 'chr6w&H0HXT'); // AUTH_KEY 项目配置的密钥

		// 密匙a会参与加解密
		$keya = md5(substr($key, 0, 16));
		// 密匙b会用来做数据完整性验证
		$keyb = md5(substr($key, 16, 16));
		// 密匙c用于变化生成的密文
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
		// 参与运算的密匙
		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);
		// 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
		// 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);
		$result = '';
		$box = range(0, 255);
		$rndkey = array();
		// 产生密匙簿
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
		// 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
		// 核心加解密部分
		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			// 从密匙簿得出密匙进行异或，再转成字符
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}

		if($operation == 'DECODE') {
			// substr($result, 0, 10) == 0 验证数据有效性
			// substr($result, 0, 10) - time() > 0 验证数据有效性
			// substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性
			// 验证数据有效性，请看未加密明文的格式
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			// 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
			// 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码

			return $keyc.str_replace('=', '', base64_encode($result));
		}
	}
/* 随机字符 */
function get_rand_str($len = 5){
	$arr = array_merge(range(0,9),range('a', 'z'),range('A', 'Z'),array('$','@','#','%','&'));
	// $arr = array_merge(range(0,9));
	shuffle($arr);
	$sub_arr = array_slice($arr,0,$len);
	return implode('', $sub_arr);
}

/* 随机字符 邀请码 */
function get_rand_code($len = 6){
	$arr = array_merge(range(0,9),range('a', 'z'),range('A', 'Z'));
	// $arr = array_merge(range(0,9));
	shuffle($arr);
	$sub_arr = array_slice($arr,0,$len);
	return implode('', $sub_arr);
}

/* 获取一个当前活动 */
function get_this_activity(){
	$this_date = time();
	$where = array(
		'activity_start' => array('lt',$this_date),
		'activity_end' => array('gt',$this_date)
	);
	$activity = M('activity')->where($where)->find();
	return $activity ? $activity : array();
}
/* 获取配置 */
function get_config($type,$name){
	$result = array();
	$data = M('config')->where(array('type'=>$type))->select();
	if($data){
		foreach($data as $v){
			if(!empty($name)){
				if($v['name'] == $name){
					$result = $v['value'];
					break;
				}
			}else{
				$result[$v['name']] = $v['value'];
			}
		}
	}
	return $result;
}






/**
 * 导出到EXCEL 
 * @param type $expTitle
 * @param type $expCellName
 * @param type $expTableData
 */
function exportExcel($title, $data, $expTitle, $savePath, $isDown) {
    $xlsTitle = iconv('utf-8', 'gb2312', $expTitle); //文件名称
    $fileName = $expTitle . date('_YmdHis'); //or $xlsTitle 文件名称可根据自己情况设定
    $cellNum = count($expCellName);
    $dataNum = count($expTableData);
    vendor("PHPExcel.PHPExcel");
    $obj = new \PHPExcel();


     //横向单元格标识  
    $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');  
      
    $obj->getActiveSheet(0)->setTitle('sheet名称');   //设置sheet名称  
    $_row = 1;   //设置纵向单元格标识  
    if($title){  
        $_cnt = count($title);  
        $obj->getActiveSheet(0)->mergeCells('A'.$_row.':'.$cellName[$_cnt-1].$_row);   //合并单元格  
        $obj->setActiveSheetIndex(0)->setCellValue('A'.$_row, '数据导出：'.date('Y-m-d H:i:s'));  //设置合并后的单元格内容  
        $_row++;  
        $i = 0;  
        foreach($title AS $v){   //设置列标题  
            $obj->setActiveSheetIndex(0)->setCellValue($cellName[$i].$_row, $v);  
            $i++;  
        }  
        $_row++;  
    }  
  
    //填写数据  
    if($data){  
        $i = 0;  
        foreach($data AS $_v){  
            $j = 0;  
            foreach($_v AS $_cell){  
                $obj->getActiveSheet(0)->setCellValue($cellName[$j] . ($i+$_row), $_cell);  
                $j++;  
            }  
            $i++;  
        }  
    }  
      
    //文件名处理  
    if(!$fileName){  
        $fileName = uniqid(time(),true);  
    }  
  
    $objWrite = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');  
  
    if($isDown){   //网页下载  
        header('pragma:public');  
        header("Content-Disposition:attachment;filename=$fileName.xls");  
        $objWrite->save('php://output');exit;  
    }  
  
    $_fileName = iconv("utf-8", "gb2312", $fileName);   //转码  
    $_savePath = $savePath.$_fileName.'.xlsx';  
     $objWrite->save($_savePath);  
  
     return $savePath.$fileName.'.xlsx'; 
//     $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
// //  $objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1'); //合并单元格
//     for ($i = 0; $i < $cellNum; $i++) {
//         $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '1', $expCellName[$i][1]);
//     }
//     // Miscellaneous glyphs, UTF-8
//     for ($i = 0; $i < $dataNum; $i++) {
//         for ($j = 0; $j < $cellNum; $j++) {
//             $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 2), $expTableData[$i][$expCellName[$j][0]]);
//         }
//     }
//     header('pragma:public');
//     header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
//     header("Content-Disposition:attachment;filename=$fileName.xls"); //attachment新窗口打印inline本窗口打印
//     $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//     $objWriter->save('php://output');
    exit;
}

