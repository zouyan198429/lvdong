import common from '../../../utils/common';
import WxRequest from '../../../assets/plugins/wx-request/lib/index';
var WxParse = require('../../../wxParse/wxParse.js');
// pages/company/comabout/about.js
import WxValidate from '../../../assets/plugins/wx-validate/WxValidate'
import dateTime from '../../../utils/dateTime';
var app=getApp();// 取得全局App
Page({

  /**
   * 页面的初始数据
   */
  data: {
      focus: false,
      title:'企业简介',
      path:'',
      loginCacheKey:app.globalData.loginCacheKey,
      loginUserInfo : null,
      hasLogin : false,
      article:'',
      company_intro:'',
      id:0,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

      // 判断权限
      let cacheData = common.judgeLogin(this.data.loginCacheKey,'../../login/login');
      this.setData({
          loginUserInfo: cacheData,
          hasLogin:true,
      });

      // 设置标题、path
      let title = "企业简介";
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
      // 初始化表单验证
      this.initValidate();
      console.log(this.WxValidate);

      // 实例request 请求
      console.log(app.globalData.apiUrl);
      this.WxRequest = new WxRequest({
          baseURL: app.globalData.apiUrl,
      });
      console.log(this.WxRequest);

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
      // 获得详情数据
      common.interceptors(this);
      let params = {
          redisKey:this.data.loginUserInfo.redisKey,
      };
      this.getDataInfoRepos(params);
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
    formSubmit: function(e) {
        console.log('form发生了submit事件，携带数据为：', e.detail.value);
        let params = e.detail.value;
        console.log(params);
        // 传入表单数据，调用验证方法
        if (!this.WxValidate.checkForm(e)) {
            const error = this.WxValidate.errorList[0];
            common.showModal(error);
            return false;
        }
        params.id = this.data.id;
        params.redisKey = this.data.loginUserInfo.redisKey;
        // 接口请求数据
        common.interceptors(this);
        this.saveRepos(params);
    },
    formReset: function(e) {
        console.log('form发生了reset事件', e.detail.value)
    },
    saveRepos(params) {
        let apiName = '保存';
        let apiPath = '/company/ajax_intro_save';
        console.log(apiName + apiPath);
        console.log(params);
        this
            .WxRequest
            .postRequest(apiPath,{data:params})
            .then(res => {
                console.log(res);
                let resReg = common.apiDataHandle(res,1,true);
                console.log(resReg);
                if(resReg){// 跳转到登陆
                    common.showToast(apiName + '成功!','success',app.globalData.alertWaitTime,function() {
                        setTimeout(function(){
                            wx.redirectTo({
                                url: '../index/index'
                            });
                        },app.globalData.alertWaitTime);
                    },function() {},function() {});// 显示提示
                }
            })
            .catch(err => {
                console.log(err);
                common.showModal({
                    msg: apiName + '失败!',
                });
            })
    },
    initValidate() {
        // 验证字段的规则
        const rules = {
            company_intro: {
                required: true,
                minlength: 2,
                maxlength: 500,
            },
        };

        // 验证字段的提示信息，若不传则调用默认的信息
        const messages = {
            company_intro: {
                required: '请输公司介绍',
                minlength: '公司介绍长度不少于2位',
                maxlength: '公司介绍长度不多于500位',
            },

        };

        // 创建实例对象
        this.WxValidate = new WxValidate(rules, messages);

        // 自定义验证规则
        // this.WxValidate.addMethod('assistance', (value, param) => {
        //     return this.WxValidate.optional(value) || (value.length >= 1 && value.length <= 2)
        // }, '请勾选1-2个敲码助手')
    },
    getDataInfoRepos(params) {
        let apiName = '获取数据';
        let apiPath = '/company/ajax_info';
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
                    var article = result.company_extend.company_intro || '';
                    var id = result.company_extend.id || 0;
                    /**
                     * WxParse.wxParse(bindName , type, data, target,imagePadding)
                     * 1.bindName绑定的数据名(必填)
                     * 2.type可以为html或者md(必填)
                     * 3.data为传入的具体数据(必填)
                     * 4.target为Page对象,一般为this(必填)
                     * 5.imagePadding为当图片自适应是左右的单一padding(默认为0,可选)
                     */
                    var that = this;
                    // WxParse.wxParse('article', 'html', article, that, 5);
                    that.setData({
                        id:id,
                        company_intro: article,
                        // info: result,
                    });
                    /*
                    common.showToast( apiName + '成功！','success',app.globalData.alertWaitTime,function() {
                        setTimeout(function(){
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
});