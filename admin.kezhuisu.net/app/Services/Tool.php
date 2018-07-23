<?php

namespace App\Services;
use Illuminate\Http\Request;

/**
 * 通用工具服务类
 */
class Tool
{

    /**
     * HTTP Protocol defined status codes
     * HTTP协议状态码,调用函数时候只需要将$num赋予一个下表中的已知值就直接会返回状态了。
     * @param int $num
     *
     */
    public static function https($num) {
        $http = array (
            100 => "HTTP/1.1 100 Continue",
            101 => "HTTP/1.1 101 Switching Protocols",
            200 => "HTTP/1.1 200 OK",
            201 => "HTTP/1.1 201 Created",
            202 => "HTTP/1.1 202 Accepted",
            203 => "HTTP/1.1 203 Non-Authoritative Information",
            204 => "HTTP/1.1 204 No Content",
            205 => "HTTP/1.1 205 Reset Content",
            206 => "HTTP/1.1 206 Partial Content",
            300 => "HTTP/1.1 300 Multiple Choices",
            301 => "HTTP/1.1 301 Moved Permanently",
            302 => "HTTP/1.1 302 Found",
            303 => "HTTP/1.1 303 See Other",
            304 => "HTTP/1.1 304 Not Modified",
            305 => "HTTP/1.1 305 Use Proxy",
            307 => "HTTP/1.1 307 Temporary Redirect",
            400 => "HTTP/1.1 400 Bad Request",
            401 => "HTTP/1.1 401 Unauthorized",
            402 => "HTTP/1.1 402 Payment Required",
            403 => "HTTP/1.1 403 Forbidden",
            404 => "HTTP/1.1 404 Not Found",
            405 => "HTTP/1.1 405 Method Not Allowed",
            406 => "HTTP/1.1 406 Not Acceptable",
            407 => "HTTP/1.1 407 Proxy Authentication Required",
            408 => "HTTP/1.1 408 Request Time-out",
            409 => "HTTP/1.1 409 Conflict",
            410 => "HTTP/1.1 410 Gone",
            411 => "HTTP/1.1 411 Length Required",
            412 => "HTTP/1.1 412 Precondition Failed",
            413 => "HTTP/1.1 413 Request Entity Too Large",
            414 => "HTTP/1.1 414 Request-URI Too Large",
            415 => "HTTP/1.1 415 Unsupported Media Type",
            416 => "HTTP/1.1 416 Requested range not satisfiable",
            417 => "HTTP/1.1 417 Expectation Failed",
            500 => "HTTP/1.1 500 Internal Server Error",
            501 => "HTTP/1.1 501 Not Implemented",
            502 => "HTTP/1.1 502 Bad Gateway",
            503 => "HTTP/1.1 503 Service Unavailable",
            504 => "HTTP/1.1 504 Gateway Time-out"
        );
        header($http[$num]);
    }

