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
    title:'农业可追溯',
    path:'',
    loginCacheKey:app.globalData.loginCacheKey,
    loginUserInfo : null,
    hasLogin : false,
    comname:"陕西百仙果有机农场",
    proname: "洛川红富士苹果",
    proname2: "安美特葡萄",
    selected: true,
    selected1: false,
    swiperitem: ['demo-text-1', 'demo-text-2'],
    indicatorDots: true,
    vertical: false,
    autoplay: false,
    interval: 2000,
    duration: 500
  },
    onLoad: function () {
    // 判断权限
    let cacheData = common.judgeLogin(this.data.loginCacheKey,'../login/login');
    this.setData({
        loginUserInfo: cacheData,
        hasLogin:true,
    });

    // 设置标题、path
    let title = "农业可追溯";
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

  changeIndicatorDots: function (e) {
    this.setData({
      indicatorDots: !this.data.indicatorDots
    })
  },
  changeAutoplay: function (e) {
    this.setData({
      autoplay: !this.data.autoplay
    })
  },
  intervalChange: function (e) {
    this.setData({
      interval: e.detail.value
    })
  },
  durationChange: function (e) {
    this.setData({
      duration: e.detail.value
    })
  },
  selected: function (e) {
    this.setData({
      selected1: false,
      selected: true
    })
  },
  selected1: function (e) {
    this.setData({
      selected: false,
      selected1: true
    })
  },
    goMWeb:function(e) {
        console.log(e);
        var id = e.currentTarget.dataset.id;
        console.log(id);
        wx.navigateTo({
            url: '../out/out?aa=1&id=' + id, //
            success: function () {

            },       //成功后的回调；
            fail: function () {
            },         //失败后的回调；
            complete: function () {
            }      //结束后的回调(成功，失败都会执行)
        })
    }

})