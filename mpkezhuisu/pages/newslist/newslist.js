// pages/newslist/newslist.js
import common from '../../utils/common';
import WxRequest from '../../assets/plugins/wx-request/lib/index';
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
      dataList: [],
      page:1,
      hasPage:false,
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

      // 判断权限
      let cacheData = common.judgeLogin(this.data.loginCacheKey,'../login/login');
      this.setData({
          loginUserInfo: cacheData,
          hasLogin:true,
      });

      // 设置标题、path
      let title = "新闻公告";
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
      // 获得列表数据
      common.interceptors(this);
      let params = {
          redisKey:this.data.loginUserInfo.redisKey,
          page:1,//this.data.page,
      };
      this.getDataListRepos(params);
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
      console.log('触底了');
      let hasPage = this.data.hasPage;
      if(!hasPage){
         return false;
      }
      let page  = this.data.page;
      // 获得列表数据
      common.interceptors(this);
      let params = {
          redisKey:this.data.loginUserInfo.redisKey,
          page:page+1,//this.data.page,
      };
      this.getDataListRepos(params);
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

  newslink: function (e) {
    console.log(e);
    let id = e.target.dataset.id;
    console.log(id);
    wx.navigateTo({
      url: '../newsview/newsview?id='+ id,
    })
  },
    getDataListRepos(params) {
        let apiName = '获取数据';
        let apiPath = '/new/ajax_alist';
        var page = params.page;
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
                    var res_data_list = result.data_list;
                    if(res_data_list.length>0){
                        console.log('有记录');
                        var dataList = that.data.dataList;
                        dataList = dataList.concat(res_data_list);
                        that.setData({
                            page:page,
                            dataList: dataList,
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
                    }else{
                        console.log('无记录');
                    }
                }
            })
            .catch(err => {
                console.log(err);
                common.showModal({
                    msg: apiName + '失败!',
                });
            })
    },
})