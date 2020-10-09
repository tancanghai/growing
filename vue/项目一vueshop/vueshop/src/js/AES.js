import  CryptoJS  from   "../../node_modules/crypto-js/index.js";
    var key_base = 'contentWindowHig';
    var iv_base = 'contentDocuments'
    var key_hash = CryptoJS.MD5(key_base).toString();
    var iv_hash = CryptoJS.MD5(iv_base).toString();
    var key = CryptoJS.enc.Utf8.parse(key_hash.substr(0,16));
    var iv = CryptoJS.enc.Utf8.parse(iv_hash.substr(0,16));
	var AES={
		_decrypt:function(string) {
		    var data = CryptoJS.AES.decrypt(string, key, {iv: iv, padding: CryptoJS.pad.Pkcs7}).toString(CryptoJS.enc.Utf8);
		    return data;
		},
		_encrypt:function(string) {
		    var data = CryptoJS.AES.encrypt(string, key, {
		        iv: iv,
		        mode: CryptoJS.mode.CBC,
		        padding: CryptoJS.pad.Pkcs7
		    }).toString();
		    return data;
		}
	};
 //    // var a = _encrypt('abcdefghij');
 //    // var b = _decrypt(a);
 //    // var c= _decrypt('lviLmVy3yLHBYlWJrw86PA==')
 //    // console.log(a);
 //    // console.log(b);
 //    // console.log(c);
	export default AES;