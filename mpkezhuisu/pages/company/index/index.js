import common from '../../../utils/common';
import WxRequest from '../../../assets/plugins/wx-request/lib/index';
//index.js
//获取应用实例
const app = getApp();

Page({
  data: {
    focus: false,
    title:'我的帐号',
    path:'',
    loginCacheKey:app.globalData.loginCacheKey,
    loginUserInfo : null,
    hasLogin : false,
    motto: 'Hello World',
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    uploadbtn:false,
    hasproductunit:true,

  },
  //事件处理函数
  bindViewTap: function () {
      // 接口请求数据
      common.interceptors(this);
      let params = {
          redisKey:this.data.loginUserInfo.redisKey,
      };
      this.loginOutRepos(params);
     // common.quitLogin(this.data.loginCacheKey,'../../login/login');
    // wx.navigateTo({
    //   url: '../logs/logs'
    // })
  },
  onLoad: function () {
    // 判断权限
      let cacheData = common.judgeLogin(this.data.loginCacheKey,'../../login/login');
      console.log(cacheData);
      this.setData({
          loginUserInfo: cacheData,
          hasLogin:true,
      });

      // 设置标题、path
      let title = "我的帐号";
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

    if (app.globalData.userInfo) {
      this.setData({
        userInfo: app.globalData.userInfo,
        hasUserInfo: true
      })
    } else if (this.data.canIUse) {
      // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
      // 所以此处加入 callback 以防止这种情况
      app.userInfoReadyCallback = res => {
        this.setData({
          userInfo: res.userInfo,
          hasUserInfo: true
        })
      }
    } else {
      // 在没有 open-type=getUserInfo 版本的兼容处理
      wx.getUserInfo({
        success: res => {
          app.globalData.userInfo = res.userInfo
          this.setData({
            userInfo: res.userInfo,
            hasUserInfo: true
          })
        }
      })
    }
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
  getUserInfo: function (e) {
    console.log(e)
    app.globalData.userInfo = e.detail.userInfo
    this.setData({
      userInfo: e.detail.userInfo,
      hasUserInfo: true
    })
  },
    loginOutRepos(params) {
        let apiName = '退出登陆';
        let apiPath = '/accounts/ajax_login_out';
        console.log(apiName + apiPath);
        console.log(params);
        this
            .WxRequest
            .postRequest(apiPath,{data:params})
            .then(res => {
                console.log('loginOutRepos');
                console.log(res);
                let result = common.apiDataHandle(res,1);
                console.log(result);
                if(result){
                    var that = this;
                    common.showToast(apiName + '成功','success',2000,function() {
                        setTimeout(function(){
                            common.quitLogin(that.data.loginCacheKey,'../../login/login');
                        },2000);
                    },function() {},function() {});// 显示提示

                }
            })
            .catch(err => {
                console.log(err);
                common.showModal({
                    msg: apiName +  '失败!',
                });
            })
    },
});
