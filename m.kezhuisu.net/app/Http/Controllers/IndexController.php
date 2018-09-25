<?php

namespace App\Http\Controllers;

use App\Services\HttpRequest;
use Illuminate\Http\Request;

class IndexController extends BasePublicController
{

    /**
     * 首页
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request, $pro_unit_id)
    {
        if (empty($pro_unit_id) || (! is_numeric($pro_unit_id))){
            return '参数[pro_unit_id]有误!!';
        }
        $url = config('public.apiUrl') . config('public.apiPath.indexPage');
        $requestData = [
            'pro_unit_id' => $pro_unit_id,
        ];
        // echo $requestTesUrl = splicQuestAPI($url , $requestData); die;
        $data = HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
        if (is_string($data)) {
            return $data;
        }
        $data['pro_unit_id'] = $pro_unit_id;
        return view('index', $data);
    }

    /**
     * 防伪标签查询
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function security_label(Request $request, $pro_unit_id, $label_num)
    {
        if (empty($pro_unit_id) || (! is_numeric($pro_unit_id))){
            return '参数[pro_unit_id]有误!!';
        }
        if (empty($label_num) ){
            return '参数[label_num]有误!!';
        }

        // 查询标签
        $url = config('public.apiUrl') . config('public.apiPath.searchLabelPage');
        $requestData = [
            'pro_unit_id' => $pro_unit_id,
            'label_num' => $label_num,
        ];
        // echo $requestTesUrl = splicQuestAPI($url , $requestData); die;
        $data = HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
        if (is_string($data)) {
            return $data;
        }
        $data['pro_unit_id'] = $pro_unit_id;
        $data['label_num'] = $label_num;
        return view('antifake.intro', $data);
    }

    /**
     * ajax保存点赞数据
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_red_heart(Request $request, $pro_unit_id)
    {
        // 点赞自增
        $url = config('public.apiUrl') . config('public.apiPath.incRedHeart');
        $requestData = [
            'pro_unit_id' => $pro_unit_id,
        ];
        // echo $requestTesUrl = splicQuestAPI($url , $requestData); die;
        $data = HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
        return ajaxDataArr(1, $pro_unit_id, '');
    }
}
