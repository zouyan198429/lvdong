<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Illuminate\Http\Request;

class InputsController extends LoginController
{
    protected $model_name = 'CompanyProInput';

    /**
     * 生产投入品
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request,$pro_unit_id)
    {
        $this->InitParams($request);
        return view('inputs.index',['pro_unit_id' => $pro_unit_id]);
    }

    public function test(Request $request){

        return view('test');
    }

    /**
     * 生产投入品-添加
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
            'site_input_id' =>0,

        ];
        // 获得分类
        $relations = '';// 关系
        $queryParams = '';
        $siteInputList = $this->ajaxGetAllList('SiteProInput', '', $this->company_id,$queryParams ,'' );
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
        $resultDatas['SiteProInputs'] = $siteInputList;
        // 资源url
        $this->resourceUrl($resultDatas);
        return view('inputs.add',$resultDatas);
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
        $relations = ['siteProInput','siteResources'];// 关系
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
            $site_url = $v['site_resources'][0]['resource_url'] ?? '' ;
            $data_list[] = [
                'id' => $v['id'] ,
                'pro_input_name' => $v['site_pro_input']['pro_input_name'] ?? '',
                'pic_url' => url($site_url),
                'pro_input_name' => $v['pro_input_name'],
                'pro_input_brand' => $v['pro_input_brand'],
                'pro_input_factory' => $v['pro_input_factory'],
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
     * 子帐号管理-删除
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_del(Request $request,$pro_unit_id)
    {
        $this->InitParams($request);
        $id = Common::getInt($request, 'id');

        // 判断权限
        $judgeData = [
            'company_id' => $this->company_id,
            'pro_unit_id' => $pro_unit_id,
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
                ['company_id', $this->company_id],
                ['pro_unit_id', $pro_unit_id],
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
     * ajax保存数据
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_save(Request $request)
    {
        $this->InitParams($request);
        $id = Common::getInt($request, 'id');
        $pro_unit_id = Common::getInt($request, 'pro_unit_id');
        Common::judgeInitParams($request, 'pro_unit_id', $pro_unit_id);
        // Common::judgeEmptyParams($request, 'id', $id);
        $company_id = $this->company_id;
        $site_input_id = Common::getInt($request, 'site_input_id');
        $pro_input_name = Common::get($request, 'pro_input_name');
        $pro_input_brand = Common::get($request, 'pro_input_brand');
        $pro_input_factory = Common::get($request, 'pro_input_factory');
        $pro_input_intro = Common::get($request, 'pro_input_intro');
        $pro_input_intro =  replace_special_char($pro_input_intro,2);
        $pro_input_intro =  replace_enter_char($pro_input_intro,2);
        if (!is_numeric($pro_unit_id)){
            return ajaxDataArr(0, null, '请选择类别！');
        }

        $resource_id = Common::get($request, 'resource_id');

        $saveData = [
            // 'company_id' => $company_id,
            'site_input_id' => $site_input_id,
            // 'pro_unit_id' => $pro_unit_id,
            'resource_id' => $resource_id[0] ?? 0,
            'pro_input_name' => $pro_input_name,
            'pro_input_brand' => $pro_input_brand,
            'pro_input_factory' => $pro_input_factory,
            'pro_input_intro' => $pro_input_intro,
            'account_id' => $this->user_info['id'] ?? 0,
        ];

        if($id <= 0){// 新加
            $addNewData = [
                'company_id' => $company_id,
                'pro_unit_id' => $pro_unit_id,
            ];
            $saveData = array_merge($saveData, $addNewData);

            $resultDatas = $this->createApi($this->model_name,$saveData,$company_id,0);
            $id = $resultDatas['id'] ?? 0;
        }else{// 修改
            // 判断权限
            $judgeData = [
               'company_id' => $company_id,
               'pro_unit_id' => $pro_unit_id,
            ];
            $relations = '';
            $this->judgePower($request, $id,$judgeData,$this->model_name, $company_id,$relations);

            $resultDatas = $this->saveByIdApi($this->model_name, $id, $saveData, $company_id, 0);
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

}
