import common from '../../utils/common';
import WxRequest from '../../assets/plugins/wx-request/lib/index';
import dateTime from '../../utils/dateTime';
//获取应用实例
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    focus: false,
    title:'农产品可追溯系统',
    path:'',
    loginCacheKey:app.globalData.loginCacheKey,
    loginUserInfo : null,
    hasLogin : false,
    comname:"陕西百仙果有机农场",
    proname: "洛川红富士苹果",
    proname2: "安美特葡萄",
    selected: true,
    selected1: false,
    swiperitem: ['demo-text-1', 'demo-text-2'],
    indicatorDots: true,
    vertical: false,
    autoplay: false,
    interval: 2000,
    duration: 500,
    hasproductunit:true,
  },
    onLoad: function () {
      console.log('onLoadaaaaaa111000');
    // 判断权限
    let cacheData = common.judgeLogin(this.data.loginCacheKey,'../login/login');

    let count =0 ;
    for(var p in cacheData.proUnits){//遍历json对象的每个key/value对,p为key
        count++;
    }
    console.log(count);
    console.log((cacheData.proUnits.length>0) ? false: true);
    this.setData({
        loginUserInfo: cacheData,
        hasLogin:true,
        hasproductunit: (count>0) ? false : true,
    });

    // 设置标题、path
      let title = "农产品可追溯系统";
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
     * 生命周期函数--监听页面显示
     */
    onShow: function () {
        console.log('onShow:000111');
        // 判断权限
        let cacheData = common.judgeLogin(this.data.loginCacheKey,'../login/login');
        let date_time = dateTime.get_now_timestamp();
        console.log(date_time);
        let diff_time = 60 * 5;
        console.log(diff_time);
        let modifyTime = cacheData.modifyTime || (date_time - diff_time - 1);
        // 重新获得生产单元
        if(date_time - modifyTime >= diff_time){
            common.interceptors(this);
            let params = {
                redisKey:this.data.loginUserInfo.redisKey,
            };
            this.getProUnitRepos(params);
        }

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

  changeIndicatorDots: function (e) {
    this.setData({
      indicatorDots: !this.data.indicatorDots
    })
  },
  changeAutoplay: function (e) {
    this.setData({
      autoplay: !this.data.autoplay
    })
  },
  intervalChange: function (e) {
    this.setData({
      interval: e.detail.value
    })
  },
  durationChange: function (e) {
    this.setData({
      duration: e.detail.value
    })
  },
  selected: function (e) {
    this.setData({
      selected1: false,
      selected: true
    })
  },
  selected1: function (e) {
    this.setData({
      selected: false,
      selected1: true
    })
  },
    goPayLabel:function(e) {
        console.log(e);
        wx.navigateTo({
            url: '../system/paylabel/paylabel',
        })
    },
    goMWeb:function(e) {
        console.log(e);
        /*
        wx.navigateTo({
            url: '../system/paylabel/paylabel',
        })
        */
        console.log(e);
        var id = e.currentTarget.dataset.id;
        console.log(id);
        wx.navigateTo({
            url: '../out/out?aa=1&id=' + id, //
            success: function () {

            },       //成功后的回调；
            fail: function () {
            },         //失败后的回调；
            complete: function () {
            }      //结束后的回调(成功，失败都会执行)
        })
    },
    gotoaddpage:function () {
        wx.navigateTo({
            url: '../productunit/productunit?id=0',
        })
    },
    getProUnitRepos(params) {
        let apiName = '获取数据';
        let apiPath = '/accounts/ajax_pro_unit';
        console.log(apiName + apiPath);
        console.log(params);
        this
            .WxRequest
            .postRequest(apiPath,{data:params})
            .then(res => {
                console.log('loginOutRepos');
                console.log(res);
                let proUnits = common.apiDataHandle(res,1,true,'../login/login');
                console.log(proUnits);
                if(proUnits){
                    let userInfo = common.judgeLogin(this.data.loginCacheKey,'../login/login');
                    userInfo.proUnits = proUnits;
                    common.setSyncCache(this.data.loginCacheKey , userInfo);// 保存缓存数据
                    let count =0 ;
                    for(var p in proUnits){//遍历json对象的每个key/value对,p为key
                        count++;
                    }
                    console.log(count);
                    this.setData({
                        loginUserInfo: userInfo,
                        hasproductunit: (count>0) ? false : true,
                    });
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