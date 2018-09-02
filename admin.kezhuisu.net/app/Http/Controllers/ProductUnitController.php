<?php

namespace App\Http\Controllers;

use App\Services\Common;
use App\Services\HttpRequest;
use App\Services\Tool;
use Illuminate\Http\Request;

class ProductUnitController extends LoginController
{
    protected $model_name = 'CompanyProUnit';
    /**
     * 生产单元
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);
        return view('productunit.index');
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
        $status = Common::get($request, 'status');
        $pro_input_name = Common::get($request, 'pro_input_name');
        $queryParams = [
            'where' => [
                //  ['company_id', $this->company_id],
            ],
            'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数

        if(!empty($pro_input_name)){
            array_push($queryParams['where'],['pro_input_name', 'like' , '%' . $pro_input_name . '%']);
        }
        if(is_numeric($status) && in_array($status,[0,1,2])){
            array_push($queryParams['where'],['status', $status]);
        }
        if($status == 3){
            array_push($queryParams['where'],['end_time', '<' , date('Y-m-d',time())]);
        }
        if($status == 1){
            array_push($queryParams['where'],['end_time', '>=' , date('Y-m-d',time())]);
        }

        $relations = ['siteResources','CompanyInfo','firstSiteUnit','secondSiteUnit'];// 关系
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
        // $this->resoursceUrl($resultDatas);
        $totalPage = ceil($total/$pagesize);
        $data_list = [];
        $unit_ids = array_column($resultDatas, 'id');
        $labelCounts = [];
        if (count($unit_ids) > 0) {
            $url = config('public.apiUrl') . config('public.apiPath.countLabels');
            $requestData = [
                'company_id' => $this->company_id,
                'unitIds' => $unit_ids,
            ];
            // 生成带参数的测试get请求
            // echo $requestTesUrl = splicQuestAPI($url , $requestData); die;
            $labelCounts = HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');

        }
        foreach($resultDatas as $k=>$v){
            $first_site_unit = $v['first_site_unit']['pro_unit_name'] ?? '';
            $second_site_unit = $v['second_site_unit']['pro_unit_name'] ?? '';

            $temBeginTime = judgeDate($v['begin_time'],'Y-m-d');
            $temEndTime = judgeDate($v['end_time'],'Y-m-d');
            if($temEndTime === false){
                $temEndTime =  '';
            }
            $data_list[] = [
                'id' => $v['id'],
                'site_unit_name' => $first_site_unit . '/' .  $second_site_unit,
                'company_id' => $v['company_id'],
                'company_name' => $v['company_info']['company_name'] ?? '',
                //'site_unit_name' => $v['site_pro_unit']['pro_unit_name'] ?? '',
                'pic_url' => isset($v['site_resources'][0]['resource_url']) ? url($v['site_resources'][0]['resource_url']) : '',
                'begin_time' =>$temBeginTime,
                'end_time' => $temEndTime,
                'created_at' => $v['created_at'],
                'pro_input_name' => $v['pro_input_name'],
                'status' => $v['status'],
                'status_text' => $v['status_text'],
                'weburl' => config('public.tinyWebURL') . $v['id'],
                'label_count' => $labelCounts[$v['id']] ?? 0,
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
//        $judgeData = [
//            //'company_id' => $this->company_id,
//            //'pro_unit_id' => $pro_unit_id,
//        ];
//        $relations = '';
//        $infoData = $this->judgePower($request, $id,$judgeData,$this->model_name, $this->company_id,$relations);
//        $resources = $infoData['site_resources'] ?? [];
//        $this->resourceDelFile($resources);// 删除资源
//        // 无删除移除关系表--注意要先删除关系
//        $detachParams =[
//            'siteResources' => [],//相关维护人员
//        ];
//        $detachDatas = $this->detachByIdApi($this->model_name, $id, $detachParams, $this->company_id);

        $queryParams =[// 查询条件参数
            'where' => [
                ['id', $id],
                //   ['company_id', $this->company_id],
            ]
        ];

        $resultDatas = $this->ajaxDelApi($this->model_name, $this->company_id , $queryParams);

//        $resluts = [
//            'resData' =>   $resultDatas,
//            'detachDatas' =>   $detachDatas,
//        ];
        return ajaxDataArr(1, $resultDatas, '');
    }

    /**
     * 审核通过/未通过
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_status(Request $request)
    {
        $this->InitParams($request);
        $id = Common::getInt($request, 'id');
        $status = Common::getInt($request, 'status');
        if(!in_array($status,[1,2])){
            return ajaxDataArr(0, null, '状态值有误');
        }

        // 判断权限
//        $judgeData = [
//            'company_id' => $this->company_id,
//            // 'pro_unit_id' => $pro_unit_id,
//        ];
//        $relations = '';
//        $this->judgePower($request, $id,$judgeData,$this->model_name, $this->company_id,$relations);

        $queryParams =[// 查询条件参数
            'where' => [
                ['id', $id],
                //['company_id', $this->company_id],
                //['pro_unit_id', $pro_unit_id],
                ['status', 0],
            ]
        ];
        $resultDatas =  $this->ModifyByQueyApi($this->model_name, ['status'=> $status], $queryParams, $this->company_id, 0);

        return ajaxDataArr(1, $resultDatas, '');
    }


    /**
     * 生成防伪标签页面地址
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_create_label(Request $request)
    {
        ini_set('memory_limit','3072M');    // 临时设置最大内存占用为3G
        set_time_limit(0);   // 设置脚本最大执行时间 为0 永不过期
        $this->InitParams($request);
        $id = Common::getInt($request, 'id');
        // 新加用户
        $url = config('public.apiUrl') . config('public.apiPath.create_label');
        $requestData = [
            'pro_unit_id' => $id,
        ];

        // 生成带参数的测试get请求
        // echo $requestTesUrl = splicQuestAPI($url , $requestData); die;
        $resultDatas = HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
        return ajaxDataArr(1, $resultDatas, '');
    }
}