    /**
     * 取得IP
     *
     *
     * @return string 字符串类型的返回结果
     */
    public static function getIp(){
        if (@$_SERVER['HTTP_CLIENT_IP'] && $_SERVER['HTTP_CLIENT_IP']!='unknown') {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (@$_SERVER['HTTP_X_FORWARDED_FOR'] && $_SERVER['HTTP_X_FORWARDED_FOR']!='unknown') {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return preg_match('/^\d[\d.]+\d$/', $ip) ? $ip : '';
    }


    /**
     * 获取文件列表(所有子目录文件)
     *
     * @param string $path 目录
     * @param array $file_list 存放所有子文件的数组
     * @param array $ignore_dir 需要忽略的目录或文件
     * @return array 数据格式的返回结果
     */
    public static function readFileList($path,&$file_list,$ignore_dir=array()){
        $path = rtrim($path,'/');
        if (is_dir($path)) {
            $handle = @opendir($path);
            if ($handle){
                while (false !== ($dir = readdir($handle))){
                    if ($dir != '.' && $dir != '..'){
                        if (!in_array($dir,$ignore_dir)){
                            if (is_file($path.DS.$dir)){
                                $file_list[] = $path.DS.$dir;
                            }elseif(is_dir($path.DS.$dir)){
                                self::readFileList($path.DS.$dir,$file_list,$ignore_dir);
                            }
                        }
                    }
                }
                @closedir($handle);
                //return $file_list;
            }else {
                return false;
            }
        }else {
            return false;
        }
    }

    /**
     * 生成订单流水号（18位数字）
     * 最大可以支持1分钟1亿订单号不重复
     *
     * @return string $orderSn
     */
    public static function createSn($namespace = 'default', $prefix = '', $length = 8)
    {
        $insertId = Yii::$app->redis->incr('FlowSn:' . ucfirst($namespace));
        $suffix   = self::getSnSuffix();

        return $prefix . date('ymdHi') . str_pad(substr($insertId, -$length), $length, 0, STR_PAD_LEFT) . $suffix;
    }

    /**
     * 产生随机字符串
     *
     * @param int $length
     *
     * @return string
     */
    public static function createRandomStr($length = 32)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';

        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        return $str;
    }

    /**
     * 生成随机令牌凭证
     *
     * @return string
     */
    public static function buildToken($uniqueId = null)
    {
        return sha1(uniqid($uniqueId) . mt_rand(1, 10000));
    }

    /**
     * 订单号生成器
     * @param int $uid 用户id
     * @return int
     */
    function order_sn($uid)
    {
        return '619' . date('Ymd') . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT) . $uid;
    }

    /**
     * 获取唯一标识长度,最长37位,默认10位
     *
     * @param int $length 字符串长度
     *
     * @return string
     */
    public static function createUniqueNumber($length = 10)
    {
        return substr(date('Ymd') . md5(uniqid()), 0, $length);
    }

    /**
     * 根据字符集生成随机字符串
     *
     * @param int $length 字符串长度
     * @param int $type 0:纯数字, 1:数字与字母
     *
     * @return string
     */
    public static function generatePassword($length = 6, $type = 0)
    {
        if ($type == 1) {
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        }
        else {
            $chars = '0123456789';
        }
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        return $password;
    }

    /**
     * Xml To array
     *
     * @param $data
     *
     * @return array
     */
    public static function xmlToArray($data)
    {
        // 禁止引用外部xml实体
        libxml_disable_entity_loader(true);

        $data = str_ireplace(['encoding="GB2312"', 'encoding="GBK"'], 'encoding="GB18030"', $data);

        // 先把xml转换为simplexml对象，再把simplexml对象转换成 json，再将 json 转换成数组
        try {
            $result = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);

            return $result ? json_decode(json_encode($result), true) : [];
        } catch (\Throwable $e) {
            throws('xml格式不正确：' . $data);
        }
    }

    /**
     * 数组转换成xml
     *
     * @param $arr
     * @param string $root
     * @param string $endroot
     *
     * @return string
     */
    public static function arrayToXml($arr, $root = '<msgdata>', $endroot = '</msgdata>')
    {
        $xml = $root;

        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                if (is_numeric($key)) {
                    $xml .= self::arrayToXml($val, '', '');
                } else {
                    $xml .= '<' . $key . '>' . self::arrayToXml($val, '', '') . '</' . $key . '>';
                }
            }
            else {
                if (is_numeric($val) || $val === '') {
                    $xml .= '<' . $key . '>' . $val . '</' . $key . '>';
                }
                else {
                    $xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
                }
            }
        }

        $xml .= $endroot;

        return $xml;
    }

    /**
     * 获取xml post请求数据
     *
     * @return bool|mixed
     */
    public static function getXmlPost()
    {
        if (version_compare(PHP_VERSION, '5.6.0', '<')) {
            if (! empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
                $xmlInput = $GLOBALS['HTTP_RAW_POST_DATA'];
            }
            else {
                $xmlInput = file_get_contents('php://input');
            }
        }
        else {
            $xmlInput = file_get_contents('php://input');
        }

        if (empty($xmlInput)) {
            return [];
        }

        // 禁止引用外部xml实体
        libxml_disable_entity_loader(true);

        // 先把xml转换为simplexml对象，再把simplexml对象转换成 json，再将 json 转换成数组
        return json_decode(json_encode(simplexml_load_string($xmlInput, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

}
