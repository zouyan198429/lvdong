import common from '../../../utils/common';
import WxRequest from '../../../assets/plugins/wx-request/lib/index';
var util = require('../../../utils/util.js');
import WxValidate from '../../../assets/plugins/wx-validate/WxValidate'
import dateTime from '../../../utils/dateTime';
// pages/company/cominfo/cominfo.js
var app=getApp();// 取得全局App
Page({

  /**
   * 页面的初始数据
   */
  data: {
      focus: false,
      title:'企业信息',
      path:'',
      loginCacheKey:app.globalData.loginCacheKey,
      loginUserInfo : null,
      hasLogin : false,
      provinceList:[],
      provinceIndex:0,
      province:0,
      cityList:[],
      cityIndex:0,
      city:0,
      areaList:[],
      areaIndex:0,
      area:0,
      endDate:dateTime.get_now_format('Y-m-d'),
      companyInfo:{},
      phonenumber:app.globalData.phonenumber,
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
      let title = "企业信息";
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
      common.interceptors(this);
      let params = {
          redisKey:this.data.loginUserInfo.redisKey,
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
    bindDateChange: function(e) {
        console.log('picker发送选择改变，携带值为', e.detail.value)
        this.setData({
            "companyInfo.company_createtime": e.detail.value
        })
    },
    bindProvinceChange: function (e) {
        console.log('picker发送选择改变，携带值为', e.detail.value)
        var index = e.detail.value;
        var currentId = this.data.provinceList[index].id; // 这个id就是选中项的id
        var name = this.data.provinceList[index].name;
        console.log(currentId);
        console.log(name);
        this.setData({
            provinceIndex: index,
            province:currentId,
            cityList:[],
            cityIndex:0,
            city:0,
            areaList:[],
            areaIndex:0,
            area:0,
        });
        // 获得市
        common.interceptors(this);
        this.getAreaRepos(currentId,2);
    },
    bindCityChange:function(e){
        console.log('picker发送选择改变，携带值为', e.detail.value)
        var index = e.detail.value;
        var currentId = this.data.cityList[index].id; // 这个id就是选中项的id
        var name = this.data.cityList[index].name;
        console.log(currentId);
        console.log(name);
        this.setData({
            cityIndex:index,
            city:currentId,
            areaList:[],
            areaIndex:0,
            area:0,
        });
        // 获得县/区
        common.interceptors(this);
        this.getAreaRepos(currentId,3);
    },
    bindAreaChange:function(e){
        console.log('picker发送选择改变，携带值为', e.detail.value)
        var index = e.detail.value;
        var currentId = this.data.cityList[index].id; // 这个id就是选中项的id
        var name = this.data.cityList[index].name;
        console.log(currentId);
        console.log(name);
        this.setData({
            areaIndex:index,
            area:currentId,
        });
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
        params.province_id = this.data.provinceList[params.province_id].id;
        params.city_id = this.data.cityList[params.city_id].id;
        params.area_id = this.data.areaList[params.area_id].id;
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
        let apiPath = '/company/ajax_save';
        console.log(apiName + apiPath);
        console.log(params);
        this
            .WxRequest
            .postRequest(apiPath,{data:params})
            .then(res => {
                console.log(res);
                let resReg = common.apiDataHandle(res,1);
                console.log(resReg);
                if(resReg){// 跳转到登陆
                    common.showToast(apiName + '成功!','success',2000,function() {
                        setTimeout(function(){
                            wx.redirectTo({
                                url: '../index/index'
                            });
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
            company_name: {
                required: true,
                minlength: 2,
                maxlength: 40,
            },
            company_simple_name: {
                required: true,
                minlength: 2,
                maxlength: 30,
            },
            province_id: {
                required: true,
                min: 1,
            },
            city_id: {
                required: true,
                min: 1,
            },
            area_id: {
                required: true,
                min: 1,
            },
            company_addr: {
                required: true,
                minlength: 2,
                maxlength: 100,
            },
            product_addr: {
                required: true,
                minlength: 2,
                maxlength: 60,
            },
            ccredit_code: {
                required: true,
                minlength: 2,
                maxlength: 50,
            },
            company_createtime: {
                required: true,
                date: true,
            },
            legal_name: {
                required: true,
                minlength: 2,
                maxlength: 50,
            },
            company_mainproduct: {
                required: true,
                minlength: 2,
                maxlength: 1000,
            },
            contact_way: {
                required: true,
                minlength: 2,
                maxlength: 500,
            },
        };

        // 验证字段的提示信息，若不传则调用默认的信息
        const messages = {
            company_name: {
                required: '请输入企业全称',
                minlength: '企业全称长度不少于2位',
                maxlength: '企业全称长度不多于40位',
            },
            company_simple_name: {
                required: '请输入企业简称',
                minlength: '企业简称长度不少于2位',
                maxlength: '企业简称长度不多于30位',
            },
            province_id: {
                required: '请选择省',
                min: '请选择省',
            },
            city_id: {
                required: '请选择市',
                min: '请选择市',
            },
            area_id: {
                required: '请选择县/地区',
                min: '请选择县/地区',
            },
            company_addr: {
                required: '请输入公司地址',
                minlength: '公司地址长度不少于2位',
                maxlength: '公司地址长度不多于100位',
            },
            product_addr: {
                required: '请输入生产地址',
                minlength: '生产地址长度不少于2位',
                maxlength: '生产地址长度不多于60位',
            },
            ccredit_code: {
                required: '请输入信用代码',
                minlength: '信用代码长度不少于2位',
                maxlength: '信用代码长度不多于50位',
            },
            company_createtime: {
                required: '请选择成立时间',
                date: '成立时间格式有误',
            },
            legal_name: {
                required: '请输入法定代表人',
                minlength: '法定代表人长度不少于2位',
                maxlength: '法定代表人长度不多于50位',
            },
            company_mainproduct: {
                required: '请输入经营项目',
                minlength: '经营项目长度不少于2位',
                maxlength: '经营项目长度不多于1000位',
            },
            contact_way: {
                required: '请输入联系方式',
                minlength: '联系方式长度不少于2位',
                maxlength: '联系方式长度不多于500位',
            },

        };

        // 创建实例对象
        this.WxValidate = new WxValidate(rules, messages);

        // 自定义验证规则
        // this.WxValidate.addMethod('assistance', (value, param) => {
        //     return this.WxValidate.optional(value) || (value.length >= 1 && value.length <= 2)
        // }, '请勾选1-2个敲码助手')
    },
    getAreaRepos(area_id,level) {
        var that = this;
        let apiName = '获取数据';
        let apiPath = '/areaList';
        console.log(apiName + apiPath);
        let params = {
            area_id:area_id,
            level:level,
        };
        console.log(params);
        var firstObj =  {
            "id": "0",
            "name": "请选择"
        };
        this
            .WxRequest
            .postRequest(apiPath,{data:params})
            .then(res => {
                console.log('loginOutRepos');
                console.log(res);
                let result = common.apiDataHandle(res,1);
                console.log(result);
                if(result){
                    result.unshift(firstObj);// 前面加上请选择
                    common.showToast(apiName + '成功!','success',2000,function() {
                        setTimeout(function(){
                            switch(level){
                                case 1:// 省
                                    console.log('获得省索引');
                                    var provinceIndex = result.findIndex(function checkAdult(item) {
                                        return item.id == that.data.province;
                                    });
                                    console.log(provinceIndex);
                                    that.setData({
                                        "provinceList":result,
                                        "provinceIndex":provinceIndex,
                                    });
                                    if(that.data.province){// 处理市
                                        common.interceptors(that);
                                        that.getAreaRepos(that.data.province,2);
                                    }
                                    break;
                                case 2:// 2 市
                                    console.log('获得市索引');
                                    var cityIndex = result.findIndex(function checkAdult(item) {
                                        return item.id == that.data.city;
                                    });
                                    console.log(cityIndex);
                                    that.setData({
                                        "cityList":result,
                                        "cityIndex":cityIndex,
                                    });
                                    if(that.data.city){// 获得县/区
                                        common.interceptors(that);
                                        that.getAreaRepos(that.data.city,3);
                                    }
                                    break;
                                case 3:// 3 县区
                                    console.log('获得县/区索引');
                                    var areaIndex = result.findIndex(function checkAdult(item) {
                                        return item.id == that.data.area;
                                    });
                                    console.log(areaIndex);
                                    that.setData({
                                        "areaList":result,
                                        "areaIndex":areaIndex,
                                    });
                                    break;
                                default://
                                    break;
                            }
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
                let result = common.apiDataHandle(res,1);
                console.log(result);
                if(result){
                    var that = this;
                    common.showToast( apiName + '成功！','success',2000,function() {
                        setTimeout(function(){
                            that.setData({
                                companyInfo:result,
                                province:result.province_id,
                                city:result.city_id,
                                area:result.area_id,
                            });
                            // 获得省
                            common.interceptors(that);
                            that.getAreaRepos(0,1);
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
});