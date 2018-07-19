<?php

namespace App\Http\Controllers;

use App\Services\Common;
use App\Services\HttpRequest;
use Illuminate\Http\Request;

class CompanyController extends LoginController
{
    protected $model_name = 'Company';

    /**
     * 企业信息
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);
        $company_id = $this->company_id;

        // 测试
//        $url = "http://api.kezhuisu.com/api/comp/add";
//        $dataJson = '{"Model_name":"CompanyProUnit","not_log":0,"company_id":1,"dataParams":{"company_id":1,"pro_input_name":"\u4ea7\u54c1\u5168\u79f0","pro_input_brand":"\u54c1\u79cd\/\u54c1\u724c","pro_input_batch":"\u6279\u6b21001","begin_time":"2018-07-03","end_time":"2018-07-05","pro_input_intro":""}}';
//        $dataParams = json_decode($dataJson,true);
//        echo '<pre>';
//        print_r($dataParams);
//        echo '</pre>';
//        return HttpRequest::HttpRequestApi($url, $dataParams, [], 'POST');
        //print_r(json_decode($dataJson,true));
        //echo $this->splicQuestAPI($url , $dataParams);
        //die;
        // 获得企业信息
        $relations = ['honors.siteResources','companyExtend'];
        $model_name = $this->model_name;
        $infoData = $this->getinfoApi($model_name, $relations, $this->company_id , $company_id);

        return view('company.index', $infoData);
    }

    /**
     * 企业信息
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_info(Request $request)
    {
        $this->InitParams($request);
        $company_id = $this->company_id;

        // 测试
//        $url = "http://api.kezhuisu.com/api/comp/add";
//        $dataJson = '{"Model_name":"CompanyProUnit","not_log":0,"company_id":1,"dataParams":{"company_id":1,"pro_input_name":"\u4ea7\u54c1\u5168\u79f0","pro_input_brand":"\u54c1\u79cd\/\u54c1\u724c","pro_input_batch":"\u6279\u6b21001","begin_time":"2018-07-03","end_time":"2018-07-05","pro_input_intro":""}}';
//        $dataParams = json_decode($dataJson,true);
//        echo '<pre>';
//        print_r($dataParams);
//        echo '</pre>';
//        return HttpRequest::HttpRequestApi($url, $dataParams, [], 'POST');
        //print_r(json_decode($dataJson,true));
        //echo $this->splicQuestAPI($url , $dataParams);
        //die;
        // 获得企业信息
        $relations = ['companyExtend'];
        $model_name = $this->model_name;
        $infoData = $this->getinfoApi($model_name, $relations, $this->company_id , $company_id);

        return ajaxDataArr(1, $infoData, '');
    }
    /**
     * ajax保存数据-资质
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_img_save(Request $request)
    {
        $this->InitParams($request);
        $company_id = $this->company_id;
        $model_name = 'CompanyHonor';
        $id = Common::getInt($request, 'id');
        if ($id < 0) {
            throws('参数[id]有误！');
        }
        $resource_id = Common::get($request, 'resource_id');

        $saveData = [
            // 'company_id' => $company_id,
            'resource_id' => $resource_id[0] ?? 0,
        ];

        if ($id <= 0) {// 新加
            $addNewData = [
                'company_id' => $company_id,
            ];
            $saveData = array_merge($saveData, $addNewData);
            $resultDatas = $this->createApi($model_name, $saveData, $company_id);
            $id = $resultDatas['id'] ?? 0;
        } else {// 修改
            // 判断权限
            $judgeData = [
                'company_id' => $company_id,
            ];
            $relations = '';
            $this->judgePower($request, $id, $judgeData, $model_name, $company_id, $relations);

            $resultDatas = $this->saveByIdApi($model_name, $id, $saveData, $company_id);

        }
        // 同步修改图片关系
        $syncParams =[
            'siteResources' => $resource_id,
        ];
        $syncDatas = $this->saveSyncByIdApi($model_name, $id, $syncParams, $company_id);

        $resluts = [
            'resData' =>   $resultDatas,
            'syncData' =>   $syncDatas,
        ];

        return ajaxDataArr(1, $resluts, '');
    }

    /**
     * ajax公司
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_save(Request $request)
    {
        $this->InitParams($request);
        $company_id = $this->company_id;
        $company_name = Common::get($request, 'company_name');
        $company_simple_name = Common::get($request, 'company_simple_name');
        $company_addr = Common::get($request, 'company_addr');
        $product_addr = Common::get($request, 'product_addr');
        $company_mainproduct = Common::get($request, 'company_mainproduct');
        $company_mainproduct =  replace_special_char($company_mainproduct,2);
        $company_mainproduct =  replace_enter_char($company_mainproduct,2);

        $ccredit_code = Common::get($request, 'ccredit_code');
        $company_createtime = Common::get($request, 'company_createtime');
        $reg_capital = Common::get($request, 'reg_capital');
        $legal_name = Common::get($request, 'legal_name');
        $contact_way = Common::get($request, 'contact_way');
        $contact_way =  replace_special_char($contact_way,2);
        $contact_way =  replace_enter_char($contact_way,2);
        //判断开始
        $create_time_unix = judgeDate($company_createtime);
        if($create_time_unix === false){
            ajaxDataArr(0, null, '成立时间不是有效日期');
        }

        $saveData = [
            'company_name' => $company_name,
            'company_simple_name' => $company_simple_name,
            'company_addr' => $company_addr,
            'product_addr' => $product_addr,
            'company_mainproduct' => $company_mainproduct,
            'ccredit_code' => $ccredit_code,
            'company_createtime' => $company_createtime,
            'reg_capital' => $reg_capital,
            'legal_name' => $legal_name,
            'contact_way' => $contact_way,
        ];
        // 修改
        // 判断权限
        $judgeData = [
            'id' => $company_id,
        ];
        $relations = '';
        $this->judgePower($request, $company_id,$judgeData,$this->model_name, $company_id,$relations);

        $resultDatas = $this->saveByIdApi($this->model_name, $company_id, $saveData, $company_id);

        return ajaxDataArr(1, $resultDatas, '');
    }

    /**
     * ajax公司
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function intro_save(Request $request)
    {

        return $this->ajax_intro_save($request);
    }

    /**
     * ajax公司
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_intro_save(Request $request)
    {
        $this->InitParams($request);
        $company_id = $this->company_id;
        $id = Common::getInt($request, 'id');
        $company_intro = Common::get($request, 'company_intro');
        $company_intro = stripslashes($company_intro);
        //$company_intro =  replace_special_char($company_intro,2);
        //$company_intro =  replace_enter_char($company_intro,2);
        // 富文本内容替换
        $company_intro = str_replace(['"/resource/kindeditor/image/'],['"' . config('public.compWebURL') . 'resource/kindeditor/image/'],$company_intro);
        $saveData = [
            'company_intro' => $company_intro,
        ];
        $model_name = 'CompanyExtend';
        if($id <= 0){// 新加
            $saveData['company_id'] = $company_id;
            $resultDatas = $this->createApi($model_name,$saveData,$company_id);
            $id = $resultDatas['id'] ?? 0;
        }else{// 修改
            // 判断权限
            $judgeData = [
                'company_id' => $company_id,
            ];
            $relations = '';
            $this->judgePower($request, $id,$judgeData,$model_name, $company_id,$relations);

            $resultDatas = $this->saveByIdApi($model_name, $id, $saveData, $company_id);
        }
        return ajaxDataArr(1, $resultDatas, '');
    }
}
