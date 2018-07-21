class validate{

//error错误弹窗 -倒记时
//参数 err_msg 错误信息
    static err_alert(err_msg){
        // layer_alert(err_msg,5,0);
    }
    static trim(str) {
        return (str + '').replace(/(\s+)$/g, '').replace(/^\s+/g, '');
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
        let timestamp = 0;
        if(this.judge_date(dateTime)){
            timestamp=new Date(dateTime.replace(/-/g,"/")).getTime();
        }else{
            timestamp=new Date().getTime();
        }
        if(!need_msec){
            timestamp=Math.floor(timestamp/1000);
        }
        return timestamp;
    }
//综合判断
//err_type 错误误返回类型
//  1返回错误字符串,空:没有错误;
//  2返回值 true：正确-通过;false:失败-有误;
//  4返回2的同时，弹出错误提示窗
//tishi_name 提示名称[关键字名]
//value 需要判断的字符串
//is_must 是否必填 true:必填;false:非必填
//reg_msg [多个用,号分隔-后面的单参数的可以无限个,但多参数的只能有一个;前面的优先判断]正则或指定判断关键字[不在下面的，请直接写正则表达式来判断,空：则不进行判断]

    //custom 正则验证 min_length 为正则表达式[regexp]
    //length 判断字符长度 min_length 最小长度[为空:不参与判断];max_length 最大长度[为空:不参与判断]
    //range 判断数字范围 min_length 最小值>=[为空:不参与判断];max_length 最大值<=[为空:不参与判断]
    //compare 比较 min_length 比较符[必填];max_length 被比较值[必填]
    //data_size 判断日期大小 value>max_length  min_length 日期2[必填];max_length 日期操作类型[位操作] 1 > ;2< ; 4 =[必填]
    //     日期格式 2012-02-16或2012-02-16 23:59:59 2012-2-8或2012-02-16 23:59:59
    //email: 邮箱 judge_email(value)
    //phone: 电话号码 judge_phone(value)
    //mobile: 手机 judge_mobile(value)
    //url:url judge_url(value)
    //currency: 货币 judge_currency(value)
    //number: 任何数字[纯数字]验证 judge_number(value)
    //zip:邮编 judge_zip(value)
    //qq:qq号码 judge_qq(value)
    //integer: [-+]正负整数 judge_integer(value)
    //integerpositive: [+]正整 judge_integerpositive(value)
    //double: [-+] 数字.数字 正负双精度数 judge_double(value)
    //doublepositive [+]数字.数字 正双精度数 judge_doublepositive(value)
    //english 大小写字母 judge_english(value)
    //englishsentence 大小写字母空格 judge_englishsentence(value)
    //englishnumber 大小写字母数字 judge_englishnumber(value)
    //chinese 中文 judge_chinese(value)
    //username 至少3位 用户名 judge_username(value)
    //nochinese 非中文 judge_nochinese(value)
    //datatime 日期时间 judge_datatime(value)
    //int [\-]负整数或正整数,正的没有+号 judge_int(value)
    //positive_int >0正整数[全是数字且>0] judge_positive_int(value)
    //digit:0+正整数 judge_judge_digit(value)
    //date [见意用这个]判断日期格式是否正确 judge_date(dateTime) 日期格式 2012-02-16或2012-02-16 23:59:59 2012-2-8或2012-02-16 23:59:59
//min_length 最小长度;为空则不判断
//max_length 最大长度;为空则不判断
//返回值 true：正确-通过;false:失败-有误
    static judge_validate(err_type,tishi_name,value,is_must,reg_msg,min_length,max_length){
        let tem_value = this.trim(value);
        let err_str = "";
        if(is_must){
            if(this.judge_empty(tem_value)){
                err_str = tishi_name + '不能为空!';
                if(err_type === 4){this.err_alert(err_str);}
                if(err_type === 1){return err_str;}
                return false;
            }
        }
        //为空，则判断是否是空格
        if(this.judge_empty(tem_value)){
            if(value.length>0){//判断是否全是空格
                err_str = tishi_name + '不能全为空格!';
                if(err_type === 4){this.err_alert(err_str);}
                if(err_type === 1){return err_str;}
                return false;
            }else{
                if(err_type === 1){return err_str;}
                return true;
            }
        }
        //空,则不进行后面的正则判断
        if(this.judge_empty(reg_msg)){
            if(err_type === 1){return err_str;}
            return true;
        }
        let back_err = "";
        let tem_lower_msg = reg_msg.toLowerCase();
        // let msg_arr= new Array();; //定义一数组
        let msg_arr = tem_lower_msg.split(","); //字符分割
        for (let i=0;i<msg_arr.length ;i++ )
        {
            back_err = "";
            let tem_reg = msg_arr[i];
            if(this.judge_empty(tem_reg)){
                continue;
            }
            switch(tem_reg){
                case "custom":// 正则验证 min_length 为正则表达式[regexp]
                    if(!this.judge_reg(tem_value,min_length)){
                        back_err = "格式有误!";
                    }
                    break;
                case "length":// 判断字符长度 min_length 最小长度[为空:不参与判断];max_length 最大长度[为空:不参与判断]
                    if(!this.judge_length(tem_value,min_length,max_length)){
                        back_err = '长度为'+min_length+'~'+max_length+'个字符!';
                    }
                    break;
                case "range":// 判断数字范围 min_length 最小值[为空:不参与判断];max_length 最大值[为空:不参与判断]
                    if(!this.judge_range(tem_value,min_length,max_length)){
                        back_err = '范围为'+min_length+'~'+max_length+'!';
                    }
                    break;
                case "compare":// 比较 min_length 比较符[必填];max_length 被比较值[必填]
                    if(!this.judge_compare(tem_value,min_length,max_length)){
                        back_err = '必须为[' + ' ' + min_length+']!';
                    }
                    break;
                case "data_size":// data_size 判断日期大小 min_length>max_length  min_length 日期2[必填];max_length 日期操作类型[位操作] 1 > ;2< ; 4 =[必填]
                    if(!this.judge_data_size(tem_value,min_length,max_length)){
                        let operate_str = "";
                        if( (max_length & 1) === 1 ){//>
                            operate_str +=">";
                        }
                        if( (max_length & 2) === 2 ){//<
                            operate_str +="<";
                        }
                        if( (max_length & 4) === 4 ){//=
                            operate_str +="=";
                        }
                        back_err = '必须[' + operate_str + ' ' + min_length+']!';
                    }
                    break;
                case "email"://邮箱
                    if(!this.judge_email(tem_value)){
                        back_err = "格式不是有效的邮箱格式!";
                    }
                    break;
                case "phone":// 电话号码 judge_phone(value)
                    if(!this.judge_phone(tem_value)){
                        back_err = "格式不是有效的电话号码格式!";
                    }
                    break;
                case "mobile":// 手机 judge_mobile(value)
                    if(!this.judge_mobile(tem_value)){
                        back_err = "格式不是有效的手机格式!";
                    }
                    break;
                case "url"://url judge_url(value)
                    if(!this.judge_url(tem_value)){
                        back_err = "格式不是有效的网址格式!";
                    }
                    break;
                case "currency":// 货币 judge_currency(value)
                    if(!this.judge_currency(tem_value)){
                        back_err = "格式不是有效的货币格式!";
                    }
                    break;
                case "number":// 任何数字验证 judge_number(value)
                    if(!this.judge_number(tem_value)){
                        back_err = "只能是数字!";
                    }
                    break;
                case "zip"://邮编 judge_zip(value)
                    if(!this.judge_zip(tem_value)){
                        back_err = "格式不是有效的邮编格式!";
                    }
                    break;
                case "qq"://qq号码 judge_qq(value)
                    if(!this.judge_qq(tem_value)){
                        back_err = "不是有效的qq号码!";
                    }
                    break;
                case "integer":// [-+]正负整数 judge_integer(value)
                    if(!this.judge_integer(tem_value)){
                        back_err = "不是[-+]正负整数!";
                    }
                    break;
                case "integerpositive":// [+]正整 judge_integerpositive(value)
                    if(!this.judge_integerpositive(tem_value)){
                        back_err = "不是[+]正整数!";
                    }
                    break;
                case "double":// [-+] 数字.数字 正负双精度数 judge_double(value)
                    if(!this.judge_double(tem_value)){
                        back_err = "不是[-+]正负双精度数!";
                    }
                    break;
                case "doublepositive":// [+]数字.数字 正双精度数 judge_doublepositive(value)
                    if(!this.judge_doublepositive(tem_value)){
                        back_err = "不是[+]数字.数字 正双精度数!";
                    }
                    break;
                case "english":// 大小写字母 judge_english(value)
                    if(!this.judge_english(tem_value)){
                        back_err = "只能是大小写字母!";
                    }
                    break;
                case "englishsentence":// 大小写字母空格 judge_englishsentence(value)
                    if(!this.judge_englishsentence(tem_value)){
                        back_err = "只能是大小写字母空格!";
                    }
                    break;
                case "englishnumber":// 大小写字母数字 judge_englishnumber(value)
                    if(!this.judge_englishnumber(tem_value)){
                        back_err = "只能是大小写字母数字!";
                    }
                    break;
                case "chinese"://  judge_chinese(value)
                    if(!this.judge_chinese(tem_value)){
                        back_err = "不是中文!";
                    }
                    break;
                case "username":// 至少3位 用户名 judge_username(value)
                    if(!this.judge_username(tem_value)){
                        back_err = "至少3位!";
                    }
                    break;
                case "nochinese":// 非中文 judge_nochinese(value)
                    if(!this.judge_nochinese(tem_value)){
                        back_err = "不是非中文!";
                    }
                    break;
                case "datatime":// 日期时间 judge_datatime(value)
                    if(!this.judge_datatime(tem_value)){
                        back_err = "格式不是有效的日期时间格式!";
                    }
                    break;
                case "int"://int [\-]负整数或正整数,正的没有+号 judge_int(value)
                    if(!this.judge_int(tem_value)){
                        back_err = "格式不是有效的[\-]负整数或正整数,正的没有+号格式!";
                    }
                    break;
                case "positive_int":// >0正整数[全是数字且>0] judge_positive_int(value)
                    if(!this.judge_positive_int(tem_value)){
                        back_err = "格式不是有效的>0正整数[全是数字且>0]格式!";
                    }
                    break;
                case "digit"://:0+正整数 judge_judge_digit(value)
                    if(!this.judge_judge_digit(tem_value)){
                        back_err = "不是0或正整数!";
                    }
                    break;
                case "date"://date 判断日期格式是否正确 judge_date(dateTime) 日期格式 2012-02-16或2012-02-16 23:59:59 2012-2-8或2012-02-16 23:59:59
                    if(!this.judge_date(tem_value)){
                        back_err = "格式不是有效的日期格式!";
                    }
                    break;
                default://其它正则表达式
                    if(!this.judge_reg(tem_value,reg_msg)){
                        back_err = "格式有误!";
                    }
                    break;
            }
            if(back_err !== ''){
                err_str = tishi_name + back_err;
                if(err_type === 4){
                    this.err_alert(err_str);
                }
                if(err_type === 1){return err_str;}
                return false;
            }
        }
        if(err_type === 1){return err_str;}
        return true;
    }
//判断是否为空 true:空;false:非空
    static judge_empty(value){
        let tem_value = this.trim(value);
        return this.judge_length(tem_value,0,0);
    }
//判断正则表达式
//value需要判断的值
//reg正则表达式
    static judge_reg(value,reg2){
        return reg2.test(value);
    }
//判断email
    static judge_email(value){
        let reg2 = /^([.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)$/;
        return this.judge_reg(value,reg2);
    }
//判断phone 电话号码
    static judge_phone(value){
        let reg2 = /^(([0-9]{2,3})|([0-9]{3}-))?((0[0-9]{2,3})|0[0-9]{2,3}-)?[1-9][0-9]{6,7}(-[0-9]{1,4})?$/;
        return this.judge_reg(value,reg2);
    }
//判断mobile 手机
    static judge_mobile(value){
        let reg2 = /^1[0-9]{10}$/;
        return this.judge_reg(value,reg2);
    }
//判断url
    static judge_url(value){
        let reg2 = /^http:(\/){2}[A-Za-z0-9]+.[A-Za-z0-9]+[\/=?%-&_~`@\[\]':+!]*([^<>"])*$/;
        return this.judge_reg(value,reg2);
    }
//判断currency 货币
    static judge_currency(value){
        let reg2 = /^[0-9]+(\.[0-9]+)?$/;
        return this.judge_reg(value,reg2);
    }
//判断number 数字验证
    static judge_number(value){
        let reg2 = /^[0-9]+$/;
        return this.judge_reg(value,reg2);
    }
//判断zip 邮编
    static judge_zip(value){
        let reg2 = /^[0-9][0-9]{5}$/;
        return this.judge_reg(value,reg2);
    }
//判断qq
    static judge_qq(value){
        let reg2 = /^[1-9][0-9]{4,8}$/;
        return this.judge_reg(value,reg2);
    }
//判断integer [-+]正负整数
    static judge_integer(value){
        let reg2 = /^[-+]?[0-9]+$/;
        return this.judge_reg(value,reg2);
    }
//判断integerpositive [+]正整
    static judge_integerpositive(value){
        let reg2 = /^[+]?[0-9]+$/;
        return this.judge_reg(value,reg2);
    }
//判断double [-+] 数字.数字 正负双精度数
    static judge_double(value){
        let reg2 = /^[-+]?[0-9]+(\.[0-9]+)?$/;
        return this.judge_reg(value,reg2);
    }
//判断doublepositive [+]数字.数字 正双精度数
    static judge_doublepositive(value){
        let reg2 = /^[+]?[0-9]+(\.[0-9]+)?$/;
        return this.judge_reg(value,reg2);
    }
//判断english 大小写字母
    static judge_english(value){
        let reg2 = /^[A-Za-z]+$/;
        return this.judge_reg(value,reg2);
    }
//判断englishsentence 大小写字母空格
    static judge_englishsentence(value){
        let reg2 = /^[A-Za-z ]+$/;
        return this.judge_reg(value,reg2);
    }
//判断englishnumber 大小写字母数字
    static judge_englishnumber(value){
        let reg2 = /^[A-Za-z0-9]+$/;
        return this.judge_reg(value,reg2);
    }
//判断chinese 中文
    static judge_chinese(value){
        let reg2 = /^[\x80-\xff]+$/;
        return this.judge_reg(value,reg2);
    }
//判断username 至少3位 用户名
    static judge_username(value){
        let reg2 = /^[\w]{3,}$/;
        return this.judge_reg(value,reg2);
    }
//判断nochinese 非中文
    static judge_nochinese(value){
        let reg2 = /^[A-Za-z0-9_-]+$/;
        return this.judge_reg(value,reg2);
    }
//判断datatime 日期时间
    static judge_datatime(value){
        let reg2 = /^\d{4}[-](0?[1-9]|1[012])[-](0?[1-9]|[12][0-9]|3[01])(\s+(0?[0-9]|1[0-9]|2[0-3]):(0?[0-9]|[1-5][0-9]):(0?[0-9]|[1-5][0-9]))?$/;//匹配时间格式为2012-02-16或2012-02-16 23:59:59前面为0的时候可以不写
        return this.judge_reg(value,reg2);
    }
//整数int [\-]负整数或正整数,正的没有+号
    static judge_int(value){
        let reg2 = /^[\-]?$/;// /^\d+(\.\d{0,})?$/
        return reg2.test(value);
    }
//正整数 positive_int >0正整数[全是数字且>0]
    static judge_positive_int(value){
        let reg2 = /^\d+$/;// /^\d+(\.\d{0,})?$/
        if(reg2.test(value)){
            if(value>0){
                return true;
            }
        }
        return false;
    }
//digit:0+正整数
    static judge_judge_digit(value){
        let reg2 = /^\d+$/;// /^\d+(\.\d{0,})?$/
        return reg2.test(value);
    }
//date 判断日期格式是否正确 true正确 false 有误
//$dateTime 日期格式 2012-02-16或2012-02-16 23:59:59 2012-2-8或2012-02-16 23:59:59
    static judge_date(dateTime){
        let reg2 = /^\d{4}[-](0?[1-9]|1[012])[-](0?[1-9]|[12][0-9]|3[01])(\s+(0?[0-9]|1[0-9]|2[0-3]):(0?[0-9]|[1-5][0-9]):(0?[0-9]|[1-5][0-9]))?$/;
        return reg2.test(dateTime);
    }
//判断字符长度
//str 需要验证的字符串
//min_length 最小长度;为空则不判断
//max_length 最大长度;为空则不判断
//返回值 true：正确;false:失败
    static judge_length(str,min_length,max_length){
        let re_boolean = true;
        let tem_str = this.trim(str);
        let str_len = tem_str.length;
        if(this.judge_judge_digit(min_length) && str_len < min_length){
            re_boolean = false;
        }
        if(this.judge_judge_digit(max_length) && str_len > max_length){
            re_boolean = false;
        }
        return re_boolean;
    }

//判断数字范围
//judge_num 需要验证的数字
//min_num 最小;为空则不判断
//max_num 最大;为空则不判断
//返回值 true：正确;false:失败
    static judge_range(judge_num,min_num,max_num){
        if(!this.judge_double(judge_num)){
            return false;
        }
        let re_boolean = true;
        if(this.judge_double(min_num) && judge_num < min_num){
            re_boolean = false;
        }
        if(this.judge_double(max_num) && judge_num > max_num){
            re_boolean = false;
        }
        return re_boolean;
    }

//比较
//compare_val 需要比较的值[必填]
//operate 操作符[必填]
//operate_val 被比较的值[必填]
//返回值 true：正确;false:失败
    static judge_compare(judge_num,operate,operate_val){
        //都为空，则返回false
        if(this.judge_empty(judge_num) && this.judge_empty(operate) && this.judge_empty(operate_val) ){
            return false;
        }
        let operate_str = judge_num + ' ' + operate + ' ' + operate_val;
        return eval(operate_str);
    }

//判断日期大小
//日期格式 2012-02-16或2012-02-16 23:59:59 2012-2-8或2012-02-16 23:59:59
//data1 需要比较的值[必填]
//data2 操作符[必填]
//operate 判断类型 1 > ;2< ; 4 =
//返回值 true：正确;false:失败
    static judge_data_size(data1,data2,operate){
        //只要一个参数不是有效日期，则返回false
        if( (!this.judge_date(data1)) || (!this.judge_date(data2)) || (!this.judge_number(operate)) ){
            return false;
        }
        //var has_operate = false;//是否有成功判断的操作 false:没有;true:有-目的:防止没有任何判断,返回成功
        //var need_wait_eq = false;//在判断>或<时已经有错的情况下;是否可能需要判断等于 true:需要；false:不需要
        //转换为时间戳
        let data1_unix = this.get_unix_time(data1,true);
        let data2_unix = this.get_unix_time(data2,true);
        //判断大于
        if( (operate & 1) === 1  ){//>
            if( data1_unix > data2_unix){
                //has_operate = true;
                return true;
            }else{//可能还需要判断==
                //need_wait_eq = true;
            }
        }
        //判断小于
        if( (operate & 2) === 2  ){//<
            if( data1_unix < data2_unix){
                //has_operate = true;
                return true;
            }else{//可能还需要判断==
                //need_wait_eq = true;
            }
        }

        //判断等于
        if(   (operate & 4) === 4  ){//=
            if( data1_unix === data2_unix){
                //has_operate = true;
                return true;
            }//else{

            //return false;
            //}
        }//else{
        //if(need_wait_eq){
        //return false;
        //}
        //}
        return false;
        //return has_operate;
    }
}
export default  validate;
