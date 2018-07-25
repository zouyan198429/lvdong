<?php

namespace App\Http\Controllers;

use App\Services\Common;
use App\Services\Tool;
use Illuminate\Http\Request;

class ProductUnitController extends LoginController
{
    protected $model_name = 'CompanyProUnit';
    /**
     * 生产单元管理
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);
        return view('productunit.index');
    }

    /**
     * 申请生产单元
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function add(Request $request,$id = 0)
    {
        $this->InitParams($request);
        $resultDatas = [
            'id'=>$id,
            'site_pro_unit_id'=>0,
            'site_pro_unit_id_two' =>0,
        ];
        if ($id > 0) { // 获得详情数据
            $relations = ['proUnitAccounts'];
            $resultDatas = $this->getinfoApi($this->model_name, $relations, $this->company_id , $id);
            // 判断权限
            $judgeData = [
                'company_id' => $this->company_id,
            ];
            $this->judgePowerByObj($request,$resultDatas, $judgeData );
        }

        $seledAccounts = array_column(($resultDatas['pro_unit_accounts'] ?? []),'id');

        // 获得所有的帐号信息
        $relations = '';// 关系
        $queryParams = [
            'where' => [
                ['company_id', $this->company_id],
            ],
            'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数
        $accountsList = $this->ajaxGetAllList('CompanyAccounts', '', $this->company_id,$queryParams ,'' );
        $accounts = [];
        foreach($accountsList as $account ){
            $checked = 0;
            if(in_array($account['id'],$seledAccounts)){
                $checked = 1;
            }
            array_push($accounts,[
                'id' => $account['id'],
                'real_name' => $account['real_name'],
                'checked' => $checked,
            ]);
        }
        $resultDatas['accountList'] = $accounts;
        // 获得第一级生产单元分类
        $relations = '';// 关系
        $queryParams = [
            'where' => [
                ['pro_unit_parent_id', 0],
            ],
            'select' => ['id','pro_unit_name'],
            'orderBy' => ['pro_unit_order'=>'desc','id'=>'desc'],
        ];// 查询条件参数
        $unitClsList = $this->ajaxGetAllList('SiteProUnit', '',$this->company_id,$queryParams ,$relations);
        $unitcls = [];
        foreach($unitClsList as $v){
            $unitcls[$v['id']] = $v['pro_unit_name'];
        }
        $resultDatas['unitcls'] = $unitcls;
        return view('productunit.apply',$resultDatas);
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
                ['company_id', $this->company_id],
            ],
            'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数
        $relations = ['companyProConfig.siteResources','proUnitAccounts'];// 关系
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
            $company_pro_config = $v['company_pro_config'] ?? [];
            $pro_unit_accounts = $v['pro_unit_accounts'] ?? [];
            $endTime = $v['end_time'] ;
            $status = $v['status'];
            $status_text = $v['status_text'];
            if(!empty($endTime)){
                $endTimeUnix = judgeDate($endTime);
                if($endTimeUnix < time()){
                    $status = 3;
                    $status_text = '过期';
                }
            }

            $data_list[] = [
                'id' => $v['id'] ,
                'pro_input_batch' => $v['pro_input_batch'],
                'pro_input_name' => $v['pro_input_name'],
                'pic_url' => $company_pro_config['site_resources'][0]['resource_url'] ?? '',
                'bath_time' => date('Y-m-d',strtotime($v['begin_time'])) . '到' . date('Y-m-d',strtotime($v['end_time'])) ,
                'accounts' => implode(' ',array_column($pro_unit_accounts, 'real_name')),
                'status_text' => $status_text,
                'status' => $status,
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
        $this->hasPower($request, $id, 1);
        // 无删除移除关系表--注意要先删除关系
        $detachParams =[
            'proUnitAccounts' => [],//相关维护人员
        ];
        $detachDatas = $this->detachByIdApi($this->model_name, $id, $detachParams, $this->company_id, 0);


        $queryParams =[// 查询条件参数
            'where' => [
                ['id', $id],
                ['company_id', $this->company_id],
            ]
        ];

        $resultDatas = $this->ajaxDelApi($this->model_name, $this->company_id , $queryParams);

        //如果当前用户有管理生产单元的权限，更新session
        // $userInfo = $_SESSION['userInfo']?? [];
        $userInfo = $this->getUserInfo();
        $proUnits = $userInfo['proUnits'] ?? [];
        // 当前用户，有管理权限，则移除
        if(isset($proUnits[$id])) { // 在session
            unset($proUnits[$id]);
            // 更新session
            $userInfo['proUnits'] = $proUnits;
            // $_SESSION['userInfo'] = $userInfo;
            $redisKey = $this->setUserInfo($userInfo, -1);
        }

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
        // Common::judgeEmptyParams($request, 'id', $id);
        $company_id = $this->company_id;
        $site_pro_unit_id = Common::getInt($request, 'site_pro_unit_id');
        $site_pro_unit_id_two = Common::getInt($request, 'site_pro_unit_id_two');
        $pro_input_name = Common::get($request, 'pro_input_name');
        $pro_input_brand = Common::get($request, 'pro_input_brand');
        $pro_input_batch = Common::get($request, 'pro_input_batch');
        $begin_time = Common::get($request, 'begin_time');
        $end_time = Common::get($request, 'end_time');
        $pro_input_intro = Common::get($request, 'pro_input_intro');
        $pro_input_intro =  replace_special_char($pro_input_intro,2);
        $pro_input_intro =  replace_enter_char($pro_input_intro,2);

        $selAccounts = Common::get($request, 'accout_id');
        if(!is_array($selAccounts) && is_string($selAccounts)){
            $selAccounts = explode(',',$selAccounts);
        }

        //判断开始
        $begin_time_unix = judgeDate($begin_time);
        if($begin_time_unix === false){
            ajaxDataArr(0, null, '开如日期不是有效日期');
        }

        //判断期限结束
        $end_time_unix = judgeDate($end_time);
        if($end_time_unix === false){
            ajaxDataArr(0, null, '结束日期不是有效日期');
        }

        if($end_time_unix < $begin_time_unix){
            ajaxDataArr(0, null, '结束日期不能小于开始日期');
        }

        $saveData = [
            'company_id' => $company_id,
            'site_pro_unit_id' => $site_pro_unit_id,
            'site_pro_unit_id_two' => $site_pro_unit_id_two,
            'pro_input_name' => $pro_input_name,
            'pro_input_brand' => $pro_input_brand,
            'pro_input_batch' => $pro_input_batch,
            'begin_time' => $begin_time,
            'end_time' => $end_time,
            'pro_input_intro' => $pro_input_intro,
        ];
        if($id <= 0){// 新加
            $resultDatas = $this->createApi($this->model_name,$saveData,$company_id,0);
            $id = $resultDatas['id'] ?? 0;
        }else{// 修改
            // 判断权限
            $this->hasPower($request, $id, 2);

            $resultDatas = $this->saveByIdApi($this->model_name, $id, $saveData, $company_id, 0);
        }
        // 同步修改关系
        // 加入company_id字段
        $syncAccountArr = [];
        foreach($selAccounts as $account){
            $syncAccountArr[$account] = [
                'company_id' => $company_id,
            ];
        }
        $syncParams =[
            'proUnitAccounts' => $syncAccountArr,//相关维护人员
        ];
        $syncDatas = $this->saveSyncByIdApi($this->model_name, $id, $syncParams, $company_id, 0);

        $resluts = [
           'resData' =>   $resultDatas,
           'syncData' =>   $syncDatas,
        ];

        //如果当前用户有管理生产单元的权限，更新session
        // $userInfo = $_SESSION['userInfo']?? [];
        $userInfo = $this->getUserInfo();
        $currentID = $userInfo['id'] ?? 0;
        $proUnits = $userInfo['proUnits'] ?? [];
        // 当前用户，有管理权限
        if(in_array($currentID,$selAccounts)){
            if(!isset($proUnits[$id])){ // 还不在session
                $proUnits[$id] = [
                    'unit_id' => $id,
                    'pro_input_name' => $pro_input_name,
                ];
                // 更新session
                $userInfo['proUnits'] = $proUnits;
                // $_SESSION['userInfo'] = $userInfo;
                $redisKey = $this->setUserInfo($userInfo, -1);
            }
        }else{// 没有管理权限
            if(isset($proUnits[$id])) { // 在session
                unset($proUnits[$id]);
                // 更新session
                $userInfo['proUnits'] = $proUnits;
                // $_SESSION['userInfo'] = $userInfo;
                $redisKey = $this->setUserInfo($userInfo,-1);
            }
        }

        return ajaxDataArr(1, $resluts, '');
    }

    // 判断是否有权限操作
    public function hasPower(Request $request, $id, $type){
        // 判断权限
        $judgeData = [
            'company_id' => $this->company_id,
        ];
        $relations = '';
        $info = $this->judgePower($request, $id,$judgeData,$this->model_name, $this->company_id,$relations);

        switch (trim($type)) {
            case 1: // 删除记录时权限
            case 2: // 保存或修改时权限
                $infoStatus = $info['status'] ?? '';
                // 状态0待审核2审核未通过 可以删除
                if(! in_array($infoStatus,[0,2])){
                    throws('没有操作权限！');
                }
                break;
        }
        return $info;
    }
}
