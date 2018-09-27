<?php

namespace App\Http\Controllers;

use App\Services\Common;
use App\Services\HttpRequest;
use App\Services\Tool;
use Illuminate\Http\Request;

class AccountsController extends LoginController
{
    protected $model_name = 'CompanyAccounts';

    /**
     * 子帐号管理
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);

        return view('accounts.index');
    }

    /**
     * 资料设置
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function set(Request $request)
    {
        $this->InitParams($request);
        $user_info = $this->user_info;
        return view('accounts.set',$user_info);
    }

    /**
     * 修改密码
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function mypass(Request $request)
    {
        $this->InitParams($request);
        return view('accounts.mypass');
    }

    /**
     * 子帐号管理-添加
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function add(Request $request,$id = 0)
    {

        $this->InitParams($request);
        $resultDatas = [
            'id' => 0,
            'account_issuper' =>0,
            'account_status' => 0,

        ];
        if ($id > 0) { // 获得详情数据
            $resultDatas = $this->getinfoApi($this->model_name, '', $this->company_id , $id);
            // 判断权限
            $judgeData = [
                'company_id' => $this->company_id,
            ];
            $this->judgePowerByObj($request,$resultDatas, $judgeData );
        }
        $remarks = $resultDatas['remarks'] ?? '';
        $resultDatas['remarks'] = replace_enter_char($remarks,2);

        return view('accounts.add',$resultDatas);
    }

    /**
     * 子帐号管理-删除
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
            'company_id' => $this->company_id,
        ];
        $relations = '';
        $this->judgePower($request, $id,$judgeData,$this->model_name, $this->company_id,$relations);

        $queryParams =[// 查询条件参数
            'where' => [
                ['id', $id],
                ['company_id', $this->company_id]
            ]
        ];
        $resultDatas = $this->ajaxDelApi($this->model_name, $this->company_id , $queryParams);

        return ajaxDataArr(1, $resultDatas, '');
    }

    /**
     * 获得所有帐号
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_getAccount(Request $request){
        $this->InitParams($request);
        $unitId = Common::getInt($request, 'unitId');// 当前生产单元id
        // 获得所有的帐号信息
        $relations = ['accountProUnits'];// 关系
        $queryParams = [
            'where' => [
                ['company_id', $this->company_id],
            ],
            'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数
        $accountsList = $this->ajaxGetAllList('CompanyAccounts', '', $this->company_id,$queryParams ,$relations );
        $result = [];
        foreach($accountsList as $v){
            $account_pro_units = $v['account_pro_units'] ?? [];
            $unitIds = array_column($account_pro_units,'id');
            $checked = false;
            if(in_array($unitId,$unitIds)){
                $checked = true;
            }
            $real_name = $v['real_name'];
            $mobile = $v['mobile'];
            if(empty($real_name)){
                $real_name = $mobile;
            }
            $result[] = [
                'id' => $v['id'],
                'real_name' => $real_name,
                'checked' => $checked ? "true" : "false",
                'check' => $checked,
            ];
        }
        return ajaxDataArr(1, $result, '');
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
        $relations = '';// 关系
        $result = $this->ajaxGetAllList($this->model_name, $pageParams, $this->company_id,$queryParams ,$relations );
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

        $totalPage = ceil($total/$pagesize);
        $data_list = [];
        foreach($resultDatas as $v){
            $data_list[] = [
                'id' => $v['id'] ,
                'account_username' => $v['account_username'],
                'wx_account' => $v['wx_account'],
                'real_name' => $v['real_name'],
                'mobile' => $v['mobile'],
                'created_at' => $v['created_at'],
                'account_status' => $v['account_status'],
                'account_statu_text' => $v['account_statu_text'],
                'account_issuper' => $v['account_issuper'],
                'record_audit' => $v['record_audit'],
                'record_audit_text' => $v['record_audit_text'],

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
        $account_username = Common::get($request, 'account_username');
        $account_password = Common::get($request, 'account_password');
        $sure_password = Common::get($request, 'sure_password');
        $account_status = Common::getInt($request, 'account_status');
        $wx_account = Common::get($request, 'wx_account');
        $real_name = Common::get($request, 'real_name');
        $record_audit = Common::get($request, 'record_audit');
        $mobile = Common::getInt($request, 'mobile');
        $remarks = Common::get($request, 'remarks');
        $remarks =  replace_enter_char($remarks,1);
        if ($account_password != $sure_password){
            return ajaxDataArr(0, null, '密码和确定密码不一致！');
        }
        // 查询手机号是否已经有企业使用--账号表里查
        if($this->existMobile($mobile,$id)){
            return ajaxDataArr(0, null, '手机号已存在！');
        }
        if(empty($account_username)){
            $account_username = $mobile;
        }
        if($this->existUsername($account_username,$id)){
            return ajaxDataArr(0, null, '用户名已存在！');
        }

        $saveData = [
            'company_id' => $company_id,
            'account_username' => $account_username,
            'account_status' => $account_status,
            'wx_account' => $wx_account,
            'real_name' => $real_name,
            'record_audit' => $record_audit,
            'mobile' => $mobile,
            'remarks' => $remarks,
        ];
        if($id <= 0){// 新加
            $addNewData = [
                'account_password' => $account_password,
            ];
            $saveData = array_merge($saveData, $addNewData);
            $resultDatas = $this->createApi($this->model_name,$saveData,$company_id,0);
        }else{// 修改
            if(!empty($account_password)){
                $addNewData = [
                    'account_password' => $account_password,
                ];
                $saveData = array_merge($saveData, $addNewData);
            }
            // 判断权限
            $judgeData = [
                'company_id' => $company_id,
            ];
            $relations = '';
            $this->judgePower($request, $id,$judgeData,$this->model_name, $company_id,$relations);

            $resultDatas = $this->saveByIdApi($this->model_name, $id, $saveData, $company_id, 0);
        }
        return ajaxDataArr(1, $resultDatas, '');
    }

    /**
     * 详情
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
        $relations = '';
        $model_name = $this->model_name;
        $company_id = $this->company_id;
        $infoData = $this->getinfoApi($model_name, $relations, $company_id , $id);
        return ajaxDataArr(1, $infoData, '');
    }
    /**
     * ajax资料设置
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_set_save(Request $request)
    {
        $this->InitParams($request);
        // $id = Common::getInt($request, 'id');
        // Common::judgeEmptyParams($request, 'id', $id);
        $id = $this->user_id;
        $company_id = $this->company_id;
        $wx_account = Common::get($request, 'wx_account');
        $real_name = Common::get($request, 'real_name');

        $saveData = [
            'wx_account' => $wx_account,
            'real_name' => $real_name,
        ];
        // 修改
        // 判断权限
        $judgeData = [
            'company_id' => $company_id,
        ];
        $relations = '';
        $this->judgePower($request, $id,$judgeData,$this->model_name, $company_id,$relations);

        $resultDatas = $this->saveByIdApi($this->model_name, $id, $saveData, $company_id, 0);

        // 更新session
        // $userInfo = $_SESSION['userInfo']?? [];
        $userInfo = $this->getUserInfo();
        $userInfo = array_merge($userInfo, $saveData);
        // $_SESSION['userInfo'] = $userInfo;
        $redisKey = $this->setUserInfo($userInfo, -1);
        return ajaxDataArr(1, $resultDatas, '');
    }

    /**
     * ajax修改密码
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_password_save(Request $request)
    {
        $this->InitParams($request);
        // $id = Common::getInt($request, 'id');
        // Common::judgeEmptyParams($request, 'id', $id);
        $id = $this->user_id;
        $company_id = $this->company_id;
        $old_password = Common::get($request, 'old_password');// 旧密码，如果为空，则不校验
        $account_password = Common::get($request, 'account_password');
        $sure_password = Common::get($request, 'sure_password');

        if (empty($account_password) || $account_password != $sure_password){
            return ajaxDataArr(0, null, '密码和确定密码不一致！');
        }

        $saveData = [
            'account_password' => $account_password,
        ];

        // 修改
        // 判断权限
        $judgeData = [
            'company_id' => $company_id,
        ];
        $relations = '';
        $this->judgePower($request, $id,$judgeData,$this->model_name, $company_id,$relations);
        // 如果有旧密码，则验证旧密码是否正确
        if(!empty($old_password)){
            $queryParams = [
                'where' => [
                    ['id',$this->user_id],
                    ['account_password',md5($old_password)],
                ],
                // 'limit' => 1
            ];
            $relations = '';
            $infoData = $this->getInfoByQuery($this->model_name, $company_id,$queryParams,$relations,0);
            if(empty($infoData)){
                return ajaxDataArr(0, null, '原始密码不正确！');
            }
        }
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
    public function ajax_login_judge(Request $request)
    {
        // $this->InitParams($request);
        // $company_id = $this->company_id;
        $temRedisKey = Common::get($request, 'redisKey');
        if(!empty($temRedisKey)){// 不为空，则是从小程序来的
            $this->redisKey = $temRedisKey;
            $this->save_session = false;
        }
        //session_start(); // 初始化session
        //$userInfo = $_SESSION['userInfo']?? [];
        $userInfo = $this->getUserInfo();
        if(empty($userInfo)) {
            return ajaxDataArr(0, null, '登陆状态已经失效。');
        }
        $company_id = $userInfo['company_id'] ?? null;//Common::getInt($request, 'company_id');
        if(empty($company_id) || (!is_numeric($company_id))) {
            return ajaxDataArr(0, null, '登陆状态已经失效。');
        }
        return ajaxDataArr(1, $userInfo, '');
    }
    /**
     * ajax保存数据
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_login(Request $request)
    {
       // $this->InitParams($request);
       // $company_id = $this->company_id;
        $account_username = Common::get($request, 'account_username');
        $account_password = Common::get($request, 'account_password');
        $preKey = Common::get($request, 'preKey');// 0 小程序 1农户后台
        if(!is_numeric($preKey)){
            $preKey = 1;
        }

        // 查询用户名是否有
        $queryParams = [
            'where' => [
                ['account_username',$account_username],
                ['account_password',md5($account_password)],
            ],
//            'orWhere' => [
//                ['mobile',$account_username],
//                ['account_password',md5($account_password)],
//            ],
            // 'limit' => 1
        ];
        $pageParams = [
            'page' =>1,
            'pagesize' => 1,
            'total' => 1,
        ];
        //$relations = "";
        //if($preKey == 0) {
            $relations = ['CompanyInfo.CompanyRank'];
        //}
        $resultDatas = $this->ajaxGetList($this->model_name, $pageParams, 0,$queryParams ,$relations, 1);
        $dataList = $resultDatas['dataList'] ?? [];
        $userInfo = $dataList[0] ?? [];
        if(empty($dataList) || count($dataList) <= 0 || empty($userInfo)) {
            // 查询手机号是否有
            $queryParams = [
                'where' => [
                    ['mobile', $account_username],
                    ['account_password', md5($account_password)],
                ]
                // 'limit' => 1
            ];
            $pageParams = [
                'page' => 1,
                'pagesize' => 1,
                'total' => 1,
            ];
            $resultDatas = $this->ajaxGetList($this->model_name, $pageParams, 0, $queryParams, $relations, 1);
            $dataList = $resultDatas['dataList'] ?? [];
            $userInfo = $dataList[0] ?? [];

            if(empty($dataList) || count($dataList) <= 0 || empty($userInfo)){
                return ajaxDataArr(0, null, '用户名或密码有误！');
            }
        }

        $account_id = $userInfo['id'] ?? 0;
        $account_status = $userInfo['account_status'] ?? 1;
        if($account_status != 0){
            return ajaxDataArr(0, null, '账号已冻结！');
        }
        //开始时间
        $company_vipbegin = $userInfo['company_info']['company_vipbegin'] ?? '';
        $company_vipbegin = judgeDate($company_vipbegin,"Y-m-d");
        if($company_vipbegin !== false) {
            $userInfo['company_info']['company_vipbegin'] = $company_vipbegin;
        }
        // 结束时间
        $company_vipend = $userInfo['company_info']['company_vipend'] ?? '';
        $company_vipend = judgeDate($company_vipend,"Y-m-d");
        if($company_vipend !== false) {
            $userInfo['company_info']['company_vipend'] = $company_vipend;
        }
        //更新上次登陆时间
        $company_id = $userInfo['company_id'] ??  0;
        $saveData = [
            'company_lastlogintime' => date('Y-m-d H:i:s',time()),
        ];
        $this->saveByIdApi('Company', $company_id, $saveData, $company_id, 1);

        $saveData = [
            'lastlogintime' => date('Y-m-d H:i:s',time()),
        ];
        $this->saveByIdApi('CompanyAccounts', $account_id, $saveData, $company_id, 1);


        // 获得管理的生产单元
        // 获得当前帐户管理的所有生产单元
        /*
        if($preKey == 0){
            // 'accountProUnits.companyProConfig.siteResources',
            $relations = ['accountProUnits.siteResources'];
        }else{
            $relations = ['accountProUnits'];
        }
        $resultDatas = $this->getinfoApi('CompanyAccounts', $relations, 0 , $account_id,1);

        $account_pro_units = $resultDatas['account_pro_units'] ?? [];
        $proUnits = [];
        foreach($account_pro_units as $v){
            $status = $v['status'] ?? 0;
            if($preKey == 1 && (! in_array($status,[1]))){// 后台
                continue;
            }elseif($preKey == 1 && (! in_array($status,[1]))){// 小程序 [0,1]
                continue;
            }
            $begin_time = $v['begin_time'] ?? '';
            $end_time = $v['end_time'] ?? '';
            //判断开始
            $begin_time_unix = judgeDate($begin_time);
            if($begin_time_unix === false){
                continue;
                // ajaxDataArr(0, null, '开如日期不是有效日期');
            }

            //判断期限结束
            $end_time_unix = judgeDate($end_time);
            if($end_time_unix === false){
                continue;
                // ajaxDataArr(0, null, '结束日期不是有效日期');
            }

            if($end_time_unix < $begin_time_unix){
                continue;
                // ajaxDataArr(0, null, '结束日期不能小于开始日期');
            }
             $time = time();
             if($end_time_unix < $time ){// 过期
                continue;
             }

            $tem = [
                'unit_id' => $v['id'],
                'pro_input_name' => $v['pro_input_name'],
                'status' => $v['status'],
                'status_text' => $v['status_text'],
                'begin_time' => judge_date($v['begin_time'],'Y-m-d'),
                'end_time' => judge_date($v['end_time'],'Y-m-d'),
            ];

            if($preKey == 0) {
                // $resource_url = $v['company_pro_config']['site_resources'][0]['resource_url'] ?? '';
                $resource_url = $v['site_resources'][0]['resource_url'] ?? '';
                $tem['resource_url'] = $resource_url;
                $this->resourceUrl($tem, 1);
            }
            $proUnits[$v['id']] = $tem;
        }
        */
        $proUnits = $this->getUnits($userInfo);
        $userInfo['proUnits'] = $proUnits;
        $userInfo['modifyTime'] = time();
        // 保存session
        // 存储数据到session...
        if (!session_id()) session_start(); // 初始化session
        // $_SESSION['userInfo'] = $userInfo; //保存某个session信息
        $redisKey = $this->setUserInfo($userInfo, $preKey);
        $userInfo['redisKey'] = $redisKey;
        return ajaxDataArr(1, $userInfo, '');
    }

    /**
     * ajax保存数据
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_pro_unit(Request $request)
    {
        $this->InitParams($request);
        $proUnits = $this->getUnits($this->user_info);
        return ajaxDataArr(1, $proUnits, '');
    }

    /**
     * ajax保存数据
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_login_out(Request $request)
    {
        $this->InitParams($request);
        // session_start(); // 初始化session
        //$userInfo = $_SESSION['userInfo'] ?? [];
        /*
        if(isset($_SESSION['userInfo'])){
            unset($_SESSION['userInfo']); //保存某个session信息
        }
        */
        $resDel = $this->delUserInfo();
        return ajaxDataArr(1, $resDel, '');
    }
    /**
     * ajax注册保存数据
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_reg(Request $request)
    {
        // 获得帮助单条信息
        $relations = '';
        $queryParams = [
            //'where' => [
            //    ['id',$this->user_id],
            //    ['account_password',md5($old_password)],
           // ],
            'select' => ['id','rank_name'],
            //'orderBy' => ['id'=>'desc'],
            // 'limit' => 1
        ];
        $rankInfoData = $this->getInfoByQuery('CompanyRank', 0,$queryParams,$relations,1);
        $company_rank_id = $rankInfoData['id'] ?? 0;
        // $this->InitParams($request);
        // $company_id = $this->company_id;
        $company_mobile = Common::get($request, 'company_mobile');
        $account_password = Common::get($request, 'account_password');
        $sure_password = Common::get($request, 'sure_password');
        $real_name = Common::get($request, 'real_name');
        $company_name = Common::get($request, 'company_name');
        $company_simple_name = Common::get($request, 'company_simple_name');
        $province_id = Common::get($request, 'province_id');
        $city_id = Common::get($request, 'city_id');
        $area_id = Common::get($request, 'area_id');
        $company_addr = Common::get($request, 'company_addr');

        if ($account_password != $sure_password){
            return ajaxDataArr(0, null, '密码和确定密码不一致！');
        }
        // 企业信息
        $saveCompanyData = [
            'company_name' => $company_name,// 公司名称
            'company_simple_name' => $company_simple_name,//
            'province_id' => $province_id,
            'city_id' => $city_id,
            'area_id' => $area_id,
            'company_rank_id'=>$company_rank_id,
            'company_linkman' => $real_name,// 联系人
            'company_mobile' => $company_mobile,// 手机
            'company_addr' => $company_addr,// 所在地址
            'company_vipbegin' => date("Y-m-d H:i:s",time()),
            'company_vipend' => date("Y-m-d H:i:s",strtotime("+2 month"))
        ];
        // 查询手机号是否已经有企业使用--账号表里查
        if($this->existMobile($company_mobile,0)){
            return ajaxDataArr(0, null, '手机号已存在！');
        }
        if($this->existUsername($company_mobile,0)){
            return ajaxDataArr(0, null, '手机号作为用户名已存在！');
        }

        // 添加企业信息
        $reslut = $this->createApi('Company',$saveCompanyData, 0, 1 );
        $company_id = $reslut['id'] ?? '';
        if(empty($company_id)){
            return ajaxDataArr(0, null, '注册失败，保存信息失败！');
        }
        $accountData = [
            'company_id' => $company_id,
            'account_username' => $company_mobile,
            'account_password' => $account_password,
            'account_issuper' => 1,
            'real_name' => $real_name,
            'mobile' => $company_mobile,
            // 'real_name' => substr_replace($company_mobile, '****', 3, 4),
        ];
        if(empty($real_name)){
            $accountData['real_name'] = substr_replace($company_mobile, '****', 3, 4);
        }
        $reslut = $this->createApi('CompanyAccounts',$accountData, 0, 1 );
        return ajaxDataArr(1, $reslut, '');

    }

    // 判断后机号是否已经存在 true:已存在;false：不存在
    public function existMobile($mobile, $id){
        $queryParams = [
            'where' => [
                ['mobile',$mobile],
            ],
            // 'limit' => 1
        ];
        if( is_numeric($id) && $id >0){
            array_push($queryParams['where'],['id', '<>' ,$id]);
        }

        $pageParams = [
            'page' =>1,
            'pagesize' => 1,
            'total' => 1,
        ];
        $resultDatas = $this->ajaxGetList('CompanyAccounts', $pageParams, 0,$queryParams ,'', 1);
        $dataList = $resultDatas['dataList'] ?? [];
        if(empty($dataList) || count($dataList)<=0){
            return false;
        }
        return true;
    }

    // 判断用户名是否已经存在 true:已存在;false：不存在
    public function existUsername($username, $id){
        $queryParams = [
            'where' => [
                ['account_username',$username],
            ],
            // 'limit' => 1
        ];
        if( is_numeric($id) && $id >0){
            array_push($queryParams['where'],['id', '<>' ,$id]);
        }

        $pageParams = [
            'page' =>1,
            'pagesize' => 1,
            'total' => 1,
        ];
        $resultDatas = $this->ajaxGetList('CompanyAccounts', $pageParams, 0,$queryParams ,'', 1);
        $dataList = $resultDatas['dataList'] ?? [];
        if(empty($dataList) || count($dataList)<=0){
            return false;
        }
        return true;
    }
}
