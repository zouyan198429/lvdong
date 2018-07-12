<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Illuminate\Http\Request;

class PhotoController extends LoginController
{
    protected $model_name = 'CompanyPhoto';

    /**
     * 企业相册
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);
        // 获得列表
        $relations = ['siteResources'];// 关系
        $queryParams = [
            'where' => [
                ['company_id', $this->company_id],
            ],
            'orderBy' => ['id'=>'desc'],
        ];// 查询条件参数
        $photosList = $this->ajaxGetAllList($this->model_name, '', $this->company_id,$queryParams ,$relations );

        return view('photo.index',['photosList' =>$photosList]);
    }

    /**
     * -删除
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function ajax_del(Request $request)
    {
        $this->InitParams($request);
        $id = Common::getInt($request, 'id');

        if(empty($id)){
            return ajaxDataArr(0, null, '参数错误!!');
        }

        $queryParams =[// 查询条件参数
            'where' => [
                ['id', $id],
                ['company_id', $this->company_id],
            ]
        ];

        // 判断权限
        $judgeData = [
            'company_id' => $this->company_id,
        ];
        $relations = ['siteResources'];
        $infoData =$this->judgePower($request, $id,$judgeData,$this->model_name, $this->company_id,$relations);
        $resources = $infoData['site_resources'] ?? [];
        $this->resourceDelFile($resources);// 删除资源
        // 删除与图片的关系
        // 无删除移除关系表--注意要先删除关系
        $detachParams =[
            'siteResources' => [],//相关维护人员
        ];
        $detachDatas = $this->detachByIdApi($this->model_name, $id, $detachParams, $this->company_id, 0);

        $resultDatas = $this->ajaxDelApi($this->model_name, $this->company_id , $queryParams);

        $resluts = [
            'resData' =>   $resultDatas,
            'detachDatas' =>   $detachDatas,
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
        $company_id = $this->company_id;

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
            $resultDatas = $this->createApi($this->model_name, $saveData, $company_id);
            $id = $resultDatas['id'] ?? 0;
        } else {// 修改
            // 判断权限
            $judgeData = [
                'company_id' => $company_id,
            ];
            $relations = '';
            $this->judgePower($request, $id, $judgeData, $this->model_name, $company_id, $relations);

            $resultDatas = $this->saveByIdApi($this->model_name, $id, $saveData, $company_id);

        }
        // 同步修改图片关系
        $syncParams =[
            'siteResources' => $resource_id,
        ];
        $syncDatas = $this->saveSyncByIdApi($this->model_name, $id, $syncParams, $company_id);

        $resluts = [
            'resData' =>   $resultDatas,
            'syncData' =>   $syncDatas,
        ];

        return ajaxDataArr(1, $resluts, '');
    }

}
