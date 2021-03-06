<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Illuminate\Http\Request;

class NewsController extends LoginController
{
    protected $model_name = 'SiteNews';

    /**
     * 新闻
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);
        return view('news.index');
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
        return view('news.edit',$resultDatas);
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
            if($total > 0) $pagesize = $total;
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
        $new_title = Common::get($request, 'new_title');
        $volume = Common::getInt($request, 'volume');
        $new_source = Common::get($request, 'new_source');
        $new_content = Common::get($request, 'new_content');
        $new_content = stripslashes($new_content);

        $saveData = [
            'new_title' => $new_title,
            'new_content' => $new_content,
            'volume' => $volume,
            'new_source' => $new_source,
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
            ]
        ];

        $resultDatas = $this->ajaxDelApi($this->model_name, $this->company_id , $queryParams);
        return ajaxDataArr(1, $resultDatas, '');
    }

}
