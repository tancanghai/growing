var aes = require('../utils/public.js')
var md5 = require("../utils/md5.js")

...

/**
 * 网络请求
 */
function request(method, loading, url, params, success, fail) {
  var url = BASE_URL + url;
  //请求参数转为JSON字符串
  var jsonStr = JSON.stringify(params);
  console.log(url + '  params=> ' + jsonStr)
  //根据特定规则生成Token
  var token = productionToken(params);
  //加密请求参数
  var aesData = aes.Encrypt(jsonStr)
  console.log('请求=>明文参数：' + jsonStr)
  console.log('请求=>加密参数：' + aesData)
  ...
  wx.request({
    url: url,
    method: method,
    header: {
      'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8',
      'Token': token
    },
    data: {
      aesData: aesData
    },
    // data: params,
    success: function (res) {
      //判断请求结果是否成功
      if (res.statusCode == 200 && res.data != '' && res.data != null) {
        //解密返回数据
        console.log('返回=>加密数据：' + res.data);
        var result = aes.Decrypt(res.data);
        console.log('返回=>明文数据：' + result);
        success(JSON.parse(result))
      } else {
        fail()
      }
    },
    fail: function (res) {
      fail()
    },
  })
}