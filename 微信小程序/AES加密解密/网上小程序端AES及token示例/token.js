/**
 * 生成Token
 */
function productionToken(params) {
  var obj = util.objKeySort(params);
  var value = '';
  for (var item in obj) {
    value += obj[item];
  }
  //加上当前时间戳   
  value += util.getTokenDate(new Date())
  //去除所有空格
  value = value.replace(/\s+/g, "")
  //进行UTF-8编码
  value = encodeURI(value);
  //进行MD5码加密
  value = md5.hex_md5(value)
  return value;
}
//util的排序函数
function objKeySort(obj) {
  //先用Object内置类的keys方法获取要排序对象的属性名，再利用Array原型上的sort方法对获取的属性名进行排序，newkey是一个数组
  var newkey = Object.keys(obj).sort();
  //创建一个新的对象，用于存放排好序的键值对　　
  var newObj = {};
  //遍历newkey数组
  for (var i = 0; i < newkey.length; i++) {
    //向新创建的对象中按照排好的顺序依次增加键值对
    newObj[newkey[i]] = obj[newkey[i]];
  }
  //返回排好序的新对象
  return newObj;
}