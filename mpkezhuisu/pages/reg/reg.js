import common from '../../utils/common';
import validate from '../../utils/validate';
import WxRequest from '../../assets/plugins/wx-request/lib/index';
import WxValidate from '../../assets/plugins/wx-validate/WxValidate'

// pages/reg/reg.js
var app=getApp();// 取得全局App
Page({

  /**
   * 页面的初始数据
   */
  data: {
      focus: false,
      title:'新用户注册',
      path:'',
      loginCacheKey:app.globalData.loginCacheKey,
      provinceList:[],
      provinceIndex:0,
      province:0,
      cityList:[],
      cityIndex:0,
      city:0,
      areaList:[],
      areaIndex:0,
      area:0,

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
      console.log('onLoad:');
      console.log(options);
      // 设置标题、path
      let title = "新用户注册";
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

      // 初始化表单验证
      this.initValidate();
      console.log(this.WxValidate);
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
  regclick:function() {
    wx.redirectTo({
      url: '../login/login',
    })
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
        // 接口请求数据
        common.interceptors(this);
        this.regRepos(params);
    },
    formReset: function(e) {
        console.log('form发生了reset事件', e.detail.value)
    },
    regRepos(params) {
        let apiName = '注册';
        let apiPath = '/accounts/ajax_reg';
        console.log(apiName + apiPath);
        console.log(params);
        this
            .WxRequest
            .postRequest(apiPath,{data:params})
            .then(res => {
                console.log(res);
                let resReg = common.apiDataHandle(res,1,true,'../login/login');
                console.log(resReg);
                if(resReg){// 跳转到登陆
                    common.showToast(apiName + '成功!','success',app.globalData.alertWaitTime,function() {
                        setTimeout(function(){
                            wx.reLaunch({//关闭当前页面，跳转到应用内的某个页面
                                url: '../login/login',//url里面就写上你要跳到的地址
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
            company_mobile: {
                required: true,
                tel: true,
            },
            account_password: {
                required: true,
                minlength: 6,
                maxlength: 20,
            },
            sure_password: {
                required: true,
                minlength: 6,
                maxlength: 20,
                equalTo: 'account_password',
            },
            real_name: {
                required: true,
                minlength: 2,
                maxlength: 30,
            },
            company_name: {
                required: true,
                minlength: 2,
                maxlength: 40,
            },
        };

        // 验证字段的提示信息，若不传则调用默认的信息
        const messages = {
            company_mobile: {
                required: '请输入手机号',
                tel: '请输入正确的手机号',
            },
            account_password: {
                required: '请输入密码',
                minlength: '密码长度不少于6位',
                maxlength: '密码长度不多于20位',
            },
            sure_password: {
                required: '请输入确认密码',
                minlength: '确认密码长度不少于6位',
                maxlength: '确认密码长度不多于20位',
                equalTo: '确认密码和密码保持一致',
            },
            real_name: {
                required: '请输入用户名',
                minlength: '用户名长度不少于2位',
                maxlength: '用户名长度不多于30位',
            },
            company_name: {
                required: '请输入企业全称',
                minlength: '企业全称长度不少于2位',
                maxlength: '企业全称长度不多于40位',
            },
        };

        // 创建实例对象
        this.WxValidate = new WxValidate(rules, messages);

        // 自定义验证规则
        // this.WxValidate.addMethod('assistance', (value, param) => {
        //     return this.WxValidate.optional(value) || (value.length >= 1 && value.length <= 2)
        // }, '请勾选1-2个敲码助手')
    },
})