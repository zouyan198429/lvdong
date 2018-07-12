<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Illuminate\Http\Request;

class HandlesController extends LoginController
{
    protected $model_name = 'CompanyProRecord';

    /**
     * 农事记录
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request,$pro_unit_id)
    {

        $this->InitParams($request);
        return view('handles.index',['pro_unit_id' => $pro_unit_id]);
    }

    /**
     * 农事记录-添加
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function add(Request $request,$pro_unit_id,$id)
    {
        $this->InitParams($request);

        $resultDatas = [
            'id'=>$id,
            'pro_unit_id' => $pro_unit_id,
            'is_node' => 0,
        ];
        if ($id > 0) { // 获得详情数据
            $relations = ['siteResources'];
            $resultDatas = $this->getinfoApi($this->model_name, $relations, $this->company_id , $id);
            // 判断权限
            $judgeData = [
                'company_id' => $this->company_id,
                'pro_unit_id' => $pro_unit_id,
            ];

            $this->judgePowerByObj($request,$resultDatas, $judgeData );
        }
        // 资源url
        $this->resourceUrl($resultDatas);
        return view('handles.add',$resultDatas);
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

        $queryParams = [
            'where' => [
                ['company_id', $this->company_id],
                ['pro_unit_id', $pro_unit_id],
            ],
            'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数
        $relations = ['siteResources','companyAccount'];// 关系
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

        $totalPage = ceil($total/$pagesize);
        $data_list = [];
        foreach($resultDatas as $v){
            $pic_arr = $v['site_resources'] ?? [];
            $pic_urls = array_column($pic_arr,'resource_url');
            foreach($pic_urls as $p_k=>$p_v){
                $pic_urls[$p_k] = url($p_v);
            }
            $data_list[] = [
                'id' => $v['id'] ,
                'record_intro' => $v['record_intro'] ?? '',//  记录内容
                'pic_urls' => $pic_urls ,
                'real_name' => $v['company_account']['real_name'] ?? '',
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

        $resource_id = Common::get($request, 'resource_id');
        $record_intro = Common::get($request, 'record_intro');
        $record_intro =  replace_special_char($record_intro,2);
        $record_intro =  replace_enter_char($record_intro,2);
        $is_node = Common::get($request, 'is_node');
        if(!is_numeric($is_node)){
            $is_node = 0;
        }

        $saveData = [
            'record_intro' => $record_intro,
            'is_node' => $is_node,
            'account_id' => $this->user_id,
        ];

        if($id <= 0){// 新加
            $addNewData = [
                'company_id' => $company_id,
                'pro_unit_id' => $pro_unit_id,
            ];
            $saveData = array_merge($saveData, $addNewData);
            $resultDatas = $this->createApi($this->model_name,$saveData,$company_id);
            $id = $resultDatas['id'] ?? 0;
        }else{// 修改
            // 判断权限
            $judgeData = [
                'company_id' => $company_id,
                'pro_unit_id' => $pro_unit_id,
            ];
            $relations = '';
            $this->judgePower($request, $id,$judgeData,$this->model_name, $company_id,$relations);

            $resultDatas = $this->saveByIdApi($this->model_name, $id, $saveData, $company_id);

        }

        // 同步修改图片关系
        $syncParams =[
            'siteResources' => $resource_id,
        ];
        $syncDatas = $this->saveSyncByIdApi($this->model_name, $id, $syncParams, $company_id);

        $resluts = [
            'resData' =>   $resultDatas,
            'syncData' =>   $syncDatas,
        ];

        return ajaxDataArr(1, $resluts, '');
    }

    /**
     * -删除
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_del(Request $request,$pro_unit_id)
    {
        $this->InitParams($request);
        $id = Common::getInt($request, 'id');
        if($id < 0){
            throws('参数[id]有误！');
        }
        Common::judgeInitParams($request, 'pro_unit_id', $pro_unit_id);

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
        $infoData =$this->judgePower($request, $id,$judgeData,$this->model_name, $this->company_id,$relations);
        $resources = $infoData['site_resources'] ?? [];
        $this->resourceDelFile($resources);// 删除资源
        // 删除与图片的关系
        // 无删除移除关系表--注意要先删除关系
        $detachParams =[
            'siteResources' => [],//相关维护人员
        ];
        $detachDatas = $this->detachByIdApi($this->model_name, $id, $detachParams, $this->company_id);

        $resultDatas = $this->ajaxDelApi($this->model_name, $this->company_id , $queryParams);

        $resluts = [
            'resData' =>   $resultDatas,
            'detachDatas' =>   $detachDatas,
        ];
        return ajaxDataArr(1, $resluts, '');
    }
}