<?php

namespace App\Http\Controllers;

use App\Services\Common;
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

        // 修改点击点
        $id = $resultDatas['id'] ??  0;
        $hits = $resultDatas['hits'] ??  0;
        $saveData = [
            'hits' => $hits + 1,
        ];
        $this->saveByIdApi($model_name, $id, $saveData, $this->company_id);

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
        // 获得列表
        $relations = '';// 关系
        $queryParams = [
            //'where' => [
            //    ['company_id', $this->company_id],
            //],
            'select' => ['id','intro_title','hits','created_at'],
            'orderBy' => ['intro_sort'=>'desc','id'=>'desc'],
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
            if($total > 0) $pagesize = $total;
        }
        // 处理图片地址
        // $this->resoursceUrl($resultDatas);
        $totalPage = ceil($total/$pagesize);
        /*
        $data_list = [];
        foreach($resultDatas as $v){
            $data_list[] = [
                'id' => $v['id'] ,
                'resource_id' => $v['resource_id'] ,
                'resource_url' => $v['site_resources'][0]['resource_url'] ?? '' ,
                'resource_name' => $v['site_resources'][0]['resource_name'] ?? '' ,
                'resource_note' => $v['site_resources'][0]['resource_note'] ?? '' ,
                'created_at' => $v['created_at'],
            ];
        }
        */

        $result = array(
            'has_page'=> $totalPage > $page,
            'data_list'=>$resultDatas,//array(),//数据二维数组
            'total'=>$total,//总记录数 0:每次都会重新获取总数 ;$total :则>0总数据不会重新获取[除第一页]
            //'pageInfo' => showPage($totalPage,$page,$total,12,1),
        );
        if($this->save_session){
            $result['pageInfo'] = showPage($totalPage,$page,$total,12,1);
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
    public function ajax_alist_site_inputs(Request $request){
        $this->InitParams($request);

        // 获得翻页的三个关键参数
        $pageParams = Common::getPageParams($request);
        list($page, $pagesize, $total) = array_values($pageParams);
        // 获得列表
        $relations = '';// 关系
        $queryParams = [
            //'where' => [
            //    ['company_id', $this->company_id],
            //],
            // 'select' => ['id','intro_title','hits','created_at'],
            'orderBy' => ['pro_input_sort'=>'desc','id'=>'desc'],
        ];// 查询条件参数
        $result = $this->ajaxGetAllList('SiteProInput', '', $this->company_id,$queryParams ,$relations );

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
        // 处理图片地址
        // $this->resoursceUrl($resultDatas);
        $totalPage = ceil($total/$pagesize);
        /*
        $data_list = [];
        foreach($resultDatas as $v){
            $data_list[] = [
                'id' => $v['id'] ,
                'resource_id' => $v['resource_id'] ,
                'resource_url' => $v['site_resources'][0]['resource_url'] ?? '' ,
                'resource_name' => $v['site_resources'][0]['resource_name'] ?? '' ,
                'resource_note' => $v['site_resources'][0]['resource_note'] ?? '' ,
                'created_at' => $v['created_at'],
            ];
        }
        */

        $result = array(
            'has_page'=> $totalPage > $page,
            'data_list'=>$resultDatas,//array(),//数据二维数组
            'total'=>$total,//总记录数 0:每次都会重新获取总数 ;$total :则>0总数据不会重新获取[除第一页]
            //'pageInfo' => showPage($totalPage,$page,$total,12,1),
        );
        if($this->save_session){
            $result['pageInfo'] = showPage($totalPage,$page,$total,12,1);
        }
        return ajaxDataArr(1, $result, '');
    }
    /**
     * 帮助中心
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_info(Request $request)
    {
        // $this->InitParams($request);
        $id = Common::getInt($request, 'id');
        if($id <= 0){
            throws('参数[id]有误！', $this->source);
        }
        // 获得帮助单条信息
        $relations = '';
        //$intro_id = 5;
        $model_name = 'SiteIntro';
        $company_id = 0;//$this->company_id;
        $infoData = $this->getinfoApi($model_name, $relations, $company_id , $id,1);
        if(is_null($infoData['intro_content'])){
            $infoData['intro_content'] = '';
        }
        // 修改点击点
        $id = $infoData['id'] ??  0;
        $hits = $infoData['hits'] ??  0;
        $saveData = [
            'hits' => $hits + 1,
        ];
        $this->saveByIdApi($model_name, $id, $saveData, $company_id,1);

        return ajaxDataArr(1, $infoData, '');
    }
}
