<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Egulias\EmailValidator\Warning\Comment;
use Illuminate\Http\Request;

class CommentController extends LoginController
{
    protected $model_name = 'CompanyProComment';

    /**
     * 用户反馈
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request,$pro_unit_id)
    {
        $this->InitParams($request);
        return view('comment.index',['pro_unit_id' => $pro_unit_id]);
    }


    /**
     * ajax获得列表数据
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_alist(Request $request,$pro_unit_id){
        $this->InitParams($request);

        // 获得翻页的三个关键参数
        $pageParams = Common::getPageParams($request);
        list($page, $pagesize, $total) = array_values($pageParams);
        $queryParams = [
            'where' => [
                ['company_id', $this->company_id],
                ['pro_unit_id', $pro_unit_id],
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
            if($total > 0) $pagesize = $total;
        }

        $totalPage = ceil($total/$pagesize);
        $data_list = [];
        foreach($resultDatas as $v){
            $data_list[] = [
                'id' => $v['id'] ,
                'comment_mobile' => $v['comment_mobile'],
                'comment_content' => $v['comment_content'],
                'status' => $v['status'],
                'status_text' => $v['status_text'],
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
     * 子帐号管理-删除
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_del(Request $request,$pro_unit_id)
    {
        $this->InitParams($request);
        $id = Common::getInt($request, 'id');
        $queryParams =[// 查询条件参数
            'where' => [
                ['id', $id],
                ['company_id', $this->company_id],
                ['pro_unit_id', $pro_unit_id],
            ]
        ];

        // 判断权限
        $judgeData = [
            'company_id' => $this->company_id,
            'pro_unit_id' => $pro_unit_id,
        ];
        $relations = '';
        $this->judgePower($request, $id,$judgeData,$this->model_name, $this->company_id,$relations);


        $resultDatas = $this->ajaxDelApi($this->model_name, $this->company_id , $queryParams);

        return ajaxDataArr(1, $resultDatas, '');
    }

    /**
     * 审核通过/未通过
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_status(Request $request,$pro_unit_id)
    {
        $this->InitParams($request);
        $id = Common::getInt($request, 'id');
        $status = Common::getInt($request, 'status');
        if(!in_array($status,[1,2])){
            return ajaxDataArr(0, null, '状态值有误');
        }

        // 判断权限
        $judgeData = [
            'company_id' => $this->company_id,
            'pro_unit_id' => $pro_unit_id,
        ];
        $relations = '';
        $this->judgePower($request, $id,$judgeData,$this->model_name, $this->company_id,$relations);

        $queryParams =[// 查询条件参数
            'where' => [
                ['id', $id],
                ['company_id', $this->company_id],
                ['pro_unit_id', $pro_unit_id],
                ['status', 0],
            ]
        ];
        $resultDatas =  $this->ModifyByQueyApi($this->model_name, ['status'=> $status], $queryParams, $this->company_id, 0);

        return ajaxDataArr(1, $resultDatas, '');
    }

}
