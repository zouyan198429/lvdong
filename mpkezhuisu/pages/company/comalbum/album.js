import common from '../../../utils/common';
import WxRequest from '../../../assets/plugins/wx-request/lib/index';

// pages/company/comalbum/album.js
var app=getApp();// 取得全局App
Page({

  /**
   * 页面的初始数据
   */
  data: {
      focus: false,
      title:'企业相册',
      path:'',
      loginCacheKey:app.globalData.loginCacheKey,
      loginUserInfo : null,
      hasLogin : false,
      dataList: [],
      hasPage:false,
      ImageLinkArray:[],
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
      let title = "企业相册";
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
      // 获得列表数据
      common.interceptors(this);
      let params = {
          redisKey:this.data.loginUserInfo.redisKey,
      };
      this.getDataListRepos(params);
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
  gotoaddpage: function () {
    wx.navigateTo({
      url: '../comalbumadd/albumadd',
    })
  },
    getDataListRepos(params) {
        let apiName = '获取数据';
        let apiPath = '/photo/ajax_alist';
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
                    var that = this;
                    var data_list = result.data_list || [];
                    var ImageLinkArray = that.data.ImageLinkArray;
                    for (var i = 0; i < data_list.length; i++) {
                        var site_resources = data_list[i].resource_url;
                        ImageLinkArray.push(site_resources);
                    }
                    console.log('ImageLinkArray');
                    console.log(ImageLinkArray);
                    that.setData({
                        ImageLinkArray: ImageLinkArray,
                        dataList: result.data_list,
                        hasPage:result.has_page,
                    });
                    /*
                    common.showToast( apiName + '成功！','success',app.globalData.alertWaitTime,function() {
                        setTimeout(function(){
                            // wx.navigateBack({
                            //     delta: 1,
                            // })
                            // wx.redirectTo({
                            //     url: '../userpass/userpass',
                            // })
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
    delRecord:function(event){
        console.log('delRecord');
        console.log(event);
        let that = this;
        let params = {
            redisKey:this.data.loginUserInfo.redisKey,
        };
        params.id = event.currentTarget.dataset.id;
        let index  = event.currentTarget.id;
        common.setShowModel({
            title:"提示",
            content:"确定删除当前记录？删除后不可恢复!",
        },function() {// 点确定
            // 删除数据
            common.interceptors(that);
            that.delRepos(params,index);
        },function() {},function() {},function() {});
    },
    delRepos(params,index) {
        let apiName = '删除数据';
        let apiPath = '/photo/ajax_del';
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
                    var that = this;
                    common.showToast( apiName + '成功！','success',app.globalData.alertWaitTime,function() {
                        setTimeout(function(){
                            // 移除当前记录
                            let dataList = that.data.dataList;
                            dataList.splice(index, 1);
                            that.setData({
                                dataList: dataList,
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
    clickImage: function (e) {
        console.log(e);
        var current = e.target.dataset.src;
        var ImageLinkArray = this.data.ImageLinkArray;
        common.previewImage(current,ImageLinkArray);
    },
});