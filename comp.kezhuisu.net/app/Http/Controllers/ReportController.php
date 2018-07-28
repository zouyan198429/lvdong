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
    public function index(Request $request,$pro_unit_id)
    {
        $this->InitParams($request);
        // 获得检测报告列表
        // 获得所有的帐号信息
        $relations = ['siteResources'];// 关系
        $queryParams = [
            'where' => [
                ['company_id', $this->company_id],
                ['pro_unit_id', $pro_unit_id],
            ],
            'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数
        $reportsList = $this->ajaxGetAllList($this->model_name, '', $this->company_id,$queryParams ,$relations );
        // 资源url
        $this->resoursceUrl($reportsList);
        return view('report.index',[
            'pro_unit_id' => $pro_unit_id,
            'reportsList' => $reportsList,
        ]);
    }

    /**
     * ajax获得列表数据
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_alist(Request $request,$pro_unit_id){
        $this->InitParams($request);

        // 获得翻页的三个关键参数
        $pageParams = Common::getPageParams($request);
        list($page, $pagesize, $total) = array_values($pageParams);
        // 获得列表
        $relations = ['siteResources'];// 关系
        $queryParams = [
            'where' => [
                ['company_id', $this->company_id],
                ['pro_unit_id', $pro_unit_id],
            ],
            'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数
        $result = $this->ajaxGetAllList($this->model_name, '', $this->company_id,$queryParams ,$relations );

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
            $createdAt = judgeDate($v['created_at'],"Y-m-d");
            $data_list[] = [
                'id' => $v['id'] ,
                'resource_id' => $v['resource_id'] ,
                'report_name' => $v['report_name'] ,
                'report_intro' => $v['report_intro'] ,
                'resource_url' => $v['site_resources'][0]['resource_url'] ?? '' ,
                'resource_name' => $v['site_resources'][0]['resource_name'] ?? '' ,
                'resource_note' => $v['site_resources'][0]['resource_note'] ?? '' ,
                'created_at' => $createdAt === false ? '' : $createdAt,
            ];
        }

        $result = array(
            'has_page'=> $totalPage > $page,
            'data_list'=>$data_list,//array(),//数据二维数组
            'total'=>$total,//总记录数 0:每次都会重新获取总数 ;$total :则>0总数据不会重新获取[除第一页]
            //'pageInfo' => showPage($totalPage,$page,$total,12,1),
        );
        if($this->save_session){
            $result['pageInfo'] = showPage($totalPage,$page,$total,12,1);
        }
        return ajaxDataArr(1, $result, '');
    }

    /**
     * -删除
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_del(Request $request)
    {
        $this->InitParams($request);
        $id = Common::getInt($request, 'id');
        $pro_unit_id = Common::getInt($request, 'pro_unit_id');

        if(empty($pro_unit_id)){
            return ajaxDataArr(0, null, '参数错误!!');
        }

        $queryParams =[// 查询条件参数
            'where' => [
                ['id', $id],
                ['company_id', $this->company_id],
                ['pro_unit_id', $pro_unit_id],
            ]
        ];

        // 判断权限
        $judgeData = [
            'company_id' => $this->company_id,
            'pro_unit_id' => $pro_unit_id,
        ];
        $relations = ['siteResources'];
        $infoData = $this->judgePower($request, $id,$judgeData,$this->model_name, $this->company_id,$relations);
        $resources = $infoData['site_resources'] ?? [];
        $this->resourceDelFile($resources);// 删除资源

        // 删除与图片的关系
        // 无删除移除关系表--注意要先删除关系
        $detachParams =[
            'siteResources' => [],//相关维护人员
        ];
        $detachDatas = $this->detachByIdApi($this->model_name, $id, $detachParams, $this->company_id, 0);

        $resultDatas = $this->ajaxDelApi($this->model_name, $this->company_id , $queryParams);

        $resluts = [
            'resData' =>   $resultDatas,
            'detachDatas' =>   $detachDatas,
        ];
        return ajaxDataArr(1, $resluts, '');
    }

    /**
     * ajax保存数据
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_save(Request $request,$pro_unit_id)
    {
        $this->InitParams($request);
        $company_id = $this->company_id;

        $id = Common::getInt($request, 'id');
        if($id < 0){
            throws('参数[id]有误！');
        }
        Common::judgeInitParams($request, 'pro_unit_id', $pro_unit_id);

        $resource_ids = Common::get($request, 'resource_id');
        if(is_string($resource_ids) || is_numeric($resource_ids)){
            $resource_ids = explode(',' ,$resource_ids);
        }
        $resultDatas = [];
        $syncDatas = [];
        foreach($resource_ids as $resource_id) {
            $id = 0;
            if (!is_numeric($resource_id)) {
                continue;
            }

            $saveData = [
                'resource_id' => $resource_id,
                'account_id' => $this->user_id,
            ];

            if($id <= 0){// 新加
                $addNewData = [
                    'company_id' => $company_id,
                    'pro_unit_id' => $pro_unit_id,
                ];
                $saveData = array_merge($saveData, $addNewData);
                $results = $this->createApi($this->model_name,$saveData,$company_id);
                $id = $results['id'] ?? 0;
                $resultDatas[] = $results;
            }else{// 修改
                // 判断权限
                $judgeData = [
                    'company_id' => $company_id,
                    'pro_unit_id' => $pro_unit_id,
                ];
                $relations = '';
                $this->judgePower($request, $id,$judgeData,$this->model_name, $company_id,$relations);

                $resultDatas[] = $this->saveByIdApi($this->model_name, $id, $saveData, $company_id);

            }

            // 同步修改图片关系
            $syncParams =[
                'siteResources' => $resource_id,
            ];
            $syncDatas[] = $this->saveSyncByIdApi($this->model_name, $id, $syncParams, $company_id);

        }
        $resluts = [
            'resData' =>   $resultDatas,
            'syncData' =>   $syncDatas,
        ];

        return ajaxDataArr(1, $resluts, '');
    }

}
