<?php

namespace App\Http\Controllers;

use App\Services\Common;
use App\Services\HttpRequest;
use Illuminate\Http\Request;

class SysController extends LoginController
{
    protected $model_name = 'SiteConfig';

    /**
     * 系统基本设置
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);
        // 获得翻页的三个关键参数
        $pageParams = Common::getPageParams($request);

        list($page, $pagesize, $total) = array_values($pageParams);
        // 读取设置

        $queryParams = [
//            'where' => [
//                ['company_id', $this->company_id],
//            ],
//            'orderBy' => ['id'=>'desc'],
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
            $pagesize = $total;
        }
        return view('sys.index',['dataList' => $resultDatas]);
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
        // 攻得所有的记录

        $queryParams = [
//            'where' => [
//                ['company_id', $this->company_id],
//            ],
//            'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数
        $relations = '';// 关系
        $result = $this->ajaxGetAllList($this->model_name, '', $this->company_id,$queryParams ,$relations );
        $resultDatas = $result;

        $params = $request->all();
        $saveData = [];
        foreach($resultDatas as $v){
            $id =$v['id'] ?? '';
            if(!is_numeric($id)){
                continue;
            }
            if( (!isset($params['name' . $id][0])) ||  $params['name' . $id][0] != $id){
                continue;
            }
            $saveData[] = [
                'id' => $id,
                'site_val' => $params['name' . $id][1] ?? '',
            ];
        }

        $resluts = "";
        if ( ! empty($saveData)) {
            $resluts = $this->saveBathById($this->model_name, $saveData, 'id', $this->company_id);
        }

        return ajaxDataArr(1, $resluts, '');
    }

}
