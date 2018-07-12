<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SysController extends LoginController
{
    protected $model_name = 'SiteIntro';
    /**
     * 资料设置
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
//    public function index(Request $request)
//    {
//        $this->InitParams($request);
//        return view('sys.index');
//    }

    /**
     * 在线支付
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function pay(Request $request)
    {
        $this->InitParams($request);
        return view('sys.pay');
    }

    /**
     * 帮助中心
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function helpList(Request $request)
    {
        $this->InitParams($request);
        // 获得帮助单条信息
        $relations = '';
        //$intro_id = 5;
        $model_name = 'SiteIntro';

        $relations = '';// 关系
        $queryParams = '';
        $dataList = $this->ajaxGetAllList($model_name, '', $this->company_id,$queryParams ,'' );
        return view('sys.list',['dataList' => $dataList]);
    }

    /**
     * 帮助中心
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function help(Request $request,$intro_id)
    {
        $this->InitParams($request);
        // 获得帮助单条信息
        $relations = '';
        //$intro_id = 5;
        $model_name = 'SiteIntro';
        $resultDatas = $this->getinfoApi($model_name, $relations, $this->company_id , $intro_id,0);
        return view('sys.help',$resultDatas);
    }

    /**
     * 关于我们
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function aboutus(Request $request)
    {
        $this->InitParams($request);
        return view('sys.aboutus');
    }

    /**
     * 服务协议
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function policy(Request $request)
    {
        $this->InitParams($request);
        return view('sys.policy');
    }

    /**
     * 法律声明
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function legalnotice(Request $request)
    {
        $this->InitParams($request);
        return view('sys.legalnotice');
    }

}
