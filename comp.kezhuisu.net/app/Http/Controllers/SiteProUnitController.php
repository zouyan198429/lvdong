<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Illuminate\Http\Request;

class SiteProUnitController extends LoginController
{
    protected $model_name = 'SiteProUnit';

    /**
     * 根据生产单元分类id获得下级生产单元分类 id=>名称数组
     * @param int $area_id 生产单元分类id 0:第一级城市id
     * @param int $area_level 需要获得的生产单元分类列表等级 1:省;2:市;3:区/县
     * @return array 区域数组 一维数组 array('生产单元分类id'=>'城市名称');
     */
    public function getClsByPid(Request $request){
        //  $this->InitParams($request);
        $area_id = Common::get($request, 'area_id');
        $area_level = Common::get($request, 'level');
        $result = [];
        if($area_level == 1){// 获得第一级
            $area_id = 0;
        }
        // 获得分类
        $relations = '';// 关系
        $queryParams = [
            'where' => [
                ['pro_unit_parent_id', $area_id],
            ],
            'select' => ['id','pro_unit_name'],
            'orderBy' => ['pro_unit_order'=>'desc','id'=>'desc'],
        ];// 查询条件参数
        $resDataList = $this->ajaxGetAllList($this->model_name, '', 0,$queryParams ,'' ,1);
        foreach($resDataList as $v){
            $result[$v['id']] = $v['pro_unit_name'];
        }

        return ajaxDataArr(1, $result, '');
    }

    /**
     * 根据生产单元分类id获得下级生产单元分类 id=>名称数组
     * @param int $area_id 生产单元分类id 0:第一级城市id
     * @param int $area_level 需要获得的生产单元分类列表等级 1:省;2:市;3:区/县
     * @return array 区域数组 一维数组 array('生产单元分类id'=>'城市名称');
     */
    public function getClsListByPid(Request $request){
        //  $this->InitParams($request);
        $area_id = Common::get($request, 'area_id');
        $area_level = Common::get($request, 'level');
        $result = [];
        if($area_level == 1){// 获得第一级
            $area_id = 0;
        }
        // 获得分类
        $relations = '';// 关系
        $queryParams = [
            'where' => [
                ['pro_unit_parent_id', $area_id],
            ],
            'select' => ['id','pro_unit_name'],
            'orderBy' => ['pro_unit_order'=>'desc','id'=>'desc'],
        ];// 查询条件参数
        $resDataList = $this->ajaxGetAllList($this->model_name, '', 0,$queryParams ,'' ,1);
        foreach($resDataList as $v){
            $result[] = [
                'id' => $v['id'],
                'name' => $v['pro_unit_name'],
            ];
        }

        return ajaxDataArr(1, $result, '');
    }
}
