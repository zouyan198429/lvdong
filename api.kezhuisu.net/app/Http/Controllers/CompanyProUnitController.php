<?php
// 公司生产单元
namespace App\Http\Controllers;

use App\Models\CompanyProInput;
use App\Models\CompanyProRecord;
use App\Models\CompanyProSecurityLabel;
use App\Services\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyProUnitController extends CompController
{

    /**
     * 统计生产单元下的标签
     *
     * @param string $Model_name model名称
     * @param int $id
     * @param string/array $detaches 移除关系数组/json字符 空：移除所有，id数组：移除指定的
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function countLabels(Request $request)
    {
        $this->InitParams($request);
        $unitIds = Common::get($request, 'unitIds');
        // json 转成数组
        jsonStrToArr($unitIds , 1, '参数[unitIds]格式有误!');
        $dataList = CompanyProSecurityLabel::whereIn('pro_unit_id',$unitIds)
        ->select(DB::raw('count(*) as label_count, pro_unit_id'))
        ->groupBy('pro_unit_id')
        ->get();
        $requestData = [];
        foreach($dataList as $info){
            $requestData[$info['pro_unit_id']] = $info['label_count'];
        }
        foreach ($unitIds as $id){
            if(isset($requestData[$id])){
                continue;
            }
            $requestData[$id] = 0;
        }
        return okArray($requestData);
    }

    /**
     * 统计生产单元下的日志、投入品、检测报告
     *
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function countUnits(Request $request)
    {
        $this->InitParams($request);
        $unitIds = Common::get($request, 'unitIds');
        // json 转成数组
        jsonStrToArr($unitIds , 1, '参数[unitIds]格式有误!');

        $requestData = [];

        foreach ($unitIds as $id){
            $requestData[$id] = [
                'record_count' => 0,
                'input_count' => 0,
                'report_count' => 0,
            ];
        }

        // 获得日志统计
        $dataList = CompanyProRecord::where(
                    [
                        ['company_id',$this->company_id],
                        ['is_node',1],
                        ['audit_status',1],
                    ]
            )
            ->whereIn('pro_unit_id',$unitIds)
            ->select(DB::raw('count(*) as record_count, pro_unit_id'))
            ->groupBy('pro_unit_id')
            ->get();
        foreach($dataList as $info){
            $requestData[$info['pro_unit_id']]['record_count'] = $info['record_count'];
        }

        // 获得投入品统计
        $dataList = CompanyProInput::where(
                [
                    ['company_id',$this->company_id],
                ]
            )
            ->whereIn('pro_unit_id',$unitIds)
            ->select(DB::raw('count(*) as input_count, pro_unit_id'))
            ->groupBy('pro_unit_id')
            ->get();
        foreach($dataList as $info){
            $requestData[$info['pro_unit_id']]['input_count'] = $info['input_count'];
        }

        // 获得检测报告统计
        $dataList = CompanyProInput::where(
                [
                    ['company_id',$this->company_id],
                ]
            )
            ->whereIn('pro_unit_id',$unitIds)
            ->select(DB::raw('count(*) as report_count, pro_unit_id'))
            ->groupBy('pro_unit_id')
            ->get();
        foreach($dataList as $info){
            $requestData[$info['pro_unit_id']]['report_count'] = $info['report_count'];
        }

        return okArray($requestData);
    }

}
