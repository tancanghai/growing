<?php
//优化方案1：将库存字段number字段设为unsigned，当库存为0时，因为字段不能为负数，将会返回false
//库存减少
$sql="update ih_store set number=number-{$number} where sku_id='$sku_id' and number>0";
$store_rs=mysql_query($sql,$conn);
if(mysql_affected_rows()){
    insertLog('库存减少成功');
}
