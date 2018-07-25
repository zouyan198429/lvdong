class dateTime {

    //获得当前的时间戳[无毫秒]
    static get_now_timestamp(){
        return this.get_unix_time('',false);
    }
    //获得当前的时间
    //format 'Y-m-d H:i:s'
    static get_now_format(format){
        var tem_format = format || 'Y-m-d H:i:s';
        return this.format_date(tem_format,this.get_now_timestamp());
    }

    //获得当前/指定的时间戳
    //dateTime为空，则获得当前的 日期格式 2012-02-16或2012-02-16 23:59:59 2012-2-8或2012-02-16 23:59:59
    //need_msec 是否保留毫秒 true 保留 false不保留

    //new date("month dd,yyyy hh:mm:ss");
    //new date("month dd,yyyy");
    //new date(yyyy,mth,dd,hh,mm,ss);
    //new date(yyyy,mth,dd);
    //new date(ms);
    //javascript中日期的构造还可以支持 new date("yyyy/mm/dd"); 其中：mm是整数表示月份从0（1月）到11（12月），这样再利用正则表达式就很方便地能够转换字符串日期了。
    static get_unix_time(dateTime,need_msec){
        var timestamp = 0;
        if(this.judge_date(dateTime)){
            timestamp=new Date(dateTime.replace(/-/g,"/")).getTime();
        }else{
            timestamp=new Date().getTime();
        }
        if(need_msec!=true){
            timestamp=Math.floor(timestamp/1000);
        }
        return timestamp;
    }

    //date 判断日期格式是否正确 true正确 false 有误
    //$dateTime 日期格式 2012-02-16或2012-02-16 23:59:59 2012-2-8或2012-02-16 23:59:59
    static judge_date(dateTime){
        var reg2 = /^\d{4}[-](0?[1-9]|1[012])[-](0?[1-9]|[12][0-9]|3[01])(\s+(0?[0-9]|1[0-9]|2[0-3]):(0?[0-9]|[1-5][0-9]):(0?[0-9]|[1-5][0-9]))?$/;
        if(reg2.test(dateTime)){
            return true;
        }else{
            return false;
        }
    }
    //格式化时间戳为时间格式
    //unix_time 日期时间戳
    //format 'Y-m-d H:i:s'
    static format_timestamp(unix_time,format){
        var format_data = this.format_date ( unix_time, format );
        return format_data;
    }
    static format_date ( format, timestamp ) {
        var a, jsdate=((timestamp) ? new Date(timestamp*1000) : new Date());
        var pad = function(n, c){
            if( (n = n + "").length < c ) {
                return new Array(++c - n.length).join("0") + n;
            } else {
                return n;
            }
        };
        var txt_weekdays = ["Sunday","Monday","Tuesday","Wednesday",
            "Thursday","Friday","Saturday"];
        var txt_ordin = {1:"st",2:"nd",3:"rd",21:"st",22:"nd",23:"rd",31:"st"};
        var txt_months = ["", "January", "February", "March", "April",
            "May", "June", "July", "August", "September", "October", "November",
            "December"];
        var f = {
            // Day
            d: function(){
                return pad(f.j(), 2);
            },
            D: function(){
                t = f.l(); return t.substr(0,3);
            },
            j: function(){
                return jsdate.getDate();
            },
            l: function(){
                return txt_weekdays[f.w()];
            },
            N: function(){
                return f.w() + 1;
            },
            S: function(){
                return txt_ordin[f.j()] ? txt_ordin[f.j()] : 'th';
            },
            w: function(){
                return jsdate.getDay();
            },
            z: function(){
                return (jsdate - new Date(jsdate.getFullYear() + "/1/1")) / 864e5 >> 0;
            },


            // Week
            W: function(){
                var a = f.z(), b = 364 + f.L() - a;
                var nd2, nd = (new Date(jsdate.getFullYear() + "/1/1").getDay() || 7) - 1;


                if(b <= 2 && ((jsdate.getDay() || 7) - 1) <= 2 - b){
                    return 1;
                } else{


                    if(a <= 2 && nd >= 4 && a >= (6 - nd)){
                        nd2 = new Date(jsdate.getFullYear() - 1 + "/12/31");
                        return date("W", Math.round(nd2.getTime()/1000));
                    } else{
                        return (1 + (nd <= 3 ? ((a + nd) / 7) : (a - (7 - nd)) / 7) >> 0);
                    }
                }
            },


            // Month
            F: function(){
                return txt_months[f.n()];
            },
            m: function(){
                return pad(f.n(), 2);
            },
            M: function(){
                t = f.F(); return t.substr(0,3);
            },
            n: function(){
                return jsdate.getMonth() + 1;
            },
            t: function(){
                var n;
                if( (n = jsdate.getMonth() + 1) == 2 ){
                    return 28 + f.L();
                } else{
                    if( n & 1 && n < 8 || !(n & 1) && n > 7 ){
                        return 31;
                    } else{
                        return 30;
                    }
                }
            },


            // Year
            L: function(){
                var y = f.Y();
                return (!(y & 3) && (y % 1e2 || !(y % 4e2))) ? 1 : 0;
            },
            //o not supported yet
            Y: function(){
                return jsdate.getFullYear();
            },
            y: function(){
                return (jsdate.getFullYear() + "").slice(2);
            },


            // Time
            a: function(){
                return jsdate.getHours() > 11 ? "pm" : "am";
            },
            A: function(){
                return f.a().toUpperCase();
            },
            B: function(){
                // peter paul koch:
                var off = (jsdate.getTimezoneOffset() + 60)*60;
                var theSeconds = (jsdate.getHours() * 3600) +
                    (jsdate.getMinutes() * 60) +
                    jsdate.getSeconds() + off;
                var beat = Math.floor(theSeconds/86.4);
                if (beat > 1000) beat -= 1000;
                if (beat < 0) beat += 1000;
                if ((String(beat)).length == 1) beat = "00"+beat;
                if ((String(beat)).length == 2) beat = "0"+beat;
                return beat;
            },
            g: function(){
                return jsdate.getHours() % 12 || 12;
            },
            G: function(){
                return jsdate.getHours();
            },
            h: function(){
                return pad(f.g(), 2);
            },
            H: function(){
                return pad(jsdate.getHours(), 2);
            },
            i: function(){
                return pad(jsdate.getMinutes(), 2);
            },
            s: function(){
                return pad(jsdate.getSeconds(), 2);
            },
            //u not supported yet


            // Timezone
            //e not supported yet
            //I not supported yet
            O: function(){
                var t = pad(Math.abs(jsdate.getTimezoneOffset()/60*100), 4);
                if (jsdate.getTimezoneOffset() > 0) t = "-" + t; else t = "+" + t;
                return t;
            },
            P: function(){
                var O = f.O();
                return (O.substr(0, 3) + ":" + O.substr(3, 2));
            },
            //T not supported yet
            //Z not supported yet


            // Full Date/Time
            c: function(){
                return f.Y() + "-" + f.m() + "-" + f.d() + "T" + f.h() + ":" + f.i() + ":" + f.s() + f.P();
            },
            //r not supported yet
            U: function(){
                return Math.round(jsdate.getTime()/1000);
            }
        };


        return format.replace(/[\\]?([a-zA-Z])/g, function(t, s){
            if( t!=s ){
                // escaped
             var   ret = s;
            } else if( f[s] ){
                // a date function exists
             var   ret = f[s]();
            } else{
                // nothing special
              var  ret = s;
            }


            return ret;
        });
    }
}
export default dateTime;