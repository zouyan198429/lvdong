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
        $has_add = 1;
        $tishi = '';
        // 判断是否在VIP有效期内
        $user_info = $this->user_info;
        $company_vipbegin = $user_info['company_info']['company_vipbegin'] ?? '';
        $company_vipend = $user_info['company_info']['company_vipend'] ?? '';
        //判断开始
        $comp_begin_time_unix = judgeDate($company_vipbegin);
        if($comp_begin_time_unix === false){
            $has_add = 0;
            $tishi = 'VIP开始日期不是有效日期';
            // ajaxDataArr(0, null, 'VIP开始日期不是有效日期');
        }

        //判断期限结束
        $comp_end_time_unix = judgeDate($company_vipend);
        if($comp_end_time_unix === false){
            $has_add = 0;
            $tishi = 'VIP结束日期不是有效日期';
            // ajaxDataArr(0, null, 'VIP结束日期不是有效日期');
        }

        if($comp_end_time_unix < $comp_begin_time_unix){
            $has_add = 0;
            $tishi = 'VIP结束日期不能小于开始日期';
            // ajaxDataArr(0, null, 'VIP结束日期不能小于开始日期');
        }
        $nowTime = time();
        if($nowTime < $comp_begin_time_unix){
            $has_add = 0;
            $tishi = 'VIP还未到开始日期，不能新加生产单元!';
            // ajaxDataArr(0, null, 'VIP还未到开始日期，不能新加生产单元!');
        }
        if($nowTime > $comp_end_time_unix){
            $has_add = 0;
            $tishi = 'VIP已过期，不能新加生产单元!';
            // ajaxDataArr(0, null, 'VIP已过期，不能新加生产单元!');
        }
        return view('productunit.index',['has_add' => $has_add,'tishi'=>$tishi]);
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
            $relations = ['proUnitAccounts','siteResources'];
            $resultDatas = $this->getinfoApi($this->model_name, $relations, $this->company_id , $id);
            // 判断权限
            $judgeData = [
                'company_id' => $this->company_id,
            ];
            $this->judgePowerByObj($request,$resultDatas, $judgeData );
        }

        $seledAccounts = array_column(($resultDatas['pro_unit_accounts'] ?? []),'id');

        // 获得所有的帐号信息
        /*
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
        */
        $resultDatas['accountList'] = [];//$accounts;
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
        $pro_input_intro = $resultDatas['pro_input_intro'] ?? '';
        $resultDatas['pro_input_intro'] = replace_enter_char($pro_input_intro,2);
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
        if($this->save_session){
            $queryParams = [
                'where' => [
                    ['company_id', $this->company_id],
                ],
                'orderBy' => ['id'=>'desc'],
            ];// 查询条件参数
            $relations = ['siteResources','proUnitAccounts'];// 关系
            $result = $this->ajaxGetList($this->model_name, $pageParams, $this->company_id,$queryParams ,$relations);

        }else{
            // 获得列表
            $relations = ['siteResources','proUnitAccounts'];// 关系
            $queryParams = [
                'where' => [
                    ['company_id', $this->company_id],
                ],
                'orderBy' => ['id'=>'desc'],
            ];// 查询条件参数
            $result = $this->ajaxGetAllList($this->model_name, '', $this->company_id,$queryParams ,$relations );
        }
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

        $this->resoursceUrl($resultDatas);
        $totalPage = ceil($total/$pagesize);
        $data_list = [];
        foreach($resultDatas as $v){
            $pro_unit_accounts = $v['pro_unit_accounts'] ?? [];
            $endTime = $v['end_time'] ;
            $status = $v['status'];
            $status_text = $v['status_text'];
            if(!empty($endTime)){
                $endTimeUnix = judgeDate($endTime);
                if($endTimeUnix < time() && in_array($status,[0,1,2]) ){
                    $status = 3;
                    $status_text = '过期';
                }
            }
            $temBeginTime = judgeDate($v['begin_time'],'Y-m-d');
            $temEndTime = judgeDate($v['end_time'],'Y-m-d');
            if($temEndTime === false){
                $bath_time = $temBeginTime . '开始';
            }else{
                $bath_time = $temBeginTime . '到' . $temEndTime;
            }
            $data_list[] = [
                'id' => $v['id'] ,
                'pro_input_batch' => $v['pro_input_batch'],
                'pro_input_name' => $v['pro_input_name'],
                'pic_url' => $v['site_resources'][0]['resource_url'] ?? '',
                'bath_time' => $bath_time ,
                'accounts' => implode(' ',array_column($pro_unit_accounts, 'real_name')),
                'status_text' => $status_text,
                'status' => $status,
                'created_at' => $v['created_at'],
            ];
        }
        $result = array(
            'has_page'=> $totalPage > $page,
            'data_list'=>$data_list,//array(),//数据二维数组
            'total'=>$total,//总记录数 0:每次都会重新获取总数 ;$total :则>0总数据不会重新获取[除第一页]
            // 'pageInfo' => showPage($totalPage,$page,$total,12,1),
        );
        if($this->save_session){
            $result['pageInfo'] = showPage($totalPage,$page,$total,12,1);
        }
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
        $relations = ['siteResources'];
        $infoData = $this->hasPower($request, $id, 1, $relations);
        $resources = $infoData['site_resources'] ?? [];
        $this->resourceDelFile($resources);// 删除资源
        // 无删除移除关系表--注意要先删除关系
        $detachParams =[
            'siteResources' => [],//相关维护人员
        ];
        $detachPicDatas = $this->detachByIdApi($this->model_name, $id, $detachParams, $this->company_id);

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
            'detachPicDatas' =>   $detachPicDatas,
        ];


        return ajaxDataArr(1, $resluts, '');
    }

    /**
     * ajax保存结束生产周期
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_finish(Request $request)
    {
        $this->InitParams($request);
        $id = Common::getInt($request, 'id');
        // Common::judgeEmptyParams($request, 'id', $id);
        $company_id = $this->company_id;
        // 判断权限
        $this->hasPower($request, $id, 3);

        $saveData = [
            'status' => 4,
            'end_time' => judgeDate(time(),'Y-m-d H:i:s'),
        ];
        $resultDatas = $this->saveByIdApi($this->model_name, $id, $saveData, $company_id, 0);
        return ajaxDataArr(1, $resultDatas, '');
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
        // 判断是否在VIP有效期内
        $user_info = $this->user_info;
        $company_vipbegin = $user_info['company_info']['company_vipbegin'] ?? '';
        $company_vipend = $user_info['company_info']['company_vipend'] ?? '';
        //判断开始
        $comp_begin_time_unix = judgeDate($company_vipbegin);
        if($comp_begin_time_unix === false){
            ajaxDataArr(0, null, 'VIP开始日期不是有效日期');
        }

        //判断期限结束
        $comp_end_time_unix = judgeDate($company_vipend);
        if($comp_end_time_unix === false){
            ajaxDataArr(0, null, 'VIP结束日期不是有效日期');
        }

        if($comp_end_time_unix < $comp_begin_time_unix){
            ajaxDataArr(0, null, 'VIP结束日期不能小于开始日期');
        }
        $nowTime = time();
        if($nowTime < $comp_begin_time_unix){
            ajaxDataArr(0, null, 'VIP还未到开始日期，不能新加生产单元!');
        }
        if($nowTime > $comp_end_time_unix){
            ajaxDataArr(0, null, 'VIP已过期，不能新加生产单元!');
        }

        $site_pro_unit_id = Common::getInt($request, 'site_pro_unit_id');
        $site_pro_unit_id_two = Common::getInt($request, 'site_pro_unit_id_two');
        $pro_input_name = Common::get($request, 'pro_input_name');
        $pro_input_brand = Common::get($request, 'pro_input_brand');
        $pro_input_batch = Common::get($request, 'pro_input_batch');
        $begin_time = Common::get($request, 'begin_time');
        $end_time = Common::get($request, 'end_time');
        $pro_input_intro = Common::get($request, 'pro_input_intro');
        $pro_input_intro =  replace_enter_char($pro_input_intro,1);

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
//        $end_time_unix = judgeDate($end_time);
//        if($end_time_unix === false){
//            ajaxDataArr(0, null, '结束日期不是有效日期');
//        }

//        if($end_time_unix < $begin_time_unix){
//            ajaxDataArr(0, null, '结束日期不能小于开始日期');
//        }

        $resource_id = Common::get($request, 'resource_id');
        if( (!empty($resource_id)) && (is_string($resource_id) || is_numeric($resource_id) )){
            $resource_id = explode(',' ,$resource_id);
        }

        $saveData = [
            'company_id' => $company_id,
            'site_pro_unit_id' => $site_pro_unit_id,
            'site_pro_unit_id_two' => $site_pro_unit_id_two,
            'pro_input_name' => $pro_input_name,
            'pro_input_brand' => $pro_input_brand,
            'pro_input_batch' => $pro_input_batch,
            'begin_time' => $begin_time,
           // 'end_time' => $end_time,
            'pro_input_intro' => $pro_input_intro,
        ];
        if(!empty($resource_id)){
            $saveData['resource_id'] = $resource_id[0] ?? 0;
        }
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
//        $syncAccountArr = [];
//        foreach($selAccounts as $account){
//            $syncAccountArr[$account] = [
//                'company_id' => $company_id,
//            ];
//        }
//        $syncParams =[
//            'proUnitAccounts' => $syncAccountArr,//相关维护人员
//        ];
//        $syncDatas = $this->saveSyncByIdApi($this->model_name, $id, $syncParams, $company_id, 0);

        // 同步修改图片关系
        $syncPicDatas = [];
        if(!empty($resource_id)){
            $syncParams =[
                'siteResources' => $resource_id,
            ];
            $syncPicDatas = $this->saveSyncByIdApi($this->model_name, $id, $syncParams, $company_id);
        }
        $resluts = [
           'resData' =>   $resultDatas,
           // 'syncData' =>   $syncDatas,
           'syncPicData' =>   $syncPicDatas,
        ];

        //如果当前用户有管理生产单元的权限，更新session
        // $userInfo = $_SESSION['userInfo']?? [];
        /*
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
        */

        return ajaxDataArr(1, $resluts, '');
    }

    /**
     * 生产单元详情
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_info(Request $request)
    {
        $this->InitParams($request);
        $id = Common::getInt($request, 'id');
        if($id <= 0){
            throws('参数[id]有误！', $this->source);
        }
        // 获得帮助单条信息
        $relations = ['siteResources'];
        $model_name = $this->model_name;
        $company_id = $this->company_id;
        $infoData = $this->getinfoApi($model_name, $relations, $company_id , $id);
        if(is_null($infoData['pro_input_intro'])){
            $infoData['pro_input_intro'] = '';
        }
        $pro_input_intro = $infoData['pro_input_intro'] ?? '';
        $infoData['pro_input_intro'] = replace_enter_char($pro_input_intro,2);
        $infoData['begin_time'] = judgeDate($infoData['begin_time'],"Y-m-d");
        $infoData['end_time'] = judgeDate($infoData['end_time'],"Y-m-d");
        $this->resourceUrl($infoData);// 删除资源
        //$upload_picture_list = [];
        $site_resources = $infoData['site_resources'] ?? [];
//        foreach($site_resources as $v){
//            $upload_picture_list[] = [
//                'upload_percent' => 100,
//                'path' => $v['resource_url'] ?? '',
//                'path_server' => $v['resource_url'] ?? '',
//                'resource_id' => $v['id'] ?? 0,
//            ];
//        }
        $infoData['upload_picture_list'] = $this->getFormatResource($site_resources);
        return ajaxDataArr(1, $infoData, '');
    }

    // 判断是否有权限操作
    public function hasPower(Request $request, $id, $type, $relations = ''){
        // 判断权限
        $judgeData = [
            'company_id' => $this->company_id,
        ];
        // $relations = '';
        $info = $this->judgePower($request, $id,$judgeData,$this->model_name, $this->company_id,$relations);

        switch (trim($type)) {
            case 1: // 删除记录时权限
            case 2: // 保存或修改时权限
                $infoStatus = $info['status'] ?? '';
                // 状态0待审核2审核未通过 可以删除
                if(! in_array($infoStatus,[0,2])){
                    throws('没有操作权限！', $this->source);
                }
                break;
            case 3: // 结束生产周期
                $infoStatus = $info['status'] ?? '';
                // 状态0待审核2审核未通过 可以删除
                if(! in_array($infoStatus,[1])){
                    throws('没有操作权限！', $this->source);
                }
                break;
        }
        return $info;
    }
}
