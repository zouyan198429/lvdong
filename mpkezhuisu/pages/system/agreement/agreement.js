// pages/system/agreement/agreement.js
import common from '../../../utils/common';
import WxRequest from '../../../assets/plugins/wx-request/lib/index';
var WxParse = require('../../../wxParse/wxParse.js');
var app=getApp();// 取得全局App
Page({

  /**
   * 页面的初始数据
   */
  data: {
      focus: false,
      title:'',
      path:'',
      loginCacheKey:app.globalData.loginCacheKey,
      loginUserInfo : null,
      hasLogin : false,
      article:'',
      id:4,
  
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

      console.log('onLoad');
      console.log(options);
      console.log(options.id);
      // 判断权限
      /*
      let cacheData = common.judgeLogin(this.data.loginCacheKey,'../../login/login');
      this.setData({
          loginUserInfo: cacheData,
          hasLogin:true,
          id:options.id,
      });
      */

      // 设置标题、path
      let title = "服务协议";
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

      // 获得详情数据
      common.interceptors(this);
      let params = {
          // redisKey:this.data.loginUserInfo.redisKey,
          id:this.data.id
      };
      this.getDataInfoRepos(params);
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
      console.log('onShareAppMessage:');
      return {
          title: this.data.title,
          path: this.data.path
      }
  },
    getDataInfoRepos(params) {
        let apiName = '获取数据';
        let apiPath = '/sys/ajax_info';
        console.log(apiName + apiPath);
        console.log(params);
        this
            .WxRequest
            .postRequest(apiPath,{data:params})
            .then(res => {
                console.log('loginOutRepos');
                console.log(res);
                let result = common.apiDataHandle(res,1,true);
                console.log(result);
                if(result){

                    let title = result.intro_title;
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
                    var article = result.intro_content;
                    /**
                     * WxParse.wxParse(bindName , type, data, target,imagePadding)
                     * 1.bindName绑定的数据名(必填)
                     * 2.type可以为html或者md(必填)
                     * 3.data为传入的具体数据(必填)
                     * 4.target为Page对象,一般为this(必填)
                     * 5.imagePadding为当图片自适应是左右的单一padding(默认为0,可选)
                     */
                    var that = this;
                    WxParse.wxParse('article', 'html', article, that, 5);
                    /*
                    common.showToast( apiName + '成功！','success',app.globalData.alertWaitTime,function() {
                        setTimeout(function(){
                            // that.setData({
                            //     info: result,
                            // });
                        },app.globalData.alertWaitTime);
                    },function() {},function() {});// 显示提示
                    */
                }
            })
            .catch(err => {
                console.log(err);
                common.showModal({
                    msg: apiName + '失败!',
                });
            })
    },
})