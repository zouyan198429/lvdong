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

}
