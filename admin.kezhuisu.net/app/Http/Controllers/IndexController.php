<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Illuminate\Http\Request;

class IndexController extends LoginController
{
    protected $model_name = 'SiteAdmin';

    /**
     * 登陆
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function test(Request $request)
    {
        return view('test');
    }

    /**
     * 登陆
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function login(Request $request)
    {
        return view('login');
    }

    /**
     * 生成二维码
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function qrcode(Request $request)
    {
        $url = Common::get($request, 'url');
        if(empty($url)){
            throws('参数url有误!');
        }
        $url = urldecode($url);
        return view('qrcode',['url' => $url]);
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
        $admin_username = Common::get($request, 'admin_username');
        $admin_password = Common::get($request, 'admin_password');
        $queryParams = [
            'where' => [
                ['admin_username',$admin_username],
                ['admin_password',md5($admin_password)],
            ]
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
//        $company_id = $userInfo['company_id'] ??  0;
//        $saveData = [
//            'company_lastlogintime' => date('Y-m-d H:i:s',time()),
//        ];
//        $this->saveByIdApi('Company', $company_id, $saveData, $company_id, 1);


        // 获得管理的生产单元
//        // 获得当前帐户管理的所有生产单元
//        $account_id = $userInfo['id'] ?? 0;
//        $relations = ['accountProUnits'];
//        $resultDatas = $this->getinfoApi('CompanyAccounts', $relations, 0 , $account_id,1);
//        $account_pro_units = $resultDatas['account_pro_units'] ?? [];
//        $proUnits = [];
//        foreach($account_pro_units as $v){
//            $proUnits[$v['id']] = [
//                'unit_id' => $v['id'],
//                'pro_input_name' => $v['pro_input_name'],
//            ];
//        }
//        $userInfo['proUnits'] = $proUnits;
        // 保存session
        // 存储数据到session...
        session_start(); // 初始化session
        $_SESSION['userInfo'] = $userInfo; //保存某个session信息
        return ajaxDataArr(1, $userInfo, '');
    }

    /**
     * 首页
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);

        return view('index');
    }


    /**
     * 注销
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function logout(Request $request)
    {
        $this->InitParams($request);
        if(isset($_SESSION['userInfo'])){
            unset($_SESSION['userInfo']); //保存某个session信息
        }
        return redirect('/login');
    }

}
