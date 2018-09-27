<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Illuminate\Http\Request;

class HandlesController extends LoginController
{
    protected $model_name = 'CompanyProRecord';
    /**
     * 生产日志
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);
        return view('handles.index');
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
        $relations = ['siteResources','CompanyInfo'];// 关系
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
            $pic_arr = $v['site_resources'] ?? [];
            $pic_urls = array_column($pic_arr,'resource_url');
            $data_list[] = [
                'id' => $v['id'] ,
                'is_node' => $v['is_node'] ,
                'node_text' => $v['node_text'] ,
                'audit_status' => $v['audit_status'] ,
                'audit_status_text' => $v['audit_status_text'] ,
                'record_intro' => $v['record_intro'] ,
                'company_id' => $v['company_id'] ,
                'company_name' => $v['company_info']['company_name'] ?? '',//  企业名称
                'pic_urls' => $pic_urls ,
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
