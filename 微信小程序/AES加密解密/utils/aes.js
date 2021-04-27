var CryptoJS = require('./pwd/aesUtil.js');
var MD5 = require('./pwd/md5.js');
var key_base = 'contentWindowHig';
var iv_base = 'contentDocuments'
var key_hash = MD5.hex_md5(key_base).toString();
var iv_hash = MD5.hex_md5(iv_base).toString();
var key = CryptoJS.enc.Utf8.parse(key_hash.substr(0, 16));
var iv = CryptoJS.enc.Utf8.parse(iv_hash.substr(0, 16));

function decrypt(string) {
  var data = CryptoJS.AES.decrypt(string, key, {
    iv: iv,
    padding: CryptoJS.pad.Pkcs7
  }).toString(CryptoJS.enc.Utf8);
  return data;
}

function encrypt(string) {
  var data = CryptoJS.AES.encrypt(string, key, {
    iv: iv,
    mode: CryptoJS.mode.CBC,
    padding: CryptoJS.pad.Pkcs7
  }).toString();
  return data;
}
//模块暴露接口module.exports.decrypt=decrypt;俩个decrypt必须一致
module.exports.decrypt=decrypt;
module.exports.encrypt = encrypt;

// var a = aes.encrypt('abcdefghij');
// var b = aes.decrypt(a);
// var c = aes.decrypt('lviLmVy3yLHBYlWJrw86PA==')
// console.log(a);
// console.log(b);
// console.log(c);