import common from '../../../utils/common';
import validate from '../../../utils/validate';
import WxRequest from '../../../assets/plugins/wx-request/lib/index';
import WxValidate from '../../../assets/plugins/wx-validate/WxValidate'
// pages/company/userpass/userpass.js
var app=getApp();// 取得全局App
Page({

  /**
   * 页面的初始数据
   */
  data: {
      focus: false,
      title:'修改密码',
      path:'',
      loginCacheKey:app.globalData.loginCacheKey,
      loginUserInfo : null,
      hasLogin : false,
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
      let title = "修改密码";
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
      console.log(this.WxValidate)
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
        params.redisKey = this.data.loginUserInfo.redisKey;
        // 接口请求数据
        common.interceptors(this);
        this.modifyPasswordRepos(params);
    },
    formReset: function(e) {
        console.log('form发生了reset事件', e.detail.value)
    },
    modifyPasswordRepos(params) {
        let apiName = '密码修改';
        let apiPath = '/accounts/ajax_password_save';
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
                    let that = this;
                    common.showToast( apiName + '成功,请重新登陆！','success',2000,function() {
                        setTimeout(function(){
                            // 接口请求数据
                            common.interceptors(that);
                            let params = {
                                redisKey:that.data.loginUserInfo.redisKey,
                            };
                            that.loginOutRepos(params);

                            // wx.navigateBack({
                            //     delta: 1,
                            // })
                            // wx.redirectTo({
                            //     url: '../userpass/userpass',
                            // })
                        },2000);
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
            old_password: {
                required: true,
                minlength: 6,
                maxlength: 20,
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
            }
        };

        // 验证字段的提示信息，若不传则调用默认的信息
        const messages = {
            old_password: {
                required: '请输入原始密码',
                minlength: '原始密码长度不少于6位',
                maxlength: '原始密码长度不多于20位',
            },
            account_password: {
                required: '请输入新密码',
                minlength: '新密码长度不少于6位',
                maxlength: '新密码长度不多于20位',
            },
            sure_password: {
                required: '请输入确认新密码',
                minlength: '确认新密码长度不少于6位',
                maxlength: '确认新密码长度不多于20位',
                equalTo: '确认新密码和新密码保持一致',
            },
        };

        // 创建实例对象
        this.WxValidate = new WxValidate(rules, messages);

        // 自定义验证规则
        // this.WxValidate.addMethod('assistance', (value, param) => {
        //     return this.WxValidate.optional(value) || (value.length >= 1 && value.length <= 2)
        // }, '请勾选1-2个敲码助手')
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
                    let that = this;
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