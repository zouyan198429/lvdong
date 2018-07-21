import common from '../../utils/common';
import WxRequest from '../../assets/plugins/wx-request/lib/index';

//获取应用实例
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    focus: false,
    title:'页面浏览',
    path:'',
    loginCacheKey:app.globalData.loginCacheKey,
    loginUserInfo : null,
    hasLogin : false,
    outURL:app.globalData.mUrl,
    pro_unit_id:0
  },
    onLoad: function (options) {
    console.log(options);
    // 判断权限
    let cacheData = common.judgeLogin(this.data.loginCacheKey,'../login/login');
    this.setData({
        loginUserInfo: cacheData,
        hasLogin:true,
        pro_unit_id:options.id,
    });

    // 设置标题、path
    let title = "页面浏览";
    this.setData({
        title:title,
        path:common.getCurrentPageUrlWithArgs()
    });
    // 重新设置title
    wx.setNavigationBarTitle({
        title: title,
        success: function(res) {
            // success
        }
    });
    // 实例request 请求
    console.log(app.globalData.apiUrl);
    this.WxRequest = new WxRequest({
        baseURL: app.globalData.apiUrl,
    });
    console.log(this.WxRequest);

},
/**
 * 用户点击右上角分享
 */
onShareAppMessage: function () {
    console.log('onShareAppMessage:');
    return {
        title: this.data.title,
        path: this.data.path
    }
},

})