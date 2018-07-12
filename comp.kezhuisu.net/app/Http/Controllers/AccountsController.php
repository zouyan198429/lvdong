<?php

namespace App\Http\Controllers;

use App\Services\Common;
use App\Services\HttpRequest;
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
        $mobile = Common::getInt($request, 'mobile');
        $remarks = Common::get($request, 'remarks');
        $remarks =  replace_special_char($remarks,2);
        $remarks =  replace_enter_char($remarks,2);
        if ($account_password != $sure_password){
            return ajaxDataArr(0, null, '密码和确定密码不一致！');
        }
        // 查询手机号是否已经有企业使用--账号表里查
        if($this->existMobile($mobile,$id)){
            return ajaxDataArr(0, null, '手机号已存在！');
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
        $userInfo = $_SESSION['userInfo']?? [];
        $userInfo = array_merge($userInfo, $saveData);
        $_SESSION['userInfo'] = $userInfo;

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
    public function ajax_login(Request $request)
    {
       // $this->InitParams($request);
       // $company_id = $this->company_id;
        $account_username = Common::get($request, 'account_username');
        $account_password = Common::get($request, 'account_password');
        $queryParams = [
            'where' => [
                ['account_username',$account_username],
                ['account_password',md5($account_password)],
            ],
            'orWhere' => [
                ['mobile',$account_username],
                ['account_password',md5($account_password)],
            ],
            // 'limit' => 1
        ];
        $pageParams = [
            'page' =>1,
            'pagesize' => 1,
            'total' => 1,
        ];
        $resultDatas = $this->ajaxGetList($this->model_name, $pageParams, 0,$queryParams ,'', 1);
        $dataList = $resultDatas['dataList'] ?? [];
        $userInfo = $dataList[0] ?? [];
        if(empty($dataList) || count($dataList) <= 0 || empty($userInfo)){
            return ajaxDataArr(0, null, '用户名或密码有误！');
        }

        //更新上次登陆时间
        $company_id = $userInfo['company_id'] ??  0;
        $saveData = [
            'company_lastlogintime' => date('Y-m-d H:i:s',time()),
        ];
        $this->saveByIdApi('Company', $company_id, $saveData, $company_id, 1);


        // 获得管理的生产单元
        // 获得当前帐户管理的所有生产单元
        $account_id = $userInfo['id'] ?? 0;
        $relations = ['accountProUnits'];
        $resultDatas = $this->getinfoApi('CompanyAccounts', $relations, 0 , $account_id,1);
        $account_pro_units = $resultDatas['account_pro_units'] ?? [];
        $proUnits = [];
        foreach($account_pro_units as $v){
            $proUnits[$v['id']] = [
                'unit_id' => $v['id'],
                'pro_input_name' => $v['pro_input_name'],
            ];
        }
        $userInfo['proUnits'] = $proUnits;
        // 保存session
        // 存储数据到session...
        session_start(); // 初始化session
        $_SESSION['userInfo'] = $userInfo; //保存某个session信息
        return ajaxDataArr(1, $userInfo, '');
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
        // $this->InitParams($request);
        // $company_id = $this->company_id;
        $company_mobile = Common::get($request, 'company_mobile');
        $account_password = Common::get($request, 'account_password');
        $sure_password = Common::get($request, 'sure_password');
        $real_name = Common::get($request, 'real_name');
        $company_name = Common::get($request, 'company_name');
        $company_addr = Common::get($request, 'company_addr');

        if ($account_password != $sure_password){
            return ajaxDataArr(0, null, '密码和确定密码不一致！');
        }
        // 企业信息
        $saveCompanyData = [
            'company_name' => $company_name,// 公司名称
            'company_linkman' => $real_name,// 联系人
            'company_mobile' => $company_mobile,// 手机
            'company_addr' => $company_addr,// 所在地址
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
        ];
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