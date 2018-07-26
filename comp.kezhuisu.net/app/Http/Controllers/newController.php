<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Illuminate\Http\Request;

class newController extends LoginController
{
    protected $model_name = 'SiteNews';

    /**
     * 公告
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function newList(Request $request)
    {
        $this->InitParams($request);
        // 获得帮助单条信息
        $relations = '';
        //$intro_id = 5;
        $model_name = 'SiteNews';

        $relations = '';// 关系
        $queryParams = '';
        $dataList = $this->ajaxGetAllList($model_name, '', $this->company_id,$queryParams ,'' );
        return view('new.list',['dataList' => $dataList]);
    }

    /**
     * 公告-详情
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function info(Request $request,$id)
    {
        $this->InitParams($request);
        // 获得帮助单条信息
        $relations = '';
        //$intro_id = 5;
        $model_name = $this->model_name;
        $resultDatas = $this->getinfoApi($model_name, $relations, $this->company_id , $id,0);
        return view('new.help',$resultDatas);
    }

    /**
     *
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {

        $this->InitParams($request);
        return view('new.index');
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
//            'where' => [
//                ['company_id', $this->company_id],
//                ['pro_unit_id', $pro_unit_id],
//            ],
            'select' => ['id','new_title','new_source','volume','created_at'],
            'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数
        $relations = '';// 关系
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

        $result = array(
            'data_list'=>$resultDatas,//array(),//数据二维数组
            'total'=>$total,//总记录数 0:每次都会重新获取总数 ;$total :则>0总数据不会重新获取[除第一页]
            'pageInfo' => showPage($totalPage,$page,$total,12,1),
        );
        return ajaxDataArr(1, $result, '');
    }

    /**
     * ajax获得列表数据
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_test(Request $request){
        // $this->InitParams($request);

        // 获得翻页的三个关键参数
        $pageParams = Common::getPageParams($request);

        list($page, $pagesize, $total) = array_values($pageParams);

        $queryParams = [
//            'where' => [
//                ['company_id', $this->company_id],
//                ['pro_unit_id', $pro_unit_id],
//            ],
            'select' => ['id','new_title','new_source','volume','created_at'],
            'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数
        $relations = '';// 关系
        $result = $this->ajaxGetList($this->model_name, $pageParams, $this->company_id,$queryParams ,$relations,1);
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

        $result = array(
            'data_list'=>$resultDatas,//array(),//数据二维数组
            'total'=>$total,//总记录数 0:每次都会重新获取总数 ;$total :则>0总数据不会重新获取[除第一页]
            'pageInfo' => showPage($totalPage,$page,$total,12,1),
        );
        return ajaxDataArr(1, $result, '');
    }

}