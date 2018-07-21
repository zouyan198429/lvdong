import common from '../../utils/common';
import WxRequest from '../../assets/plugins/wx-request/lib/index';
var util = require('../../utils/util.js');
import WxValidate from '../../assets/plugins/wx-validate/WxValidate'
// pages/inputadd/inputadd.js
var app=getApp();// 取得全局App
Page({

  /**
   * 页面的初始数据
   */
  data: {
      focus: false,
      title:'添加生产投入品',
      path:'',
      loginCacheKey:app.globalData.loginCacheKey,
      loginUserInfo : null,
      hasLogin : false,
      uploadbtn:false,
      max_pic:1,
      upload_picture_list: [],//装image的数组
      file_name:'',
      resource_id:[],
      dataList: [],
      index:0,
      hasPage:false,
      pro_unit_id:0,

      objectArray: [
          {
            id: 0,
            name: '种子'
          },
          {
            id: 1,
            name: '肥料'
          },
          {
            id: 2,
            name: '其他'
          }
      ],
      imageList: [],
      sourceTypeIndex: 2,
      sourceType: ['拍照', '相册', '拍照或相册'],

      sizeTypeIndex: 2,
      sizeType: ['压缩', '原图', '压缩或原图'],

      countIndex: 8,
      count: [1, 2, 3, 4, 5, 6, 7, 8, 9]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

      let pro_unit_id = options.pro_unit_id;
      console.log(pro_unit_id);

      // 判断权限
      let cacheData = common.judgeLogin(this.data.loginCacheKey,'../login/login');
      this.setData({
          loginUserInfo: cacheData,
          hasLogin:true,
          pro_unit_id:pro_unit_id,
      });

      // 设置标题、path
      let title = "添加生产投入品";
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
      // 获得分类
      // 获得列表数据
      common.interceptors(this);
      let params = {
          redisKey:this.data.loginUserInfo.redisKey,
      };
      this.getDataListRepos(params,pro_unit_id);
  },

  bindPickerChange: function (e) {
    console.log('picker发送选择改变，携带值为', e.detail.value)
    var index = e.detail.value;
    var currentId = this.data.dataList[index].id; // 这个id就是选中项的id
    this.setData({
      index: e.detail.value
    })
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
    reportNameInput:function(e){
        this.setData({
            file_name: e.detail.value
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
        params.site_input_id = this.data.dataList[params.site_input_id_ubound].id;
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
                params.redisKey = that.data.loginUserInfo.redisKey;
                console.log(params);
                common.interceptors(that);
                that.saveRepos(params);
            }
        },1000);
    },
    formReset: function(e) {
        console.log('form发生了reset事件', e.detail.value)
    },
    initValidate() {
        // 验证字段的规则
        const rules = {
            site_input_id_ubound: {
                required: true,
            },
            pro_input_name: {
                required: true,
                minlength: 2,
                maxlength: 26,
            },
            pro_input_brand: {
                required: true,
                minlength: 2,
                maxlength: 16,
            },
            pro_input_factory: {
                required: true,
                minlength: 2,
                maxlength: 36,
            },
            pro_input_intro: {
                required: true,
                minlength: 2,
                maxlength: 500,
            }
        };

        // 验证字段的提示信息，若不传则调用默认的信息
        const messages = {
            site_input_id_ubound: {
                required: '请选择类型',
            },
            pro_input_name: {
                required: '请输入产品名称',
                minlength: '产品名称长度不少于2位',
                maxlength: '产品名称长度不多于26位',
            },
            pro_input_brand: {
                required: '请输入产品品牌',
                minlength: '产品品牌长度不少于2位',
                maxlength: '产品品牌长度不多于26位',
            },
            pro_input_factory: {
                required: '请输入生产厂家',
                minlength: '生产厂家长度不少于2位',
                maxlength: '生产厂家长度不多于36位',
            },
            pro_input_intro: {
                required: '请输入简介',
                minlength: '简介长度不少于2位',
                maxlength: '简介长度不多于500位',
            }
        };

        // 创建实例对象
        this.WxValidate = new WxValidate(rules, messages);

        // 自定义验证规则
        // this.WxValidate.addMethod('assistance', (value, param) => {
        //     return this.WxValidate.optional(value) || (value.length >= 1 && value.length <= 2)
        // }, '请勾选1-2个敲码助手')
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
    getDataListRepos(params,pro_unit_id) {
        let apiName = '获取数据';
        let apiPath = 'sys/ajax_alist_site_inputs';
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
                                dataList: result.data_list,
                                hasPage:result.has_page,
                            });
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
    saveRepos(params) {
        let apiName = '保存记录';
        let pro_unit_id = this.data.pro_unit_id;
        params.pro_unit_id = pro_unit_id;
        let apiPath = 'inputs/ajax_save';
        var that = this;
        console.log(apiName + apiPath);
        console.log(params);
        this
            .WxRequest
            .postRequest(apiPath,{data:params})
            .then(res => {
                console.log(res);
                let result = common.apiDataHandle(res,1);
                console.log(result);
                if(result){
                    var that = this;
                    common.showToast(apiName + '成功','success',2000,function() {
                        setTimeout(function(){
                            wx.redirectTo({
                                url: '../input/input?pro_unit_id=' + that.data.pro_unit_id,
                            });
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
  sourceTypeChange: function (e) {
    this.setData({
      sourceTypeIndex: e.detail.value
    })
  },
  sizeTypeChange: function (e) {
    this.setData({
      sizeTypeIndex: e.detail.value
    })
  },
  countChange: function (e) {
    this.setData({
      countIndex: e.detail.value
    })
  },
 
})