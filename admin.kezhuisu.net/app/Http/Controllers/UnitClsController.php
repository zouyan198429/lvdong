<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Illuminate\Http\Request;

class UnitClsController extends LoginController
{
    protected $model_name = 'SiteProUnit';

    /**
     * 生产投入品分类
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);
        return view('unitcls.index');
    }

    /**
     * 新闻-修改
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
            'pro_unit_parent_id' => 0,
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
        // 获得第一级分类
        $relations = '';// 关系
        $queryParams = [
            'where' => [
                ['pro_unit_parent_id', 0],
//                ['pro_unit_id', $pro_unit_id],
            ],
            'select' => ['id','pro_unit_name'],
            //'orderBy' => ['area_id'=>'asc'],
        ];// 查询条件参数
        $prantList = $this->ajaxGetAllList($this->model_name, '', $this->company_id,$queryParams ,$relations);
        $resultDatas['parents'] = $prantList;
        return view('unitcls.edit',$resultDatas);
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
//            ],
            'orderBy' => ['pro_unit_order'=>'desc','id'=>'asc'],
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
        // 处理图片地址
        // $this->resoursceUrl($resultDatas);
        $totalPage = ceil($total/$pagesize);
        $format_data_list = [];
        foreach($resultDatas as $v){
            $pro_unit_parent_id = $v['pro_unit_parent_id'];
            if($pro_unit_parent_id > 0 ){
                $v['pro_unit_name'] = '|________' . $v['pro_unit_name'];
            }
            $format_data_list[$v['pro_unit_parent_id']][] = $v;
        }
        $first_list = $format_data_list[0] ?? [];
        $data_list = [];
        foreach($first_list as $v){
            $data_list[] = $v;
            $id = $v['id'];
            $tem_arr = $format_data_list[$id] ?? [];
            if(empty($tem_arr)){
                continue;
            }
            $data_list = array_merge($data_list, $tem_arr);

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
        $pro_unit_name = Common::get($request, 'pro_unit_name');
        $pro_unit_order = Common::getInt($request, 'pro_unit_order');
        $pro_unit_parent_id = Common::getInt($request, 'pro_unit_parent_id');

        $saveData = [
            'pro_unit_name' => $pro_unit_name,
            'pro_unit_parent_id' => $pro_unit_parent_id,
            'pro_unit_order' => $pro_unit_order,
        ];
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

        $queryParams =[// 查询条件参数
            'where' => [
                ['id', $id],
                //   ['company_id', $this->company_id],
            ],
            'orWhere' => [
                ['pro_unit_parent_id',$id],
             //    ['account_password',md5($account_password)],
            ],
        ];

        $resultDatas = $this->ajaxDelApi($this->model_name, $this->company_id , $queryParams);
        return ajaxDataArr(1, $resultDatas, '');
    }

}
