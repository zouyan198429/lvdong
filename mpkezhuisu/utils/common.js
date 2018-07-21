class common {
    static a(){
        console.log('a');
        return this.b();
    }
    static b(){
        console.log('b');
        return true;
    }

    // url 相关的
    /*获取当前页url*/
    static getCurrentPageUrl(){
        let pages = getCurrentPages();   //获取加载的页面
        let currentPage = pages[pages.length-1];    //获取当前页面的对象
        let url = currentPage.route;    //当前页面url
        return url
    }

    /*获取当前页带参数的url*/
    static getCurrentPageUrlWithArgs(){
        let pages = getCurrentPages() ;   //获取加载的页面
        let currentPage = pages[pages.length-1]  ;  //获取当前页面的对象
        let url = currentPage.route   ; //当前页面url
        let options = currentPage.options ;   //如果要获取url中所带的参数可以查看options

        //拼接url的参数
        let urlWithArgs = url + '?';
        for(let key in options){
            let value = options[key];
            urlWithArgs += key + '=' + value + '&';
        }
        urlWithArgs = urlWithArgs.substring(0, urlWithArgs.length-1);
        return urlWithArgs;
    }

    // 弹窗
    static showModal(error) {
        wx.showModal({
            content: error.msg,
            showCancel: false,
        })
    }
   // 确认，取消弹窗
    static setShowModel(params,confirm,cancel,fail,complete){
        wx.showModal({
            title: params.title || '提示',//提示的标题
            content:  params.content || '提示的内容',//提示的内容
            showCancel:	params.showCancel || true,//Boolean	否	是否显示取消按钮，默认为 true
            cancelText: params.cancelText || '取消',// String 否 取消按钮的文字，默认为"取消"，最多 4 个字符
            cancelColor: params.cancelColor || '#000000',// HexColor 否	取消按钮的文字颜色，默认为"#000000"
            confirmText: params.confirmText || '确定',// String 否 确定按钮的文字，默认为"确定"，最多 4 个字符
            confirmColor:params.confirmColor || '#3CC51F',// HexColor 否	确定按钮的文字颜色，默认为"#3CC51F"
            success: function(res) {
                if (res.confirm) {
                    console.log('用户点击确定');
                    if(typeof confirm == "function")
                        confirm();
                } else if (res.cancel) {
                    console.log('用户点击取消');
                    if(typeof cancel == "function")
                        cancel();
                }
            },
            fail:function(res) {
                console.log(res);
                if(typeof fail == "function")
                    fail();
            },
            complete:function(res) {
                console.log(res);
                if(typeof complete == "function")
                    complete();
            },
        })
    }
    //显示消息提示框
    // title 提示的内容
    // icon 图标，有效值 "success", "loading", "none"
    // duration 提示的延迟时间，单位毫秒，默认：1500
    // success,fail,complete 参数值 function(){} 或 null
    static showToast(title,icon,duration,success,fail,complete){
        wx.showToast({
            title: title,
            icon: icon,
            mask:true,
            duration: duration,
            success:function(res) {
                console.log(res);
                if(typeof success == "function")
                success();
            },
            fail:function(res) {
                console.log(res);
                if(typeof fail == "function")
                fail();
            },
            complete:function(res) {
                console.log(res);
                if(typeof complete == "function")
                complete();
            },
        });
    }
    // http请求loding
    // this
    static interceptors(obj) {
        obj
            .WxRequest
            .interceptors.use({
            request(request) {
                wx.showLoading({
                    mask:true,
                    title: '加载中...',
                });
                return request
            },
            requestError(requestError) {
                wx.hideLoading();
                return Promise.reject(requestError)
            },
            response(response) {
                wx.hideLoading();
                return response
            },
            responseError(responseError) {
                wx.hideLoading();
                return Promise.reject(responseError)
            },
        })
    }
    // api返回数据处理
    // 数据类型type 1:result对象 2 datalist对象
    // false失败
    static apiDataHandle(res,type){
        console.log(res);
        if(!res.data.apistatus) {//失败
            this.showModal({
                msg: res.data.errorMsg,
            });
            return false;
        }else{
            let resData = '';
            switch(type){
                case 1:// result对象
                    resData =  res.data.result;
                    break;
                case 2:// 2 datalist对象
                    resData =  res.data.result.data_list;
                    break;
                default://
                    break;
            }
            console.log(resData);
            return resData;
        }
    }

    // 缓存
    // 保存缓存
    static setSyncCache(key , val){
        try {
            wx.setStorageSync(key, val);
            return true;
        } catch (e) {

        }
        return false;
    }
    // 获得缓存
    static getSyncCache(key){
        try {
            let cacheData = '';
            cacheData = wx.getStorageSync(key);
            if (cacheData) {
                console.log(cacheData);
                // Do something with return value
            }
            return cacheData;
        } catch (e) {
            // Do something when catch error
            return false;
        }
    }

    // 清除缓存
    static clearSyncCache(key){
        try {
            wx.removeStorageSync(key);
            return true;
        } catch (e) {
            // Do something when catch error
            return false;
        }
    }
    // 判断是否登陆
    // key 缓存key
    // loginPath 没有登陆，跳转的url
    static judgeLogin(key,loginPath){
        // 获得数据
        let cacheData = this.getSyncCache(key);
        console.log(cacheData);
        if(!cacheData){
            wx.reLaunch({//关闭当前页面，跳转到应用内的某个页面
                url: loginPath,//url里面就写上你要跳到的地址
            })
        }
        return cacheData;
    }
    // 退出登陆
    static quitLogin(key,loginPath){
        this.clearSyncCache(key);
        wx.reLaunch({//关闭当前页面，跳转到应用内的某个页面
            url: loginPath,//url里面就写上你要跳到的地址
        });
        return true;
    }
}
export default common;