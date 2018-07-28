import common from '../../utils/common';
import WxRequest from '../../assets/plugins/wx-request/lib/index';
var util = require('../../utils/util.js');
import WxValidate from '../../assets/plugins/wx-validate/WxValidate'
import dateTime from '../../utils/dateTime';
import validate from '../../utils/validate';
// pages/cominfo/cominfo.js
var app=getApp();// 取得全局App
Page({

  /**
   * 页面的初始数据
   */
  data: {
      focus: false,
      title:'申请生产单元',
      path:'',
      loginCacheKey:app.globalData.loginCacheKey,
      loginUserInfo : null,
      hasLogin : false,
      firstClsList:[],
      firstClsIndex:0,
      firstCls:0,
      secendClsList:[],
      secendClsIndex:0,
      secendCls:0,
      begin_time:'',
      end_time:'',
      endDate:dateTime.get_now_format('Y-m-d'),
      phonenumber:app.globalData.phonenumber,
      acountList:[],
      uploadbtn:false,
      max_pic:1,
      upload_picture_list: [],//装image的数组
      file_name:'',
      resource_id:[],
      id:0,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
      console.log('onLoad');
      console.log(options);
      //var id = options.id;
      //console.log(id);
      // 判断权限
      let cacheData = common.judgeLogin(this.data.loginCacheKey,'../login/login');
      this.setData({
          loginUserInfo: cacheData,
          hasLogin:true,
      });

      // 设置标题、path
      let title = "申请生产单元";
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
      // 获得第一级分类
      common.interceptors(this);
      this.getClsRepos(0,1);
      // 获得所有帐号
      common.interceptors(this);
      this.getAccountsRepos(0);
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
    bindBeginDateChange: function(e) {
        console.log('picker发送选择改变，携带值为', e.detail.value)
        this.setData({
            "begin_time": e.detail.value
        })
    },
    bindEndDateChange: function(e) {
        console.log('picker发送选择改变，携带值为', e.detail.value)
        this.setData({
            "end_time": e.detail.value
        })
    },
    bindFirstClsChange:function(e){
        console.log('picker发送选择改变，携带值为', e.detail.value)
        var index = e.detail.value;
        var currentId = this.data.firstClsList[index].id; // 这个id就是选中项的id
        var name = this.data.firstClsList[index].name;
        console.log(currentId);
        console.log(name);
        this.setData({
            firstClsIndex:index,
            firstCls:currentId,
            secendClsList:[],
            secendClsIndex:0,
            secendCls:0,
        });
        // 获得县/区
        common.interceptors(this);
        this.getClsRepos(currentId,2);
    },
    bindSecondClsChange:function(e){
        console.log('picker发送选择改变，携带值为', e.detail.value)
        var index = e.detail.value;
        var currentId = this.data.secendClsList[index].id; // 这个id就是选中项的id
        var name = this.data.secendClsList[index].name;
        console.log(currentId);
        console.log(name);
        this.setData({
            secendClsIndex:index,
            secendCls:currentId,
        });
    },
    checkboxChange: function(e) {
        console.log('checkbox发生change事件，携带value值为：', e.detail.value)
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
        // 判断日期
        var begin_time = params.begin_time;
        var end_time = params.end_time;
        var  errMsg = validate.judge_validate(1,'结束日期必须',end_time,true,'data_size',begin_time,5);
        if(errMsg != ''){
            common.showModal({
                msg: '结束日期必须大于开始日期!',
            });
            return false;
        }
        params.accout_id = params.accout_id.join(",");
        params.redisKey = this.data.loginUserInfo.redisKey;
        params.site_pro_unit_id = this.data.firstClsList[params.site_pro_unit_id].id;
        params.site_pro_unit_id_two = this.data.secendClsList[params.site_pro_unit_id_two].id;
        console.log(params);

        // 上传图片
        console.log('开始上传图片');
        var upload_picture_list = this.data.upload_picture_list;
        var pic_count = upload_picture_list.length;
        console.log('已经上传数量' +pic_count);
        if(pic_count <= 0){
            common.showModal({
                msg:  '请选择要上传的资料!',
            });
            return false;
        }
        var that = this;

        wx.showLoading({
            mask:true,
            title: '上传中...',
        });
        // 上传图片
        var intervalId = setInterval(function(){
            // 上传图片
            var status = that.uploadimage();
            console.log('上传状态',status);
            if(status){
                wx.hideLoading();
                clearInterval(intervalId);
                console.log(e.detail.value);
                //提交表单，保存数据
                params.resource_id = that.data.resource_id[0];
                // 接口请求数据
                common.interceptors(that);
                that.saveRepos(params);
            }
        },1000);
    },
    formReset: function(e) {
        console.log('form发生了reset事件', e.detail.value)
    },
    saveRepos(params) {
        let apiName = '保存';
        let apiPath = '/productunit/ajax_save';
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
            site_pro_unit_id: {
                required: true,
                min: 1,
            },
            pro_input_name: {
                required: true,
                minlength: 2,
                maxlength: 40,
            },
            pro_input_brand: {
                required: true,
                minlength: 2,
                maxlength: 20,
            },
            pro_input_batch: {
                required: true,
                minlength: 2,
                maxlength: 30,
            },
            begin_time: {
                required: true,
                date: true,
            },
            end_time: {
                required: true,
                date: true,
            },
            accout_id: {
                required: true,
                accout_id: true,
            },
            pro_input_intro: {
                required: true,
                minlength: 2,
                maxlength: 1000,
            },
        };

        // 验证字段的提示信息，若不传则调用默认的信息
        const messages = {
            site_pro_unit_id: {
                required: '请选择一级类型',
                min: '请选择一级类型',
            },
            pro_input_name: {
                required: '请输入产品全称',
                minlength: '产品全称长度不少于2位',
                maxlength: '产品全称长度不多于40位',
            },
            pro_input_brand: {
                required: '请输入品种/品牌',
                minlength: '品种/品牌长度不少于2位',
                maxlength: '品种/品牌长度不多于20位',
            },
            pro_input_batch: {
                required: '请输入批次',
                minlength: '批次长度不少于2位',
                maxlength: '批次长度不多于30位',
            },
            begin_time: {
                required: '请选择开始日期',
                date: '开始日期格式有误',
            },
            end_time: {
                required: '请选择结束日期',
                date: '结束日期格式有误',
            },
            accout_id: {
                required: '请勾选至少1名维护负责人',
                accout_id: '请勾选至少1名维护负责人',
            },
            pro_input_intro: {
                required: '请输入产品简介',
                minlength: '产品简介长度不少于2位',
                maxlength: '产品简介长度不多于1000位',
            },
        };

        // 创建实例对象
        this.WxValidate = new WxValidate(rules, messages);

        // 自定义验证规则
        this.WxValidate.addMethod('accout_id', (value, param) => {
            return this.WxValidate.optional(value) || (value.length >= 1 )
        }, '请勾选至少1名维护负责人')
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
    getClsRepos(area_id,level) {
        var that = this;
        let apiName = '获取数据';
        let apiPath = '/unitClsList';
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
                                case 1:// 第一级
                                    that.setData({
                                        "firstClsList":result,
                                    });
                                    break;
                                case 2:// 第二级
                                    that.setData({
                                        "secendClsList":result,
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
    getAccountsRepos(unitId) {
        var that = this;
        let apiName = '获取数据';
        let apiPath = '/accounts/ajax_getAccount';
        console.log(apiName + apiPath);
        let params = {
            unitId:unitId,
            redisKey:this.data.loginUserInfo.redisKey,
        };
        console.log(params);
        this
            .WxRequest
            .postRequest(apiPath,{data:params})
            .then(res => {
                console.log(res);
                let result = common.apiDataHandle(res,1);
                console.log(result);
                if(result){
                    common.showToast(apiName + '成功!','success',2000,function() {
                        setTimeout(function(){
                            that.setData({
                                "acountList":result,
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
    //选择图片方法
    uploadpic: function (e) {
        var that = this//获取上下文
        var upload_picture_list = that.data.upload_picture_list;
        var pic_count = upload_picture_list.length;
        console.log('已经上传数量' +pic_count);
        var max_pic =that.data.max_pic;
        console.log('最多上传数量' + max_pic);
        if(pic_count >= max_pic){
            common.showModal({
                msg:  '最多只能上传' + max_pic + '张!',
            });
            return false;
        }
        // 还可以上传的张数
        var choose_num = max_pic - pic_count;
        //选择图片
        wx.chooseImage({
            count: choose_num, // 默认9，这里显示一次选择相册的图片数量
            sizeType: ['original', 'compressed'],// 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'],// 可以指定来源是相册还是相机，默认二者都有
            success: function (res) {// 返回选定照片的本地文件路径列表，tempFilePath可以作为img标签的src属性显示图片
                var tempFiles = res.tempFiles;
                //把选择的图片 添加到集合里
                for (var i in tempFiles) {
                    tempFiles[i]['upload_percent'] = 0;
                    tempFiles[i]['path_server'] = '';
                    tempFiles[i]['resource_id'] = 0;
                    upload_picture_list.push(tempFiles[i]);
                }
                //显示
                that.setData({
                    upload_picture_list: upload_picture_list,
                })
            }
        })
    },
    //点击上传事件 true：已经上传完，false：还有正在上传的
    uploadimage: function () {
        console.log('uploadimage');
        var page = this;
        var return_status = true;// true：已经上传完，false：还有正在上传的
        var upload_picture_list = page.data.upload_picture_list;
        //循环把图片上传到服务器 并显示进度
        for (var j in upload_picture_list) {
            if (upload_picture_list[j]['upload_percent'] == 0) {
                page.upload_file_server(page, upload_picture_list, j);
            }
            if(upload_picture_list[j]['resource_id'] == 0){
                return_status = false;
            }
        }
        return return_status;
    },
    upload_file_server(that, upload_picture_list, j){
        console.log('upload_file_server');
        //上传方法
        //var time = new Date();
        //console.log(time);
        // var datetime = util.formatTime(time);//获取时间 防止命名重复
        // console.log(datetime);
        // var date = datetime.substring(0, 8);//获取日期 分日期 文件夹存储
        console.log("开始上传" + j + "图片到服务器：");
        console.log({
            'num': j,
            //'datetime': datetime,
            //'date': date
            'name': that.data.file_name,
            'redisKey':that.data.loginUserInfo.redisKey
        });
        //上传返回值
        var upload_task = wx.uploadFile({
            //url: 'http//Index/Imageadmin/imageupload',//需要用HTTPS，同时在微信公众平台后台添加服务器地址
            // url: 'http://comp.kezhuisu.com/imageupload.php',
            // url: 'http://comp.kezhuisu.com/api/upload',
            url:app.globalData.apiUrl + '/upload',
            filePath: upload_picture_list[j]['path'], //上传的文件本地地址
            name: 'photo',
            formData: {
                'num': j,
                //'datetime': datetime,
                //'date': date
                'name': that.data.file_name,
                'redisKey':that.data.loginUserInfo.redisKey
            },
            //附近数据，这里为路径
            success: function (res) {
                console.log(res);
                //console.log(res.data);
                var data = JSON.parse(res.data);
                // var data = res.data;
                console.log(data);
                console.log(typeof(data));
                console.log(data.result);
                //字符串转化为JSON
                if (data.result == 'ok') {
                    console.log('OK');
                    // 资源id处理
                    var resource_ids = that.data.resource_id;
                    resource_ids.push(data.id);
                    that.setData({
                        resource_id: resource_ids,
                    })
                    //var filename = "http://127.0.0.1:8095/" + data.file//存储地址 显示
                    var filename = data.url;//存储地址 显示
                    upload_picture_list[j]['path_server'] = filename;
                    upload_picture_list[j]['resource_id'] = data.id;
                } else {
                    var filename = app.globalData.webUrl + "img/upfail.jpg";//错误图片 显示
                    upload_picture_list[j]['path_server'] = filename;
                    upload_picture_list[j]['resource_id'] = -1;
                }
                that.setData({
                    upload_picture_list: upload_picture_list
                })
            }
        });
        //上传 进度方法
        upload_task.onProgressUpdate((res) => {
            upload_picture_list[j]['upload_percent'] = res.progress
            //console.log('第' + j + '个图片上传进度：' + upload_picture_list[j]['upload_percent'])
            //console.log(upload_picture_list)
            that.setData({ upload_picture_list: upload_picture_list })
        })
    },
});