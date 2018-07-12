<?php

namespace App\Http\Controllers;

use App\Services\HttpRequest;
use Illuminate\Http\Request;

class InputsController extends BasePublicController
{
    /**
     * 投入品
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
        $url = config('public.apiUrl') . config('public.apiPath.inputsPage');
        $requestData = [
            'pro_unit_id' => $pro_unit_id,
        ];
        $data = HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
        if (is_string($data)) {
            return $data;
        }
        $data['pro_unit_id'] = $pro_unit_id;
        return view('inputs.index', $data);
    }


    /**
     * 投入品-详情
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function info(Request $request, $pro_unit_id, $id)
    {
        if (empty($pro_unit_id) || (! is_numeric($pro_unit_id))){
            return '参数[pro_unit_id]有误!!';
        }

        if (empty($id) || (! is_numeric($id))){
            return '参数[id]有误!!';
        }
        $url = config('public.apiUrl') . config('public.apiPath.inputInfoPage');
        $requestData = [
            'pro_unit_id' => $pro_unit_id,
            'id' => $id,
        ];
        $data = HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
        if (is_string($data)) {
            return $data;
        }
        $data['pro_unit_id'] = $pro_unit_id;
        return view('inputs.info', $data);
    }

}
