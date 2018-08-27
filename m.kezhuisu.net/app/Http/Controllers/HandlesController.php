<?php

namespace App\Http\Controllers;

use App\Services\HttpRequest;
use Illuminate\Http\Request;

class HandlesController extends BasePublicController
{
    /**
     * 生产记录
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
        $url = config('public.apiUrl') . config('public.apiPath.handlesPage');
        $requestData = [
            'pro_unit_id' => $pro_unit_id,
        ];
        $data = HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
        if (is_string($data)) {
            return $data;
        }
        $data['pro_unit_id'] = $pro_unit_id;
        foreach($data['pro_records'] as $k => $v ){
            $createdAt = judgeDate($v['created_at'],"Y-m-d");
            $weather_data = $v['weather_data'] ?? [];
            if (!isNotJson($weather_data)) {
                $weather_data = json_decode($weather_data, true);
            }
            if(!is_array($weather_data)){
                $weather_data =[];
            }
            $weather = $weather_data['weather'] ?? '';
            $temperature = $weather_data['temperature'] ?? '';
            $recordDate = $weather_data['date'] ?? '';
            // "晴 32 ~ 24℃ 东北风3-4级 周日 08月26日 (实时：24℃)"
            $recordDate = preg_replace('/\d{1,2}月\d{1,2}日/', '', $recordDate);
            //$recordDate = str_replace([$createdAt],[''],$recordDate);
            $wind = $weather_data['wind'] ?? '';
            $data['pro_records'][$k]['weather'] = $weather . ' ' . $temperature . ' ' . $wind ;// . ' ' . $recordDate ;

        }
        return view('handles.index', $data);
    }

}
