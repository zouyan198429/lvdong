import common from '../../../utils/common';
import WxRequest from '../../../assets/plugins/wx-request/lib/index';
var util = require('../../../utils/util.js');
import WxValidate from '../../../assets/plugins/wx-validate/WxValidate'
import dateTime from "../../../utils/dateTime";
import validate from "../../../utils/validate";
// pages/company/accountsadd/accountsadd.js
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
      uploadbtn:false,
      max_pic:12,
      upload_picture_list: [],//装image的数组
      file_name:'',
      resource_id:[],
      id:0,
      dataInfo:[],
      record_audit:false,
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
      let title = "新建子帐号";
      if(id > 0){
          title = "修改子帐号";
      }
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
      // 获得详情数据
      if(id > 0 ){
          common.interceptors(this);
          let params = {
              id:id,
              redisKey:this.data.loginUserInfo.redisKey,
          };
          this.getDataInfoRepos(params);
      }
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
        let apiPath = '/accounts/ajax_info';
        console.log(apiName + apiPath);
        console.log(params);
        this
            .WxRequest
            .postRequest(apiPath,{data:params})
            .then(res => {
                console.log('loginOutRepos');
                console.log(res);
                let result = common.apiDataHandle(res,1,true,'../../login/login');
                console.log(result);
                if(result){
                    var that = this;
                    //var resource_ids = that.data.resource_id;
                   // var upload_picture_list = result.upload_picture_list || [];
                   // var ImageLinkArray = that.data.ImageLinkArray;
                  //  for (var i = 0; i < upload_picture_list.length; i++) {
                  //      var path_server = upload_picture_list[i].path;
                 //       ImageLinkArray = ImageLinkArray.concat(path_server);
                  //      resource_ids.push(upload_picture_list[i].resource_id);
                  //  }
                  //  console.log('ImageLinkArray');
                  //  console.log(ImageLinkArray);
                    //if(upload_picture_list.length > 0){
                    //   resource_ids.push(upload_picture_list[0].resource_id);
                    //}
                    that.setData({
                      //  ImageLinkArray: ImageLinkArray,
                        dataInfo:result,
                        record_audit: !!(result.record_audit),
                       // begin_time: result.begin_time,
                      //  end_time: result.end_time,
                      //  firstClsIndex:result.site_pro_unit_id,
                     //   upload_picture_list:upload_picture_list,
                      //  resource_id: resource_ids,
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
    formSubmit: function(e) {
        console.log('form发生了submit事件，携带数据为：', e.detail.value);
        let params = e.detail.value;
        params.record_audit = params.record_audit ? 1 : 0;
        console.log(params);
        // 传入表单数据，调用验证方法
        if (!this.WxValidate.checkForm(e)) {
            const error = this.WxValidate.errorList[0];
            common.showModal(error);
            return false;
        }
        params.id = this.data.id;
        params.redisKey = this.data.loginUserInfo.redisKey;
        console.log(params);
        // 接口请求数据
        common.interceptors(this);
        this.saveRepos(params);

    },
    formReset: function(e) {
        console.log('form发生了reset事件', e.detail.value)
    },
    saveRepos(params) {
    let apiName = '保存记录';
    let apiPath = '/accounts/ajax_save';
    console.log(apiName + apiPath);
    console.log(params);
    this
        .WxRequest
        .postRequest(apiPath,{data:params})
        .then(res => {
            console.log(res);
            let result = common.apiDataHandle(res,1,true,'../../../login/login');
            console.log(result);
            if(result){
                var that = this;
                common.showToast(apiName + '成功','success',app.globalData.alertWaitTime,function() {
                    setTimeout(function(){
                        wx.redirectTo({
                            url: '../accounts/accounts'
                        });
                    },app.globalData.alertWaitTime);
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
    initValidate() {
        var that = this;
        var id = that.data.id;
        // 验证字段的规则
        const rules = {
            mobile: {
                required: true,
                tel: true,
            },
            real_name: {
                required: true,
                minlength: 2,
                maxlength: 40,
            },
            account_password: {
                password_empty:true,
                minlength: 6,
                maxlength: 20,
            },
            sure_password: {
                password_empty:true,
                minlength: 6,
                maxlength: 20,
                equalTo: 'account_password',
            },
        };

        // 验证字段的提示信息，若不传则调用默认的信息
        const messages = {
            mobile: {
                required: '请输入手机号',
                tel: '请输入正确的手机号',
            },
            real_name: {
                required: '请输入真实姓名',
                minlength: '真实姓名长度不少于1位',
                maxlength: '真实姓名长度不多于40位',
            },
            account_password: {
                password_empty:'请输入密码',
                minlength: '密码长度不少于2位',
                maxlength: '密码长度不多于20位',
            },
            sure_password: {
                password_empty:'请输入确认密码',
                minlength: '确认密码长度不少于2位',
                maxlength: '确认密码长度不多于30位',
                equalTo: '确认密码和新密码保持一致',
            },
        };

        // 创建实例对象
        this.WxValidate = new WxValidate(rules, messages);

        // 自定义验证规则
        this.WxValidate.addMethod('password_empty', (value, param) => {
            console.log("param");
            console.log(param);
            console.log("value");
            console.log(value);
            console.log("id");
            console.log(id);
            console.log(( id<=0 &&  value != '') || id>0);
            // || (id > 0 && value.length <= 1)
            return  ( id<=0 &&  value != '') || id>0
        }, '请输入密码')
    },
});