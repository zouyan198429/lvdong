import common from '../../utils/common';
import WxRequest from '../../assets/plugins/wx-request/lib/index';
var util = require('../../utils/util.js');
import WxValidate from '../../assets/plugins/wx-validate/WxValidate'
import dateTime from "../../utils/dateTime";
// pages/record/record.js
var app=getApp();// 取得全局App
Page({

  /**
   * 页面的初始数据
   */
  data: {
      focus: false,
      title:'添加生产记录',
      path:'',
      loginCacheKey:app.globalData.loginCacheKey,
      loginUserInfo : null,
      hasLogin : false,
      uploadbtn:false,
      max_pic:9,
      upload_picture_list: [],//装image的数组
      file_name:'',
      resource_id:[],
      pro_unit_id:0,
      resource_url:'',
      pro_input_name:'',
      site_pro_unit_id:0,
      is_node:true,
      id:0,
      info:[],
      ImageLinkArray:[],
      siteTagList:[],
      latitude:'',
      longitude:'',
      auditStatusArray:[
          {"id":0,"name":"待审核"},
          {"id":1,"name":"审核通过"},
          {"id":2,"name":"审核不通过"}
          ],
      auditStatusIndex:0,
      auditStatus:0,
      hiddenAuditStatus:true,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
      console.log('onLoad');
      console.log(options);
      let pro_unit_id = options.pro_unit_id;
      let resource_url = options.resource_url;
      let pro_input_name = options.pro_input_name;
      let site_pro_unit_id = options.site_pro_unit_id;
      console.log(pro_unit_id);
      var id = options.id || 0;
      console.log(id);
      console.log('site_pro_unit_id');
      console.log(site_pro_unit_id);

      // 判断权限
      let cacheData = common.judgeLogin(this.data.loginCacheKey,'../login/login');
      this.setData({
          id:id,
          loginUserInfo: cacheData,
          hasLogin:true,
          hiddenAuditStatus: ( (cacheData.account_issuper == 1) ? false : true ),
          pro_unit_id:pro_unit_id,
          resource_url:resource_url,
          pro_input_name:pro_input_name,
          site_pro_unit_id:site_pro_unit_id,
      });

      // 设置标题、path
      let title = "添加生产记录";
      if(id > 0){
          title = "修改生产记录";
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
      console.log(this.WxValidate)
      // 获得所有标签
      common.interceptors(this);
      this.getSiteTagsRepos(id);
      // 获得详情数据
      if(id > 0 ){
          common.interceptors(this);
          let params = {
              id:id,
              redisKey:this.data.loginUserInfo.redisKey,
          };
          this.getDataInfoRepos(params);
      }
      console.log('获得坐标');
      var that = this;
      wx.getLocation({
          type: 'wgs84',
          success: function(res) {
              var latitude = res.latitude;
              var longitude = res.longitude;
              var speed = res.speed;
              var accuracy = res.accuracy;
              console.log('latitude');
              console.log(latitude);
              console.log('longitude');
              console.log(longitude);
              console.log(speed);
              console.log(accuracy);

              that.setData({
                  latitude:latitude,
                  longitude:longitude,
              });
          }
      });

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
    changeIsNode: function (e){
        console.log(e);
        console.log('switch1 发生 change 事件，携带值为', e.detail.value)
    },
    bindTextAreaBlur:function(e){
        this.setData({
            file_name: e.detail.value
        })
    },
    formSubmit: function(e) {
        console.log('form发生了submit事件，携带数据为：', e.detail.value);
        let params = e.detail.value;
        params.is_node = params.is_node ? 1 : 0;
        console.log(params);
        // 传入表单数据，调用验证方法
        if (!this.WxValidate.checkForm(e)) {
            const error = this.WxValidate.errorList[0];
            common.showModal(error);
            return false;
        }
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
        var date_time = dateTime.get_now_timestamp();
        var intervalId = setInterval(function(){
            // 上传图片
            var status = that.uploadimage();
            console.log('上传状态',status);
            if(status){
                wx.hideLoading();
                clearInterval(intervalId);
                console.log(e.detail.value);
                //提交表单，保存数据
                var selectedTags = [];
                var siteTagList = that.data.siteTagList;
                for (var i = 0; i < siteTagList.length; i++) {
                    if(siteTagList[i].check){
                        selectedTags.push(siteTagList[i].id);
                    }
                }
                console.log(selectedTags);
                params.id = that.data.id;
                params.latitude = that.data.latitude;
                params.longitude = that.data.longitude;
                params.resource_id = that.data.resource_id.join(',');
                params.tag_id = selectedTags.join(',');
                params.redisKey = that.data.loginUserInfo.redisKey;

                params.audit_status = that.data.auditStatusArray[params.audit_status].id;
                console.log(params);
                common.interceptors(that);
                that.saveRepos(params);
            }
            let current_time = dateTime.get_now_timestamp();
            if( (date_time + app.globalData.loopQuitTime) <= current_time){
                wx.hideLoading();
                clearInterval(intervalId);
                console.log('超时');
                common.showModal({
                    msg:  '超时!',
                });
            }
        },2000);
    },
    formReset: function(e) {
        console.log('form发生了reset事件', e.detail.value)
    },
    initValidate() {
        // 验证字段的规则
        const rules = {
            record_intro: {
                required: true,
                minlength: 2,
                maxlength: 250,
            }
        };

        // 验证字段的提示信息，若不传则调用默认的信息
        const messages = {
            record_intro: {
                required: '请输入介绍',
                minlength: '介绍长度不少于2位',
                maxlength: '介绍长度不多于250位',
            },
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
            console.log(j);
            console.log(upload_picture_list[j]);
            if (upload_picture_list[j]['upload_percent'] == 0 ) {
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
    saveRepos(params) {
        let apiName = '保存记录';
        var id = this.data.id;
        if(id>0){
            apiName = '修改记录';
        }
        let pro_unit_id = this.data.pro_unit_id;
        let apiPath = '/handles/' +  pro_unit_id + '/ajax_save';
        var that = this;
        console.log(apiName + apiPath);
        console.log(params);
        this
            .WxRequest
            .postRequest(apiPath,{data:params})
            .then(res => {
                console.log(res);
                let result = common.apiDataHandle(res,1,true,'../login/login');
                console.log(result);
                if(result){
                    var that = this;
                    common.showToast(apiName + '成功','success',app.globalData.alertWaitTime,function() {
                        setTimeout(function(){
                            wx.redirectTo({
                                url: '../history/history?pro_unit_id=' + that.data.pro_unit_id + '&resource_url=' + that.data.resource_url+ '&pro_input_name=' + that.data.pro_input_name+ '&site_pro_unit_id=' + that.data.site_pro_unit_id,
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
    delResourceRecord:function(event){
        console.log('delPicRecord');
        console.log(event);
        let that = this;
        let params = {
            redisKey:this.data.loginUserInfo.redisKey,
        };
        var resource_id = event.currentTarget.dataset.id;
        let index  = event.currentTarget.id;
        if(resource_id <= 0 ){
            common.setShowModel({
                title:"提示",
                content:"确定移除当前记录？",
            },function() {// 点确定
                // 移除当前记录
                let upload_picture_list = that.data.upload_picture_list;
                upload_picture_list.splice(index, 1);
                console.log(upload_picture_list);
                that.setData({
                    upload_picture_list: upload_picture_list,
                });
            },function() {},function() {},function() {});
            return false;
        }
        params.id = resource_id;
        common.setShowModel({
            title:"提示",
            content:"确定删除当前记录？删除后不可恢复!",
        },function() {// 点确定
            // 删除数据
            common.interceptors(that);
            that.delResourceRepos(params,index);
        },function() {},function() {},function() {});
    },
    delResourceRepos(params,index) {
        let apiName = '删除图片';
        let apiPath = '/upload/ajax_del';
        console.log(apiName + apiPath);
        console.log(params);
        this
            .WxRequest
            .postRequest(apiPath,{data:params})
            .then(res => {
                console.log('loginOutRepos');
                console.log(res);
                let result = common.apiDataHandle(res,1,true,'../login/login');
                console.log(result);
                if(result){
                    var that = this;
                    common.showToast( apiName + '成功！','success',app.globalData.alertWaitTime,function() {
                        setTimeout(function(){
                            // 移除当前记录
                            let upload_picture_list = that.data.upload_picture_list;
                            upload_picture_list.splice(index, 1);
                            console.log(upload_picture_list);
                            var resource_ids = that.data.resource_id;
                            resource_ids.splice( resource_ids.indexOf(params.id), 1 );
                            console.log(resource_ids);
                            that.setData({
                                upload_picture_list: upload_picture_list,
                                resource_id:resource_ids,
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
    getSiteTagsRepos(recordId) {
        var that = this;
        let apiName = '获取数据';
        let apiPath = '/handles/' + that.data.pro_unit_id + '/ajax_getTags';
        console.log(apiName + apiPath);
        let params = {
            recordId:recordId,
            site_pro_unit_id:that.data.site_pro_unit_id,
            redisKey:that.data.loginUserInfo.redisKey,
        };
        console.log(params);
        this
            .WxRequest
            .postRequest(apiPath,{data:params})
            .then(res => {
                console.log(res);
                let result = common.apiDataHandle(res,1,true,'../login/login');
                console.log(result);
                if(result){
                    that.setData({
                        "siteTagList":result,
                    });
                    /*
                    common.showToast(apiName + '成功!','success',app.globalData.alertWaitTime,function() {
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
    getDataInfoRepos(params) {
    let apiName = '获取数据';
    let apiPath = '/handles/' + this.data.pro_unit_id + '/ajax_info';
    console.log(apiName + apiPath);
    console.log(params);
    this
        .WxRequest
        .postRequest(apiPath,{data:params})
        .then(res => {
            console.log('loginOutRepos');
            console.log(res);
            let result = common.apiDataHandle(res,1,true,'../login/login');
            console.log(result);
            if(result){
                var that = this;
                var resource_ids = that.data.resource_id;
                var upload_picture_list = result.upload_picture_list || [];
                var ImageLinkArray = that.data.ImageLinkArray;
                for (var i = 0; i < upload_picture_list.length; i++) {
                    var path_server = upload_picture_list[i].path;
                    ImageLinkArray = ImageLinkArray.concat(path_server);
                    resource_ids.push(upload_picture_list[i].resource_id);
                }
                console.log('ImageLinkArray');
                console.log(ImageLinkArray);
                //if(upload_picture_list.length > 0){
                //   resource_ids.push(upload_picture_list[0].resource_id);
                //}

                let audit_status = result.audit_status;
                let auditStatusArray = that.data.auditStatusArray;
                let auditStatusIndex = 0;
                let auditStatus = 0;
                for (var i = 0; i < auditStatusArray.length; i++) {
                    if(auditStatusArray[i].id == audit_status){
                        auditStatusIndex = i;
                        auditStatus = auditStatusArray[i].id;
                        break;
                    }
                }

                that.setData({
                    ImageLinkArray: ImageLinkArray,
                    is_node: !!(result.is_node),
                    info:result,
                    auditStatusIndex:auditStatusIndex,
                    auditStatus:auditStatus,
                    upload_picture_list:upload_picture_list,
                    resource_id: resource_ids,
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
    rmTag:function(event){
        console.log('rmTag');
        console.log(event);
        let that = this;
        //let params = {
        //    redisKey:this.data.loginUserInfo.redisKey,
        //};
        var siteTagList = that.data.siteTagList;
        let id = event.currentTarget.dataset.id;
        let index  = event.currentTarget.id;
        siteTagList[index].check = false;
        that.setData({
            siteTagList: siteTagList,
        });
    },
    addTag:function(event){
        console.log('addTag');
        console.log(event);
        let that = this;
        //let params = {
        //    redisKey:this.data.loginUserInfo.redisKey,
        //};
        var siteTagList = that.data.siteTagList;
        let id = event.currentTarget.dataset.id;
        let index  = event.currentTarget.id;
        siteTagList[index].check = true;
        that.setData({
            siteTagList: siteTagList,
        });
    },
    clickImage: function (e) {
        console.log(e);
        var current = e.target.dataset.src;
        var ImageLinkArray = this.data.ImageLinkArray;
        common.previewImage(current,ImageLinkArray);
    },
    auditStatusChange:function(e){
        console.log('picker发送选择改变，携带值为', e.detail.value)
        var index = e.detail.value;
        var currentId = this.data.auditStatusArray[index].id; // 这个id就是选中项的id
        var name = this.data.auditStatusArray[index].name;
        console.log(currentId);
        console.log(name);
        this.setData({
            auditStatusIndex:index,
            auditStatus:currentId,
        });
    }
});