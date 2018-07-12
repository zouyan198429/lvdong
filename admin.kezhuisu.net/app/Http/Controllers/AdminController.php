<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Illuminate\Http\Request;

class AdminController extends LoginController
{
    protected $model_name = 'SiteAdmin';
    protected $admin_types = [
        '0' => '客服',
        '1' => '管理员',
        '2' => '超级管理员',
    ];
    /**
     * 管理员
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);
        return view('admin.index');
    }

    /**
     * 管理员-修改
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function edit(Request $request, $id)
    {
        $this->InitParams($request);
        $resultDatas = [
            'id'=>$id,
        ];
        if ($id > 0) { // 获得详情数据
            $relations = '';
            $resultDatas = $this->getinfoApi($this->model_name, $relations, $this->company_id , $id);
            // 判断权限
//            $judgeData = [
//                'company_id' => $this->company_id,
//            ];
//            $this->judgePowerByObj($request,$resultDatas, $judgeData );
        }
        $resultDatas['admin_types'] = $this->admin_types;
        return view('admin.edit',$resultDatas);
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
                //  ['company_id', $this->company_id],
            ],
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
        // 处理图片地址
        $this->resoursceUrl($resultDatas);
        $totalPage = ceil($total/$pagesize);
        /*
        $data_list = [];
        foreach($resultDatas as $v){
            $data_list[] = [
                'id' => $v['id'] ,
                'company_name' => $v['company_info']['company_name'] ?? '',//  企业名称
                'resource_url' => $v['site_resources'][0]['resource_url'] ?? '' ,
                'resource_name' => $v['site_resources'][0]['resource_name'] ?? '' ,
                'created_at' => $v['created_at'],
            ];
        }
        */

        $result = array(
            'data_list'=>$resultDatas,//array(),//数据二维数组
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
        $admin_type = Common::getInt($request, 'admin_type');
        $admin_username = Common::get($request, 'admin_username');
        $admin_password = Common::get($request, 'admin_password');
        $sure_password = Common::get($request, 'sure_password');
        $real_name = Common::get($request, 'real_name');

        if($this->existUsername($admin_username,$id)){
            return ajaxDataArr(0, null, '用户名已存在！');
        }

        $saveData = [
            'admin_type' => $admin_type,
            'admin_username' => $admin_username,
            'real_name' => $real_name,
        ];
        if($admin_password != '' || $sure_password != ''){
            if ($admin_password != $sure_password){
                return ajaxDataArr(0, null, '密码和确定密码不一致！');
            }
            $saveData['admin_password'] = $admin_password;
        }

        if($id <= 0){// 新加
            $resultDatas = $this->createApi($this->model_name,$saveData,$company_id);
            $id = $resultDatas['id'] ?? 0;
        }else{// 修改
            $resultDatas = $this->saveByIdApi($this->model_name, $id, $saveData, $company_id, 0);
        }
        return ajaxDataArr(1, $resultDatas, '');
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
        $judgeData = [
            'id' => $id,
        ];
        $relations = '';
        $info = $this->judgePower($request, $id,$judgeData,$this->model_name, $this->company_id,$relations);
        $admin_type = $info['admin_type'] ?? 2;
        if($admin_type == 2){
            return ajaxDataArr(0, null, '超级管理员不能删除！');
        }
        $queryParams =[// 查询条件参数
            'where' => [
                ['id', $id],
                //   ['company_id', $this->company_id],
            ]
        ];

        $resultDatas = $this->ajaxDelApi($this->model_name, $this->company_id , $queryParams);
        return ajaxDataArr(1, $resultDatas, '');
    }

    // 判断用户名是否已经存在 true:已存在;false：不存在
    public function existUsername($username, $id){
        $queryParams = [
            'where' => [
                ['admin_username',$username],
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
        $resultDatas = $this->ajaxGetList($this->model_name, $pageParams, 0,$queryParams ,'', 1);
        $dataList = $resultDatas['dataList'] ?? [];
        if(empty($dataList) || count($dataList)<=0){
            return false;
        }
        return true;
    }
}
