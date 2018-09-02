<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Illuminate\Http\Request;

class SecurityLabelController extends LoginController
{
    protected $model_name = 'CompanyProSecurityLabel';

    /**
     * 防伪标签
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request,$pro_unit_id)
    {
        $this->InitParams($request);
        return view('security_label.index',['pro_unit_id' => $pro_unit_id]);
    }

    public function test(Request $request){

        return view('test');
    }

    /**
     * 生防伪标签-添加
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function add(Request $request,$pro_unit_id,$id)
    {
        $this->InitParams($request);
        $resultDatas = [
            'id'=>$id,
            'pro_unit_id' => $pro_unit_id,
            'status' => -1,

        ];

        if ($id > 0) { // 获得详情数据
            $relations = '';
            $resultDatas = $this->getinfoApi($this->model_name, $relations, $this->company_id , $id);
            // 判断权限
            $judgeData = [
                'company_id' => $this->company_id,
                'pro_unit_id' => $pro_unit_id,
            ];
            $this->judgePowerByObj($request,$resultDatas, $judgeData );
        }
        return view('security_label.add',$resultDatas);
    }

    /**
     * ajax获得列表数据
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_alllist(Request $request,$pro_unit_id){
        $this->InitParams($request);

        // 获得翻页的三个关键参数
        $pageParams = Common::getPageParams($request);
        list($page, $pagesize, $total) = array_values($pageParams);
        // 获得列表
        $relations = '';//['proUnit'];// 关系
        $queryParams = [
            'where' => [
                ['company_id', $this->company_id],
                ['pro_unit_id', $pro_unit_id],
            ],
            'select' => ['id','security_label_num'],
            'orderBy' => ['id'=>'desc'],
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
        $totalPage = ceil($total/$pagesize);
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
    public function ajax_alist(Request $request,$pro_unit_id){
        $this->InitParams($request);

        // 获得翻页的三个关键参数
        $pageParams = Common::getPageParams($request);
        list($page, $pagesize, $total) = array_values($pageParams);
        $pagesize = 500;
        $pageParams['pagesize'] = $pagesize;

        $queryParams = [
            'where' => [
                ['company_id', $this->company_id],
                ['pro_unit_id', $pro_unit_id],
            ],
            'select' => ['id','security_label_num'],
            'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数
        $relations = '';//['proUnit'];// 关系
        //$result = $this->ajaxGetList($this->model_name, $pageParams, $this->company_id,$queryParams ,$relations);
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
            if($total > 0) $pagesize = $total;
        }
        $totalPage = ceil($total/$pagesize);
//        foreach($resultDatas as $k=>$v){
//            $resultDatas[$k]['pro_unit_name'] = $resultDatas[$k]['pro_unit']['pro_input_name']??'';
//        }

        $result = array(
            'data_list'=>$resultDatas,//array(),//数据二维数组
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

        // 判断权限
        $judgeData = [
            'company_id' => $this->company_id,
            'pro_unit_id' => $pro_unit_id,
        ];
        $relations = '';
        $infoData = $this->judgePower($request, $id,$judgeData,$this->model_name, $this->company_id,$relations);

        $queryParams =[// 查询条件参数
            'where' => [
                ['id', $id],
                ['company_id', $this->company_id],
                ['pro_unit_id', $pro_unit_id],
            ]
        ];
        $resultDatas = $this->ajaxDelApi($this->model_name, $this->company_id , $queryParams);

        $resluts = [
            'resData' =>   $resultDatas,
        ];
        return ajaxDataArr(1, $resluts, '');
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
        $pro_unit_id = Common::getInt($request, 'pro_unit_id');
        Common::judgeInitParams($request, 'pro_unit_id', $pro_unit_id);
        // Common::judgeEmptyParams($request, 'id', $id);
        $company_id = $this->company_id;
        $status = Common::get($request, 'status');
        if (!is_numeric($status)){
            return ajaxDataArr(0, null, '请选择状态！');
        }
        $security_label_num = Common::get($request, 'security_label_num');
        $security_label_num =  replace_enter_char($security_label_num,1);
        $label_num_arr = explode('<br/>',$security_label_num);
        $label_num_ok_arr = [];
        foreach($label_num_arr as $k => $v){
            $v = trim($v);
            if(empty($v)){
                unset($label_num_arr[$k]);
                continue;
            }
            if( strlen($v) < 10  || strlen($v) > 30){
                return ajaxDataArr(0, null, '防伪标签[' . $v . '] 长度必须>=10且<=30！请处理后再提交！');
            }
            // 判断是否已经存在
            if($this->existLabel($company_id,$pro_unit_id,$v, $id)){
                return ajaxDataArr(0, null, '防伪标签[' . $v . '] 已经存在！请处理后再提交！');
            }
            $label_num_ok_arr[$v] = $v;// 排重的作用

        }
        if(count($label_num_ok_arr) <= 0){
            return ajaxDataArr(0, null, '请输入防伪标签再提交！');
        }
        if(count($label_num_ok_arr) >= 500){
            return ajaxDataArr(0, null, '防伪标签单次最多提交500个！当前' . count($label_num_ok_arr) . '个！');
        }

        $saveAddData = [];
        $modifyData = [];
        foreach($label_num_ok_arr as $labelNum){
            $saveData = [
                'company_id' => $company_id,
                'pro_unit_id' => $pro_unit_id,
                'status' => $status,
                'security_label_num' => $labelNum,
                'account_id' => $this->user_info['id'] ?? 0,
            ];
            if($id > 0){
                $saveData['id'] = $id;
                array_push($modifyData,$saveData);
            }else{
                array_push($saveAddData,$saveData);
            }
        }

        if($id <= 0){// 批量新加
            $resultDatas = $this->createBathApi($this->model_name,$saveAddData,$company_id);
            if(!$resultDatas){
                return ajaxDataArr(0, null, '保存失败！');
            }
        }else{// 修改
            // 判断权限
            $judgeData = [
               'company_id' => $company_id,
               'pro_unit_id' => $pro_unit_id,
            ];
            $relations = '';
            $this->judgePower($request, $id,$judgeData,$this->model_name, $company_id,$relations);
            $saveData = $modifyData[0] ?? [];
            $resultDatas = $this->saveByIdApi($this->model_name, $id, $saveData, $company_id, 0);
            // $resultDatas = $this->saveBathById($this->model_name, $modifyData, 'id', $company_id );
        }

        $resluts = [
            'resData' =>   $resultDatas,
        ];
        return ajaxDataArr(1, $resluts, '');
    }

    // 判断防伪标签是否已经存在 true:已存在;false：不存在
    public function existLabel($company_id,$pro_unit_id,$security_label_num, $id){
        $queryParams = [
            'where' => [
                ['company_id',$company_id],
                ['pro_unit_id',$pro_unit_id],
                ['security_label_num',$security_label_num],
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
        $resultDatas = $this->ajaxGetList($this->model_name, $pageParams, $company_id,$queryParams ,'');
        $dataList = $resultDatas['dataList'] ?? [];
        if(empty($dataList) || count($dataList)<=0){
            return false;
        }
        return true;
    }
}
