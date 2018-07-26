<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Illuminate\Http\Request;

class HonorController extends LoginController
{
    protected $model_name = 'CompanyHonor';
    /**
     * 企业资质列表
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);
        return view('honor.index');
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
        $relations = ['siteResources','CompanyInfo.province','CompanyInfo.city','CompanyInfo.area'];// 关系
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
        }
        // 处理图片地址
        $this->resoursceUrl($resultDatas);
        $totalPage = ceil($total/$pagesize);
        $data_list = [];
        foreach($resultDatas as $v){
            $province = $v['company_info']['province']['province_name'] ?? '';
            $city = $v['company_info']['city']['city_name'] ?? '';
            $area = $v['company_info']['area']['city_name'] ?? '';
            $data_list[] = [
                'id' => $v['id'] ,
                'company_id' => $v['company_id'] ,
                'status' => $v['status'] ,
                'status_text' => $v['status_text'] ,
                'company_name' => $v['company_info']['company_name'] ?? '',//  企业名称
                'company_linkman' => $v['company_info']['company_linkman'] ?? '',
                'company_mobile' => $v['company_info']['company_mobile'] ?? '',
                'company_tel' => $v['company_info']['company_tel'] ?? '',
                'resource_url' => $v['site_resources'][0]['resource_url'] ?? '' ,
                'resource_name' => $v['site_resources'][0]['resource_name'] ?? '' ,
                'created_at' => judge_date($v['created_at'],'Y-m-d'),
                'area' => $province . '/' . $city,
            ];
        }

        $result = array(
            'data_list'=>$data_list,//array(),//数据二维数组
            'total'=>$total,//总记录数 0:每次都会重新获取总数 ;$total :则>0总数据不会重新获取[除第一页]
            'pageInfo' => showPage($totalPage,$page,$total,12,1),
        );
        return ajaxDataArr(1, $result, '');
    }

    /**
     * 管理-删除
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_del(Request $request)
    {
        $this->InitParams($request);
        $id = Common::getInt($request, 'id');
        // 判断权限
        $judgeData = [
            //'company_id' => $this->company_id,
            //'pro_unit_id' => $pro_unit_id,
        ];
        $relations = ['siteResources'];
        $infoData = $this->judgePower($request, $id,$judgeData,$this->model_name, $this->company_id,$relations);
        $resources = $infoData['site_resources'] ?? [];
        $this->resourceDelFile($resources);// 删除资源
        // 无删除移除关系表--注意要先删除关系
        $detachParams =[
            'siteResources' => [],//相关维护人员
        ];
        $detachDatas = $this->detachByIdApi($this->model_name, $id, $detachParams, $this->company_id);

        $queryParams =[// 查询条件参数
            'where' => [
                ['id', $id],
                //   ['company_id', $this->company_id],
            ]
        ];

        $resultDatas = $this->ajaxDelApi($this->model_name, $this->company_id , $queryParams);

        $resluts = [
            'resData' =>   $resultDatas,
            'detachDatas' =>   $detachDatas,
        ];
        return ajaxDataArr(1, $resluts, '');
    }

    /**
     * 审核通过/未通过
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_status(Request $request)
    {
        $this->InitParams($request);
        $id = Common::getInt($request, 'id');
        $status = Common::getInt($request, 'status');
        if(!in_array($status,[1,2])){
            return ajaxDataArr(0, null, '状态值有误');
        }

        // 判断权限
//        $judgeData = [
//            'company_id' => $this->company_id,
//            // 'pro_unit_id' => $pro_unit_id,
//        ];
//        $relations = '';
//        $this->judgePower($request, $id,$judgeData,$this->model_name, $this->company_id,$relations);

        $queryParams =[// 查询条件参数
            'where' => [
                ['id', $id],
                //['company_id', $this->company_id],
                //['pro_unit_id', $pro_unit_id],
                ['status', 0],
            ]
        ];
        $resultDatas =  $this->ModifyByQueyApi($this->model_name, ['status'=> $status], $queryParams, $this->company_id, 0);

        return ajaxDataArr(1, $resultDatas, '');
    }

}
