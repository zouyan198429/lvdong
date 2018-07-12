<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Illuminate\Http\Request;

class TinyWebController extends LoginController
{
    protected $model_name = 'CompanyProConfig';

    /**
     * 微站-底部导航
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request,$pro_unit_id)
    {
        $this->InitParams($request);
        // 获得微站模板
        $relations = ['siteResources'];// 关系
        $queryParams = [
            'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数
        $tempList = $this->ajaxGetAllList('SiteTinyWebTemplate', '', $this->company_id,$queryParams ,$relations );
        // 资源url
        $this->resoursceUrl($tempList);
        // 获得配置信息
        $relations = ['siteResources'];// 关系
        $queryParams = [
            'where' => [
                ['company_id',$this->company_id],
                ['pro_unit_id',$pro_unit_id],
            ],
            // 'limit' => 1
        ];
        $pageParams = [
            'page' =>1,
            'pagesize' => 1,
            'total' => 1,
        ];
        $resultDatas = $this->ajaxGetList($this->model_name, $pageParams, $this->company_id,$queryParams ,$relations);

        $config = $resultDatas['dataList'][0] ?? [];
        // 资源url
        $this->resourceUrl($config);
        // 获得生产单元的-菜单
        $relations = ['siteResources'];// 关系
        $queryParams = [
            'where' => [
                ['company_id',$this->company_id],
                ['pro_unit_id',$pro_unit_id],
            ],
            'orderBy' => ['menu_order'=>'desc','id'=>'desc'],
        ];// 查询条件参数
        $menuList = $this->ajaxGetAllList('CompanyProMenu', '', $this->company_id,$queryParams ,$relations );
        // 资源url
        $this->resoursceUrl($menuList);
        $datas = [
          'tempList' => $tempList,
          'pro_unit_id'=>$pro_unit_id,
          'config' => $config,
          'menuList' => $menuList,
        ];
        return view('tinyweb.index',$datas);
    }

    /**
     * ajax保存应用模板
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_apply(Request $request,$pro_unit_id)
    {
        $this->InitParams($request);
        $company_id = $this->company_id;
        Common::judgeInitParams($request, 'pro_unit_id', $pro_unit_id);
        $id = Common::getInt($request, 'id');
        // Common::judgeInitParams($request, 'id', $id);
        $temp_id = Common::getInt($request, 'temp_id');
        Common::judgeInitParams($request, 'temp_id', $temp_id);

        $saveData = [
            'site_template_id' => $temp_id,
            'account_id' => $this->user_id,
        ];
        $model_name = $this->model_name;
        if($id <= 0){// 新加
            $saveData['company_id'] = $company_id;
            $saveData['pro_unit_id'] = $pro_unit_id;
            $resultDatas = $this->createApi($model_name,$saveData,$company_id);
            $id = $resultDatas['id'] ?? 0;
        }else{// 修改
            // 判断权限
            $judgeData = [
                'company_id' => $company_id,
                'pro_unit_id' => $pro_unit_id,
            ];
            $relations = '';
            $this->judgePower($request, $id,$judgeData,$model_name, $company_id,$relations);

            $resultDatas = $this->saveByIdApi($model_name, $id, $saveData, $company_id);
        }
        return ajaxDataArr(1, $resultDatas, '');
    }

    /**
     * ajax修改其它设置-第三方代码
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_save(Request $request,$pro_unit_id)
    {
        $this->InitParams($request);
        $company_id = $this->company_id;
        Common::judgeInitParams($request, 'pro_unit_id', $pro_unit_id);
        $id = Common::getInt($request, 'id');
        // Common::judgeInitParams($request, 'id', $id);
        $third_code = Common::get($request, 'third_code');
        $third_code =  replace_special_char($third_code,2);
        $third_code =  replace_enter_char($third_code,2);

        $resource_id = Common::get($request, 'resource_id');
        $saveData = [
            'third_code' => $third_code,
            'resource_id' => $resource_id[0] ?? 0,
            'account_id' => $this->user_id,
        ];
        $model_name = $this->model_name;
        if($id <= 0){// 新加
            $saveData['company_id'] = $company_id;
            $saveData['pro_unit_id'] = $pro_unit_id;
            $resultDatas = $this->createApi($model_name,$saveData,$company_id);
            $id = $resultDatas['id'] ?? 0;
        }else{// 修改
            // 判断权限
            $judgeData = [
                'company_id' => $company_id,
                'pro_unit_id' => $pro_unit_id,
            ];
            $relations = '';
            $this->judgePower($request, $id,$judgeData,$model_name, $company_id,$relations);

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
     * ajax修改其它设置-第三方代码
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_is_open(Request $request,$pro_unit_id)
    {
        $this->InitParams($request);
        $company_id = $this->company_id;
        Common::judgeInitParams($request, 'pro_unit_id', $pro_unit_id);
        $id = Common::getInt($request, 'id');
        // Common::judgeInitParams($request, 'id', $id);
        $tinyweb_is_open = Common::getInt($request, 'tinyweb_is_open');
        if (!in_array($tinyweb_is_open, [0,1])){
            throws('参数[tinyweb_is_open]必须为整数[0或1]！');
        }

        $saveData = [
            'tinyweb_is_open' => $tinyweb_is_open,
            'account_id' => $this->user_id,
        ];
        $model_name = $this->model_name;
        if($id <= 0){// 新加
            $saveData['company_id'] = $company_id;
            $saveData['pro_unit_id'] = $pro_unit_id;
            $resultDatas = $this->createApi($model_name,$saveData,$company_id);
            $id = $resultDatas['id'] ?? 0;
        }else{// 修改
            // 判断权限
            $judgeData = [
                'company_id' => $company_id,
                'pro_unit_id' => $pro_unit_id,
            ];
            $relations = '';
            $this->judgePower($request, $id,$judgeData,$model_name, $company_id,$relations);

            $resultDatas = $this->saveByIdApi($model_name, $id, $saveData, $company_id);
        }
        return ajaxDataArr(1, $resultDatas, '');
    }

    /**
     * ajax菜单是否显示设置
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function menu_is_show(Request $request,$pro_unit_id)
    {
        $this->InitParams($request);
        $company_id = $this->company_id;
        Common::judgeInitParams($request, 'pro_unit_id', $pro_unit_id);
        $id = Common::getInt($request, 'id');
        Common::judgeInitParams($request, 'id', $id);
        $menu_is_show = Common::getInt($request, 'menu_is_show');
        if (!in_array($menu_is_show, [0,1])){
            throws('参数[menu_is_show]必须为整数[0或1]！');
        }

        $saveData = [
            'menu_is_show' => $menu_is_show,
            'account_id' => $this->user_id,
        ];
        $model_name = 'CompanyProMenu';
        if($id <= 0){// 新加
            $saveData['company_id'] = $company_id;
            $saveData['pro_unit_id'] = $pro_unit_id;
            $resultDatas = $this->createApi($model_name,$saveData,$company_id);
            $id = $resultDatas['id'] ?? 0;
        }else{// 修改
            // 判断权限
            $judgeData = [
                'company_id' => $company_id,
                'pro_unit_id' => $pro_unit_id,
            ];
            $relations = '';
            $this->judgePower($request, $id,$judgeData,$model_name, $company_id,$relations);

            $resultDatas = $this->saveByIdApi($model_name, $id, $saveData, $company_id);
        }
        return ajaxDataArr(1, $resultDatas, '');
    }

    /**
     * ajax保存菜单数据
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function menu_save(Request $request,$pro_unit_id)
    {
        $this->InitParams($request);
        $company_id = $this->company_id;
        $id = Common::getInt($request, 'id');

        if($id < 0){
            throws('参数[id]有误！');
        }

        Common::judgeInitParams($request, 'pro_unit_id', $pro_unit_id);

        $menu_is_show = Common::getInt($request, 'menu_is_show');
        if (!in_array($menu_is_show, [0,1])){
            throws('参数[menu_is_show]必须为整数[0或1]！');
        }

        $resource_id = Common::getInt($request, 'resource_id');
        // Common::judgeInitParams($request, 'resource_id', $resource_id);

        $menu_name = Common::get($request, 'menu_name');
        $menu_url = Common::get($request, 'menu_url');

        $saveData = [
            'menu_is_show' => $menu_is_show,
            'menu_name' => $menu_name,
            'menu_url' => $menu_url,
            'account_id' => $this->user_id,
        ];
        if(is_numeric($resource_id) && $resource_id > 0){

            $saveData['resource_id'] = $resource_id;
        }
        $model_name = 'CompanyProMenu';
        if($id <= 0){// 新加
            $addNewData = [
                'company_id' => $company_id,
                'pro_unit_id' => $pro_unit_id,
            ];
            $saveData = array_merge($saveData, $addNewData);
            $resultDatas = $this->createApi($model_name,$saveData,$company_id);
            $id = $resultDatas['id'] ?? 0;
        }else{// 修改
            // 判断权限
            $judgeData = [
                'company_id' => $company_id,
                'pro_unit_id' => $pro_unit_id,
            ];
            $relations = '';
            $this->judgePower($request, $id,$judgeData,$model_name, $company_id,$relations);

            $resultDatas = $this->saveByIdApi($model_name, $id, $saveData, $company_id);
        }

        // 同步修改图片关系
        $syncDatas = [];
        if(is_numeric($resource_id) && $resource_id > 0) {
            $syncParams = [
                'siteResources' => [$resource_id
//                $resource_id =>[
//                    'company_id' => $company_id,
//                ]
                ],//相关维护人员
            ];
            $syncDatas = $this->saveSyncByIdApi($model_name, $id, $syncParams, $company_id);
        }
        $resluts = [
            'resData' =>   $resultDatas,
            'syncData' =>   $syncDatas,
        ];

        return ajaxDataArr(1, $resluts, '');
    }

}
