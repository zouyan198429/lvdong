<?php
// 公司生产单元
namespace App\Http\Controllers;

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
}
