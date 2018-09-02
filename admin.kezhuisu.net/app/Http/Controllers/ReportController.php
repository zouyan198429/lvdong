<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Illuminate\Http\Request;

class ReportController extends LoginController
{
    protected $model_name = 'CompanyProReport';
    /**
     * 检测报告
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);
        return view('report.index');
    }

    /**
     * ajax获得列表数据
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_alist(Request $request){
        $this->InitParams($request);

        // 获得翻页的三个关键参数
        $pageParams = Common::getPageParams($request);
        list($page, $pagesize, $total) = array_values($pageParams);

        $queryParams = [
            'where' => [
                //  ['company_id', $this->company_id],
            ],
            'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数
        $relations = ['siteResources','CompanyInfo','companyProUnit'];// 关系
        $result = $this->ajaxGetList($this->model_name, $pageParams, $this->company_id,$queryParams ,$relations);
        if(isset($result['dataList'])){
            $resultDatas = $result['dataList'];
            $pagesize = $result['pageSize'] ?? $pagesize;
            $page = $result['page'] ?? $page;

            if ($total <= 0 ) {
                $total = $result['total'] ?? $total;
            }

            // $totalPage = $result['totalPage'] ?? 0;
        }else{
            $resultDatas = $result;
            //if ($total <= 0 ) {
            $total = count($resultDatas);
            //}
            if($total > 0) $pagesize = $total;
        }
        // 处理图片地址
        $this->resoursceUrl($resultDatas);
        $totalPage = ceil($total/$pagesize);
        $data_list = [];
        foreach($resultDatas as $v){
            $data_list[] = [
                'id' => $v['id'] ,
                'company_name' => $v['company_info']['company_name'] ?? '',//  企业名称
                'resource_url' => $v['site_resources'][0]['resource_url'] ?? '' ,
                'resource_name' => $v['site_resources'][0]['resource_name'] ?? '' ,
                'pro_input_name' => $v['company_pro_unit']['pro_input_name'] ?? '' ,
                'created_at' => $v['created_at'],
            ];
        }

        $result = array(
            'data_list'=>$data_list,//array(),//数据二维数组
            'total'=>$total,//总记录数 0:每次都会重新获取总数 ;$total :则>0总数据不会重新获取[除第一页]
            'pageInfo' => showPage($totalPage,$page,$total,12,1),
        );
        return ajaxDataArr(1, $result, '');
    }
}
