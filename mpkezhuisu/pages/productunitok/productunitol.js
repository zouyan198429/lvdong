// pages/newslist/newslist.js
import common from "../../utils/common";
var app=getApp();// 取得全局App
Page({

  /**
   * 页面的初始数据
   */
  data: {
      id:0,
      title:'申请成功',
      path:'',
      loginCacheKey:app.globalData.loginCacheKey,
      loginUserInfo : null,
      hasLogin : false,
      tishi:'提交成功!',

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
      console.log('onLoad');
      console.log(options);
      var id = options.id || 0;
      console.log(id);
      // 判断权限
      let cacheData = common.judgeLogin(this.data.loginCacheKey,'../login/login');
      this.setData({
          id:id,
          loginUserInfo: cacheData,
          hasLogin:true,
      });

      // 设置标题、path
      let title = "申请成功";
      let tishi='提交成功!';
      if(id > 0){
          title = "修改成功";
          tishi='修改成功!';
      }
      this.setData({
          title:title,
          tishi:tishi,
          path:common.getCurrentPageUrlWithArgs()
      });
      // 重新设置title
      wx.setNavigationBarTitle({
          title: title,
          success: function(res) {
              // success
          }
      });
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  },

    backindex: function () {
    wx.redirectTo({
      url: '../productunitlist/productunitlist',
    })
  }
})