//index.js
//获取应用实例
const app = getApp()
var aes = require('../../utils/aes.js');

Page({
  data: {
    motto: 'Hello World',
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo')
  },
  //事件处理函数
  bindViewTap: function() {
    wx.navigateTo({
      url: '../logs/logs'
    })
  },
  onLoad: function () {
    var a = aes.encrypt('abcdefghij');
    var b = aes.decrypt(a);
    var c = aes.decrypt('lviLmVy3yLHBYlWJrw86PA==')
    console.log(a);
    console.log(b);
    console.log(c);
  },
  getUserInfo: function(e) {
    console.log(e)
    app.globalData.userInfo = e.detail.userInfo
    this.setData({
      userInfo: e.detail.userInfo,
      hasUserInfo: true
    })
  }
})
