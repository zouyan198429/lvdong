<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Illuminate\Http\Request;

class MemberController extends LoginController
{
    protected $model_name = 'Company';
    /**
     * 会员管理
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);
        return view('member.index');
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
        // 获得公司类型
        $relations = '';// 关系
        $queryParams = [
            'where' => [
              //  ['company_id', $this->company_id],
            ],
            'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数
        $typesList = $this->ajaxGetAllList('CompanyType', '', $this->company_id,$queryParams ,'' );
        // 获得公司等级
        $relations = '';// 关系
        $queryParams = [
            'where' => [
                //  ['company_id', $this->company_id],
            ],
           // 'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数
        $ranksList = $this->ajaxGetAllList('CompanyRank', '', $this->company_id,$queryParams ,'' );

        $resultDatas = [
            'id'=>$id,
            'company_type_id' => 0,
            'company_rank_id' => 0,
            'company_mainproduct' => '',
            'contact_way' => '',
            'company_vipbegin' => date("Y-m-d H:i:s",time()),
            'company_vipend' => date("Y-m-d H:i:s",strtotime("+2 month"))
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
        $resultDatas['typesList'] = $typesList;
        $resultDatas['ranksList'] = $ranksList;
        $resultDatas['company_mainproduct'] =  replace_enter_char($resultDatas['company_mainproduct'],2);
        $resultDatas['contact_way'] =  replace_enter_char($resultDatas['contact_way'],2);
        return view('member.edit',$resultDatas);
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

        $company_name = Common::get($request, 'company_name');
        $queryParams = [
            'where' => [
                //  ['company_id', $this->company_id],
                //  ['company_name', 'like' , '%' . $company_name . '%'],
            ],
            'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数
        if(!empty($company_name)){
            array_push($queryParams['where'],['company_name', 'like' , '%' . $company_name . '%']);
        }
        $relations = ['province','city','area'];// 关系
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

        foreach($resultDatas as $K => $v){
            $company_vipbegin = $v['company_vipbegin'];
            $company_vipend = $v['company_vipend'];
            $resultDatas[$K]['company_vipbegin'] = date('Y-m-d',strtotime($company_vipbegin));
            $resultDatas[$K]['company_vipend'] = date('Y-m-d',strtotime($company_vipend));
            $province = $v['province']['province_name'] ?? '';
            $city = $v['city']['city_name'] ?? '';
            $area = $v['area']['city_name'] ?? '';
            $resultDatas[$K]['area'] = $province . '/' . $city;
        }

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
        $company_type_id = Common::getInt($request, 'company_type_id');
        $company_rank_id = Common::getInt($request, 'company_rank_id');
        $company_name = Common::get($request, 'company_name');
        $company_simple_name = Common::get($request, 'company_simple_name');
        $ccredit_code = Common::get($request, 'ccredit_code');
        $reg_capital = Common::get($request, 'reg_capital');
        $legal_name = Common::get($request, 'legal_name');
        $company_linkman = Common::get($request, 'company_linkman');
        $company_tel = Common::get($request, 'company_tel');
        $company_mobile = Common::get($request, 'company_mobile');
        $company_wx = Common::get($request, 'company_wx');
        $company_fax = Common::get($request, 'company_fax');
        $company_email = Common::get($request, 'company_email');
        $province_id = Common::get($request, 'province_id');
        $city_id = Common::get($request, 'city_id');
        $area_id = Common::get($request, 'area_id');
        $company_addr = Common::get($request, 'company_addr');
        $product_addr = Common::get($request, 'product_addr');
        $company_mainproduct = Common::get($request, 'company_mainproduct');
        $company_createtime = Common::get($request, 'company_createtime');
        $contact_way = Common::get($request, 'contact_way');
        $contact_way =  replace_enter_char($contact_way,1);
        $company_vipbegin = Common::get($request, 'company_vipbegin');
        $company_vipend = Common::get($request, 'company_vipend');

        if(!empty($company_createtime)){
            $create_time_unix = judgeDate($company_createtime);
            if($create_time_unix === false){
                ajaxDataArr(0, null, '成立时间不是有效日期');
            }
        }
        if(!empty($company_vipbegin)){

            //判断开始
            $begin_time_unix = judgeDate($company_vipbegin);
            if($begin_time_unix === false){
                ajaxDataArr(0, null, '开如日期不是有效日期');
            }

            //判断期限结束
            $end_time_unix = judgeDate($company_vipend);
            if($end_time_unix === false){
                ajaxDataArr(0, null, '结束日期不是有效日期');
            }

            if($end_time_unix < $begin_time_unix){
                ajaxDataArr(0, null, '结束日期不能小于开始日期');
            }

        }
        $saveData = [
            'company_type_id' => $company_type_id,
            'company_rank_id' => $company_rank_id,
            'company_name' => $company_name,
            'company_simple_name' => $company_simple_name,
            'ccredit_code' => $ccredit_code,
            'reg_capital' => $reg_capital,
            'legal_name' => $legal_name,
            'company_linkman' => $company_linkman,
            'company_tel' => $company_tel,
            'company_mobile' => $company_mobile,
            'company_wx' => $company_wx,
            'company_fax' => $company_fax,
            'company_email' => $company_email,
            'province_id' => $province_id,
            'city_id' => $city_id,
            'area_id' => $area_id,
            'company_addr' => $company_addr,
            'product_addr' => $product_addr,
            'company_mainproduct' => $company_mainproduct,
            'company_createtime' => $company_createtime,
            'contact_way' => $contact_way,
            'company_vipbegin' => $company_vipbegin,
            'company_vipend' => $company_vipend,
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
