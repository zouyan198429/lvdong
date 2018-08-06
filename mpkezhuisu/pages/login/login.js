import common from '../../utils/common';
import validate from '../../utils/validate';
import WxRequest from '../../assets/plugins/wx-request/lib/index';
import WxValidate from '../../assets/plugins/wx-validate/WxValidate'

var app=getApp();// 取得全局App
Page({
    /**
     * 页面的初始数据
     */
    data: {
      focus: false,
      title:'会员登录',
      path:'pages/login/login',
      loginCacheKey:app.globalData.loginCacheKey,
      form:{
          mobile:'',
          password:''
      },
      reg:true,
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
        console.log('onLoad:');
        console.log(options);
        // 设置标题、path
        let title = "会员登录";
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
        console.log('onReady:');
    },

    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function () {
      console.log('onShow:');
        // 是否已经登陆过
        // 获得数据
        console.log('获得缓存数据');
        let cacheData = common.getSyncCache(this.data.loginCacheKey );
        console.log(cacheData);
        if(cacheData.redisKey){// 已经登陆
            // 判断登陆状态是否还在
            common.interceptors(this);
            this.judgeLoginRepos({redisKey:cacheData.redisKey});
        }
      // 验证手机号
      // let mobile = "15829686962";
      // let judge = validate.judge_validate(4,'手机号',mobile,true,'mobile','','');
      // console.log(judge);
        // request 请求
        // const requestTask = wx.request({
        //     url: 'http://comp.kezhuisu.com/api/new/ajax_test', //仅为示例，并非真实的接口地址
        //     data: {
        //         x: '' ,
        //         y: ''
        //     },
        //     header: {
        //         'content-type': 'application/json'
        //     },
        //     success: function(res) {
        //         console.log(res.data)
        //     }
        // });

        // requestTask.abort() // 取消请求任务
        // wx.showActionSheet({
        //     itemList: ['A', 'B', 'C'],
        //     success: function(res) {
        //         console.log(res.tapIndex)
        //     },
        //     fail: function(res) {
        //         console.log(res.errMsg)
        //     }
        // })
    },

    /**
     * 生命周期函数--监听页面隐藏
     */
    onHide: function () {
        console.log('onHide:');
    },

    /**
     * 生命周期函数--监听页面卸载
     */
    onUnload: function () {
        console.log('onUnload:');
    },

    /**
     * 页面相关事件处理函数--监听用户下拉动作
     */
    onPullDownRefresh: function () {
        console.log('onPullDownRefresh:');
    },

    /**
     * 页面上拉触底事件的处理函数
     */
    onReachBottom: function () {
        console.log('onReachBottom:');
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
    // bindMobileInput:function(e){
    //     console.log('bindMobileInput:');
    //     this.setData({
    //         "form.mobile": e.detail.value
    //     });
    // },
    // bindPasswordInput:function(e){
    //     console.log('bindPasswordInput:');
    //     this.setData({
    //         "form.password": e.detail.value
    //     });
    // },
    btnclick: function (e) {
        // console.log('btnclick:');
        // wx.reLaunch({//关闭当前页面，跳转到应用内的某个页面
        //     url: '../index/index'//url里面就写上你要跳到的地址
        // })
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
        params.preKey = 0;
        // 接口请求数据
        common.interceptors(this);
        this.loginRepos(params);
    },
    formReset: function(e) {
        console.log('form发生了reset事件', e.detail.value)
    },
    loginRepos(params) {
        let apiName = '登陆';
        let apiPath = '/accounts/ajax_login';
        console.log(apiName + apiPath);
        console.log(params);
        this
            .WxRequest
            .postRequest(apiPath,{data:params})
            .then(res => {
                console.log(res);
                let userInfo = common.apiDataHandle(res,1,true);
                console.log(userInfo);
                // 缓存数据
                if(userInfo){
                    // console.log('缓存数据：' );
                    // 缓存数据
                    console.log(this.data.loginCacheKey);
                    common.setSyncCache(this.data.loginCacheKey , userInfo);
                    /*
                    console.log('从缓存中获取：' );
                    // 获得数据
                    let cacheData = common.getSyncCache(this.data.loginCacheKey);
                    console.log(cacheData);
                    */
                    this.loginReLaunch(apiName);
                }
            })
            .catch(err => {
                console.log(err);
                common.showModal({
                    msg: apiName + '失败!',
                });
            })
    },
    judgeLoginRepos(params) {
        let apiName = '登陆状态';
        let apiPath = '/accounts/ajax_login_judge';
        console.log(apiName + apiPath);
        console.log(params);
        this
            .WxRequest
            .postRequest(apiPath,{data:params})
            .then(res => {
                console.log('loginOutRepos');
                console.log(res);
                let result = common.apiDataHandle(res,1,false);
                console.log(result);
                if(result){
                    this.loginReLaunch(apiName);
                }
            })
            .catch(err => {
                console.log(err);
                /*
                common.showModal({
                    msg: apiName + '失败!',
                });
                */
                common.clearSyncCache(params.redisKey);// 删除缓存
            })
    },
    initValidate() {
        // 验证字段的规则
        const rules = {
            account_username: {
                required: true,
                tel: true,
            },
            account_password: {
                required: true,
                minlength: 6,
                maxlength: 20,
            }
        };

        // 验证字段的提示信息，若不传则调用默认的信息
        const messages = {
            account_username: {
                required: '请输入手机号',
                tel: '请输入正确的手机号',
            },
            account_password: {
                required: '请输入密码',
                minlength: '密码长度不少于6位',
                maxlength: '密码长度不多于20位',
            },
        };

        // 创建实例对象
        this.WxValidate = new WxValidate(rules, messages);

        // 自定义验证规则
        // this.WxValidate.addMethod('assistance', (value, param) => {
        //     return this.WxValidate.optional(value) || (value.length >= 1 && value.length <= 2)
        // }, '请勾选1-2个敲码助手')
    },
    loginReLaunch(apiName){// 登陆成功，跳转
        common.showToast(apiName + '成功!','success',app.globalData.alertWaitTime,function() {
            setTimeout(function(){
                wx.reLaunch({//关闭当前页面，跳转到应用内的某个页面
                    url: '../index/index',//url里面就写上你要跳到的地址
                });
            },app.globalData.alertWaitTime);
        },function() {},function() {});// 显示提示
    }
});