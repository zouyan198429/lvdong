//app.js
App({
    onLaunch: function (options) {
      console.log('onLaunch');
      console.log(options);
        /*
          // 展示本地存储能力
          var logs = wx.getStorageSync('logs') || []
          logs.unshift(Date.now())
          wx.setStorageSync('logs', logs)
          */
          /*
          // 登录
          wx.login({
              success: res => {
                // 发送 res.code 到后台换取 openId, sessionKey, unionId
              }
          })
          // 获取用户信息
          wx.getSetting({
              success: res => {
                  if (res.authSetting['scope.userInfo']) {
                      // 已经授权，可以直接调用 getUserInfo 获取头像昵称，不会弹框
                      wx.getUserInfo({
                          success: res => {
                              // 可以将 res 发送给后台解码出 unionId
                              this.globalData.userInfo = res.userInfo

                              // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
                              // 所以此处加入 callback 以防止这种情况
                              if (this.userInfoReadyCallback) {
                                  this.userInfoReadyCallback(res)
                              }
                          }
                      })
                  }
              }
          })
          */
    },
    onShow: function(options) {
        console.log('onShow');
        console.log(options);
        // Do something when show.
    },
    onHide: function() {
        console.log('onHide');
        // Do something when hide.
    },
    onError: function(msg) {
        console.log('onError')
        console.log(msg)
    },
    globalData: {
      userInfo: null,
      loginCacheKey: 'userInfo',
      mUrl:'https://m.kezhuisu.net/',
      webUrl:'https://mp.kezhuisu.net/',
      apiUrl:'https://mp.kezhuisu.net/api'
    }
})