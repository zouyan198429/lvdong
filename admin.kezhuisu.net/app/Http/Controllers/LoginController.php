<?php

namespace App\Http\Controllers;

use App\Services\HttpRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $company_id = null ;
    protected $model_name = null;
    protected $user_info = [];
    protected $user_id = null;

    public function InitParams(Request $request)
    {
        session_start(); // 初始化session
        $userInfo = $_SESSION['userInfo']?? [];
        if(empty($userInfo)) {
            throws('非法请求！');
//            if(isAjax()){
//                ajaxDataArr(0, null, '非法请求！');
//            }else{
//                redirect('login');
//            }
        }
        $company_id = $userInfo['id'] ?? null;//Common::getInt($request, 'company_id');
        if(empty($company_id) || (!is_numeric($company_id))){
            throws('非法请求！');
//            if(isAjax()){
//                ajaxDataArr(0, null, '非法请求！');
//            }else{
//                redirect('login');
//            }
        }
        // Common::judgeInitParams($request, 'company_id', $company_id);
        $this->user_info =$userInfo;
        $this->user_id = $userInfo['id'] ?? '';
        $this->company_id = '99999';// $company_id;
    }

    // 公共方法

    /**
     * 根据model的id获得详情记录
     *
     * @param object $modelObj 当前模型对象
     * @param int $companyId 企业id
     * @param int $id id
     * @param json/array $relations 要查询的与其它表的关系
     * @param int $notLog 是否需要登陆 0需要1不需要
     * @author zouyan(305463219@qq.com)
     */
    public function getinfoApi($modelName, $relations = '', $companyId = null , $id = null, $notLog = 0){
        $url = config('public.apiUrl') . config('public.apiPath.getinfoApi');
        $requestData = [
            // 'company_id' => $companyId,
            // 'id' => $id,
            'Model_name' => $modelName, // 模型
            'not_log' => $notLog,
            // 'relations' => '', // 查询关系参数
        ];
        if (is_numeric($companyId) && $companyId > 0) {
            $requestData['company_id'] = $companyId ;
        }
        if(empty($id) || (!is_numeric($id))){
            throws('需要获取的记录id有误!');
        }
        //if (is_numeric($id) && $id > 0) {
        $requestData['id'] = $id ;
        //}
        if (!empty($relations)) {
            $requestData['relations'] = $relations ;
        }
        // 生成带参数的测试get请求
        // $requestTesUrl = splicQuestAPI($url , $requestData);
        return HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
    }

    /**
     * ajax指定条件删除记录
     *
     * @param object $modelObj 当前模型对象
     * @param int $companyId 企业id
     * @param string $queryParams 条件数组/json字符
     * @param int $notLog 是否需要登陆 0需要1不需要
     * @author zouyan(305463219@qq.com)
     */
    public function ajaxDelApi($modelName, $companyId = null,$queryParams =''  , $notLog = 0){

        $requestData = [
            // 'company_id' => $this->company_id,
            'Model_name' => $modelName, // 模型
            'not_log' => $notLog,
            'queryParams' =>$queryParams,//[// 查询条件参数
            //    'where' => [
            //        ['id', $id],
            //        ['company_id', $this->company_id]
            //    ]
            //],
        ];
        //$where = [];
        if (is_numeric($companyId) && $companyId > 0) {
            $requestData['company_id'] = $companyId ;
            // array_push($where,['company_id', $companyId]) ;
        }
//        if (is_numeric($id) && $id > 0) {
//            array_push($where,['id', $id]) ;
//        }
//        if(!empty($where)){
//            $requestData['queryParams']['where'] = $where ;
//        }
        $url = config('public.apiUrl') . config('public.apiPath.delApi');

        // 生成带参数的测试get请求
        // $requestTesUrl = splicQuestAPI($url , $requestData);
        return HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
    }

    /**
     * ajax获得列表记录
     *
     * @param object $modelObj 当前模型对象
     * @param int $companyId 企业id
     * @param array $pageParams
     * [
    'page' => $page,
    'pagesize' => $pagesize,
    'total' => $total,
    ]
     * @param string $queryParams 条件数组/json字符
     * @param string $relations 关系数组/json字符
     * @param int $notLog 是否需要登陆 0需要1不需要
     * @author zouyan(305463219@qq.com)
     */
    public function ajaxGetAllList($modelName, $pageParams, $companyId = null,$queryParams='' ,$relations = '', $notLog = 0){
        $requestData = [
            // 'company_id' => $companyId,
            'Model_name' => $modelName, // 模型
            'queryParams' => $queryParams, // 查询条件参数
            'relations' => $relations, // 查询关系参数
            'not_log' => $notLog,
        ];
        //$where = [];
        if (is_numeric($companyId) && $companyId > 0) {
            $requestData['company_id'] = $companyId ;
            //   array_push($where,['company_id', $companyId]) ;
        }
//        if(!empty($where)){
//            if(!is_array($queryParams)){
//                $queryParams = [];
//            }
//            if(!isset($queryParams['where'])){
//                $queryParams['where'] = [];
//            }
//            if(isset($queryParams['where']) && empty($queryParams['where'])) {
//                $queryParams['where'] = [];
//            }
//            $queryParams['where'] = array_merge($queryParams['where'],$where);
//            $requestData['queryParams'] = $queryParams ;
//        }

        // $requestData = array_merge($requestData,$pageParams);
        $url = config('public.apiUrl') . config('public.apiPath.getAllApi');
        // 生成带参数的测试get请求
        // $requestTesUrl = splicQuestAPI($url , $requestData);
        return HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
    }

    /**
     * ajax获得列表记录
     *
     * @param object $modelObj 当前模型对象
     * @param int $companyId 企业id
     * @param array $pageParams
     * [
    'page' => $page,
    'pagesize' => $pagesize,
    'total' => $total,
    ]
     * @param string $queryParams 条件数组/json字符
     * @param string $relations 关系数组/json字符
     * @param int $notLog 是否需要登陆 0需要1不需要
     * @author zouyan(305463219@qq.com)
     */
    public function ajaxGetList($modelName, $pageParams, $companyId = null,$queryParams='' ,$relations = '', $notLog = 0)
    {
        $requestData = [
            // 'company_id' => $companyId,
            'Model_name' => $modelName, // 模型
            'queryParams' => $queryParams, // 查询条件参数
            'relations' => $relations, // 查询关系参数
            'not_log' => $notLog,
        ];
        // $where = [];
        if (is_numeric($companyId) && $companyId > 0) {
            $requestData['company_id'] = $companyId ;
            // array_push($where,['company_id', $companyId]) ;
        }
//        if(!empty($where)){
//            if(!is_array($queryParams)){
//                $queryParams = [];
//            }
//            if(!isset($queryParams['where'])){
//                $queryParams['where'] = [];
//            }
//            if(isset($queryParams['where']) && empty($queryParams['where'])) {
//                $queryParams['where'] = [];
//            }
//            $queryParams['where'] = array_merge($queryParams['where'],$where);
//            $requestData['queryParams'] = $queryParams ;
//        }

        $requestData = array_merge($requestData,$pageParams);

        $url = config('public.apiUrl') . config('public.apiPath.getlistApi');
        // 生成带参数的测试get请求
        // $requestTesUrl = splicQuestAPI($url , $requestData);
        return HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
    }

    /**
     * 修改或新加记录
     *
     * @param object $modelObj 当前模型对象
     * @param array $saveData 要保存或修改的数组
     * @param int $companyId 企业id
     * @param int $notLog 是否需要登陆 0需要1不需要
     * @author zouyan(305463219@qq.com)
     */
    public function createApi($modelName,$saveData= [], $companyId = null, $notLog = 0 )
    {
        $requestData = [
            // 'company_id' => $this->company_id,
            'Model_name' => $modelName, // 模型
            'not_log' => $notLog,
        ];
        if (is_numeric($companyId) && $companyId > 0) {
            $requestData['company_id'] = $companyId ;
        }
        $requestData['dataParams'] = $saveData;
        // 新加用户
        $url = config('public.apiUrl') . config('public.apiPath.addnewApi');
        // 生成带参数的测试get请求
        // echo $requestTesUrl = splicQuestAPI($url , $requestData); die;
        return HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
    }

    /**
     * 批量新加-data只能返回成功true:失败:false
     *
     * @param object $modelObj 当前模型对象
     * @param array $saveData 要保存或修改的数组-二维数组
     * @param int $companyId 企业id
     * @param int $notLog 是否需要登陆 0需要1不需要
     * @author zouyan(305463219@qq.com)
     */
    public function createBathApi($modelName,$saveData= [], $companyId = null, $notLog = 0 )
    {
        $requestData = [
            // 'company_id' => $this->company_id,
            'Model_name' => $modelName, // 模型
            'not_log' => $notLog,
        ];
        if (is_numeric($companyId) && $companyId > 0) {
            $requestData['company_id'] = $companyId ;
        }
        $requestData['dataParams'] = $saveData;
        // 新加用户
        $url = config('public.apiUrl') . config('public.apiPath.addnewBathApi');
        // 生成带参数的测试get请求
        // echo $requestTesUrl = splicQuestAPI($url , $requestData); die;
        return HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
    }

    /**
     * 批量新加-data返回成功的id数组
     *
     * @param object $modelObj 当前模型对象
     * @param array $saveData 要保存或修改的数组-二维数组
     * @param string $primaryKey 表的主键字段名称
     * @param int $companyId 企业id
     * @param int $notLog 是否需要登陆 0需要1不需要
     * @author zouyan(305463219@qq.com)
     */
    public function createBathByPrimaryKeyApi($modelName,$saveData= [], $primaryKey = 'id', $companyId = null, $notLog = 0 )
    {
        $requestData = [
            // 'company_id' => $this->company_id,
            'Model_name' => $modelName, // 模型
            'not_log' => $notLog,
        ];
        if (is_numeric($companyId) && $companyId > 0) {
            $requestData['company_id'] = $companyId ;
        }
        $requestData['dataParams'] = $saveData;
        if(!empty($primaryKey)){
            $requestData['primaryKey'] = $primaryKey;
        }
        // 新加用户
        $url = config('public.apiUrl') . config('public.apiPath.addnewBathByIdApi');
        // 生成带参数的测试get请求
        // echo $requestTesUrl = splicQuestAPI($url , $requestData); die;
        return HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
    }

    /**
     * 根据条件修改记录
     *
     * @param object $modelObj 当前模型对象
     * @param array $saveData 要保存或修改的数组
     * @param string $queryParams 条件数组/json字符
     * @param int $companyId 企业id
     * @param int $notLog 是否需要登陆 0需要1不需要
     * @author zouyan(305463219@qq.com)
     */
    public function ModifyByQueyApi($modelName, $saveData= [], $queryParams='', $companyId = null, $notLog = 0 ){

        $requestData = [
            // 'company_id' => $this->company_id,
            'Model_name' => $modelName, // 模型
            'not_log' => $notLog,
            'queryParams' => $queryParams, // 查询条件参数
        ];
        if (is_numeric($companyId) && $companyId > 0) {
            $requestData['company_id'] = $companyId ;
        }
        $requestData['dataParams'] = $saveData;
        // 修改
        $url = config('public.apiUrl') . config('public.apiPath.saveApi');
        //$requestData['queryParams'] =[// 查询条件参数
        //    'where' => [
        //        ['id', $id],
        //       ['company_id', $company_id]
        //    ]
        //];
        // 生成带参数的测试get请求
        // $requestTesUrl = splicQuestAPI($url , $requestData);
        return HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
    }

    /**
     * 根据主健批量修改记录
     *
     * @param object $modelObj 当前模型对象
     * @param array $saveData 要保存或修改的数组
     * @param string $queryParams 条件数组/json字符
     * @param int $companyId 企业id
     * @param int $notLog 是否需要登陆 0需要1不需要
     * @author zouyan(305463219@qq.com)
     */
    public function saveBathById($modelName, $saveData= [], $primaryKey = 'id', $companyId = null, $notLog = 0 ){

        $requestData = [
            // 'company_id' => $this->company_id,
            'Model_name' => $modelName, // 模型
            'not_log' => $notLog,
            'primaryKey' => $primaryKey, // 记录主键
        ];
        if (is_numeric($companyId) && $companyId > 0) {
            $requestData['company_id'] = $companyId ;
        }
        $requestData['dataParams'] = $saveData;
        // 修改
        $url = config('public.apiUrl') . config('public.apiPath.saveBathById');
        // 生成带参数的测试get请求
        $requestTesUrl = splicQuestAPI($url , $requestData);
        return HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
    }

    /**
     * 通过id修改接口
     *
     * @param object $modelObj 当前模型对象
     * @param int $id id
     * @param int $companyId 企业id
     * @param array $saveData 要保存或修改的数组
     * @param int $notLog 是否需要登陆 0需要1不需要
     * @author zouyan(305463219@qq.com)
     */
    public function saveByIdApi($modelName, $id, $saveData, $companyId = null, $notLog = 0){
        if(empty($id) ){
            throws('需要更新的记录id不能为空!');
        }
        if(empty($saveData)){
            throws('需要更新的数据不能为空!');
        }
        $url = config('public.apiUrl') . config('public.apiPath.saveByIdApi');
        $requestData = [
            // 'company_id' => $companyId,
            // 'id' => $id,
            'Model_name' => $modelName, // 模型
            'not_log' => $notLog,
            // 'relations' => '', // 查询关系参数
        ];
        $requestData['dataParams'] = $saveData; // 需要更新的数据

        if (is_numeric($companyId) && $companyId > 0) {
            $requestData['company_id'] = $companyId ;
        }
        if (is_numeric($id) && $id > 0) {
            $requestData['id'] = $id ;
        }
        // 生成带参数的测试get请求
        // $requestTesUrl = splicQuestAPI($url , $requestData);
        return HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
    }

    /**
     * 自增自减接口,通过条件-data操作的行数
     *
     * @param object $modelObj 当前模型对象
     * @param string $queryParams 条件数组/json字符
     * @param string incDecType 增减类型 inc 增 ;dec 减[默认]
     * @param string incDecField 增减字段
     * @param string incDecVal 增减值
     * @param array $saveData 要保存或修改的数组  修改的其它字段 -没有，则传空数组[]
     * @param int $companyId 企业id
     * @param int $notLog 是否需要登陆 0需要1不需要
     * @author zouyan(305463219@qq.com)
     */
    public function incDecByQueyApi($modelName, $queryParams='', $incDecType = 'dec', $incDecField = '', $incDecVal = 0, $saveData= [], $companyId = null, $notLog = 0 ){

        $requestData = [
            // 'company_id' => $this->company_id,
            'Model_name' => $modelName, // 模型
            'not_log' => $notLog,
            'queryParams' => $queryParams, // 查询条件参数
            'incDecType' => $incDecType, // 增减类型 inc 增 ;dec 减[默认]
            'incDecField' => $incDecField, // 增减字段
            'incDecVal' => $incDecVal, // 增减值
        ];
        if (is_numeric($companyId) && $companyId > 0) {
            $requestData['company_id'] = $companyId ;
        }
        $requestData['dataParams'] = $saveData;
        // 修改
        $url = config('public.apiUrl') . config('public.apiPath.saveDecIncByQueryApi');
        //$requestData['queryParams'] =[// 查询条件参数
        //    'where' => [
        //        ['id', $id],
        //       ['company_id', $company_id]
        //    ]
        //];
        // 生成带参数的测试get请求
        // $requestTesUrl = splicQuestAPI($url , $requestData);
        return HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
    }

    /**
     * 自增自减接口,通过条件-data操作的行数
     *
     * @param array $saveData 要保存或修改的数组
    $saveData = [
    [
    'Model_name' => 'model名称',
    'primaryVal' => '主键字段值',
    'incDecType' => '增减类型 inc 增 ;dec 减[默认]',
    'incDecField' => '增减字段',
    'incDecVal' => '增减值',
    'modifFields' => '修改的其它字段 -没有，则传空数组',
    ],
    ];
     * @param int $companyId 企业id
     * @param int $notLog 是否需要登陆 0需要1不需要
     * @author zouyan(305463219@qq.com)
     */
    public function bathIncDecByArrApi($saveData= [], $companyId = null, $notLog = 0 ){

        $requestData = [
            // 'company_id' => $this->company_id,
            'not_log' => $notLog,
        ];
        if (is_numeric($companyId) && $companyId > 0) {
            $requestData['company_id'] = $companyId ;
        }
        $requestData['dataParams'] = $saveData;
        // 修改
        $url = config('public.apiUrl') . config('public.apiPath.saveDecIncByArrApi');
        //$requestData['queryParams'] =[// 查询条件参数
        //    'where' => [
        //        ['id', $id],
        //       ['company_id', $company_id]
        //    ]
        //];
        // 生成带参数的测试get请求
        // $requestTesUrl = splicQuestAPI($url , $requestData);
        return HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
    }

    /**
     * 通过id同步修改关系接口
     *
     * @param object $modelObj 当前模型对象
     * @param int $id id
     * @param int $companyId 企业id
     * @param array $syncParams 要保存或修改的关系数组;可多个 ;格式 [ '关系方法名' =>关系值及相关字段]
     * @param int $notLog 是否需要登陆 0需要1不需要
     * @author zouyan(305463219@qq.com)
     */
    public function saveSyncByIdApi($modelName, $id, $syncParams, $companyId = null, $notLog = 0){

        if(empty($id) ){
            throws('需要更新的记录id不能为空!');
        }
        if(empty($syncParams)){
            throws('需要更新的数据不能为空!');
        }

        $url = config('public.apiUrl') . config('public.apiPath.saveSyncByIdApi');
        $requestData = [
            // 'company_id' => $companyId,
            // 'id' => $id,
            'Model_name' => $modelName, // 模型
            'not_log' => $notLog,
            // 'relations' => '', // 查询关系参数
        ];
        $requestData['synces'] = $syncParams; // 需要更新的数据

        if (is_numeric($companyId) && $companyId > 0) {
            $requestData['company_id'] = $companyId ;
        }
        if (is_numeric($id) && $id > 0) {
            $requestData['id'] = $id ;

        }
        // 生成带参数的测试get请求
        // $requestTesUrl = splicQuestAPI($url , $requestData);
        return HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
    }

    /**
     * 通过id移除关系接口
     *
     * @param object $modelObj 当前模型对象
     * @param int $id id
     * @param int $companyId 企业id
     * @param array $detachParams 要移除的关系数组;可多个 ;格式 [ '关系方法名' =>关系id或空(全部移除)]
     * @param int $notLog 是否需要登陆 0需要1不需要
     * @author zouyan(305463219@qq.com)
     */
    public function detachByIdApi($modelName, $id, $detachParams, $companyId = null, $notLog = 0){

        if(empty($id) ){
            throws('需要更新的记录id不能为空!');
        }
        if(empty($detachParams)){
            throws('需要移除的数据不能为空!');
        }

        $url = config('public.apiUrl') . config('public.apiPath.detachApi');
        $requestData = [
            // 'company_id' => $companyId,
            // 'id' => $id,
            'Model_name' => $modelName, // 模型
            'not_log' => $notLog,
            // 'relations' => '', // 查询关系参数
        ];
        $requestData['detaches'] = $detachParams; // 需要移除的数据

        if (is_numeric($companyId) && $companyId > 0) {
            $requestData['company_id'] = $companyId ;
        }
        if (is_numeric($id) && $id > 0) {
            $requestData['id'] = $id ;

        }
        // 生成带参数的测试get请求
        // $requestTesUrl = splicQuestAPI($url , $requestData);
        return HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
    }

    // 判断权限-----开始
    // 判断权限 ,返回当前记录[可再进行其它判断], 有其它主字段的，可以重新此方法
    /**
     * 判断权限
     *
     * @param object $modelObj 当前模型对象
     * @param int $id id
     * @param array $judgeArr 需要判断的下标[字段名]及值 一维数组
     * @param string $model_name 模型名称
     * @param int $companyId 企业id
     * @param json/array $relations 要查询的与其它表的关系
     * @param int $notLog 是否需要登陆 0需要1不需要
     * @author zouyan(305463219@qq.com)
     */
    public function judgePower(Request $request, $id, $judgeArr = [] , $model_name = '', $company_id = '', $relations = '', $notLog  = 0){
        // $this->InitParams($request);
        if(empty($model_name)){
            $model_name = $this->model_name;
        }
        // 获得当前记录
        $infoData = $this->getinfoApi($model_name, $relations, $company_id , $id, $notLog);
        $this->judgePowerByObj($request, $infoData, $judgeArr);
        return $infoData;
    }

    public function judgePowerByObj(Request $request,$infoData, $judgeArr = [] ){
        if(empty($infoData)){
            throws('记录不存!');
        }
        foreach($judgeArr as $field => $val){
            if(!isset($infoData[$field])){
                throws('字段[' . $field . ']不存在!');
            }
            if( $infoData[$field] != $val ){
                throws('没有操作此记录权限!信息字段[' . $field . ']');
            }
        }
    }

    // 判断权限-----结束
    /**
     * 根据资源id，删除资源及数据表记录
     *
     * @param object $modelObj 当前模型对象
     * @param int $companyId 企业id
     * @param string $queryParams 条件数组/json字符
     * @param int $notLog 是否需要登陆 0需要1不需要
     * @author zouyan(305463219@qq.com)
     */
    public function ResourceDelById($id, $companyId = null,$notLog = 0){
        $model_name = 'Resource';
        // 获得数据记录
        $relations = '';
        $info = $this->getinfoApi($model_name, $relations, $companyId , $id, $notLog);
        if(empty($info)){
            throws('资源记录[' . $id . ']不存在!');
        }
        // 删除文件
        $this->resourceDelFile([$info]);
        //删除记录
        $queryParams =[// 查询条件参数
            'where' => [
                ['id', $id],
            ]
        ];
        return $this->ajaxDelApi($model_name, $companyId , $queryParams, $notLog);
    }

    /**
     * 根据数据表记录，删除本地文件
     *
     * @param object $modelObj 当前模型对象
     * @param array $resources 资源记录数组 - 二维
     * @author zouyan(305463219@qq.com)
     */
    public function resourceDelFile($resources = []){
        foreach($resources as $resource){
            $resource_url = $resource['resource_url'] ?? '';
            if(empty($resource_url)){
                continue;
            }
            @unlink(public_path($resource_url));// 删除文件
        }
    }

    /**
     * 根据数据表记录[二维]，转换资源url为可以访问的地址
     *
     * @param array $reportsList 栏目记录数组 - 二维
     * @param int $type 多少维  1:一维[默认]；2 二维 --注意是资源的维度
     * @author zouyan(305463219@qq.com)
     */
    public function resoursceUrl(&$reportsList, $type = 2){
        foreach($reportsList as $k=>$item){
            $reportsList[$k] = $this->resourceUrl($item,$type);
        }
        return $reportsList;
    }

    /**
     * 根据数据表记录，转换资源url为可以访问的地址
     *
     * @param array $dataList 资源记录数组 - 二维 / 一维
     * @param int $type 多少维  1:一维[默认]；2 二维 --注意是资源的维度
     * @author zouyan(305463219@qq.com)
     */
    public function resourceUrl(&$dataList,$type = 2){
        if($type == 2){
            if(isset($dataList['site_resources'])){
                $site_resources = $dataList['site_resources'] ?? [];
                foreach($site_resources as $k=>$site_resource){
                    $site_resources[$k]['resource_url'] = url($site_resource['resource_url']);
                }
                $dataList['site_resources'] = $site_resources;
            }
        }else{
            if(isset($dataList['resource_url'])){
                $dataList['resource_url'] = url($dataList['resource_url']);
            }
        }
        return $dataList;
    }
}
