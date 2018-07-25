<?php

namespace App\Http\Controllers;

use App\Services\Common;
use Illuminate\Http\Request;

class AreaController extends LoginController
{
    protected $model_name = 'AreaCity';

    /**
     * 根据城市id获得下级城市 id=>名称数组
     * @param int $area_id 城市id 0:第一级城市id
     * @param int $area_level 需要获得的城市列表等级 1:省;2:市;3:区/县
     * @return array 区域数组 一维数组 array('城市id'=>'城市名称');
     */
    public function getAreaByPid(Request $request){
       //  $this->InitParams($request);
        $area_id = Common::get($request, 'area_id');
        $area_level = Common::get($request, 'level');
        $result = [];
        if($area_level == 1){// 获得省
            // 获得分类
            $relations = '';// 关系
            $queryParams = [
//            'where' => [
//                ['company_id', $this->company_id],
//                ['pro_unit_id', $pro_unit_id],
//            ],
               'select' => ['area_code','province_name'],
                //'orderBy' => ['area_id'=>'asc'],
            ];// 查询条件参数
            $resDataList = $this->ajaxGetAllList('AreaProvince', '', 0,$queryParams ,'' ,1);
            foreach($resDataList as $v){
                $result[$v['area_code']] = $v['province_name'];
            }
        }else{// 获得城市或县区
            // 获得分类
            $relations = '';// 关系
            $queryParams = [
                'where' => [
                    ['area_code_parent', $area_id],
                ],
                'select' => ['area_code','city_name'],
                //'orderBy' => ['area_id'=>'asc'],
            ];// 查询条件参数
            $resDataList = $this->ajaxGetAllList('AreaCity', '', 0,$queryParams ,'' ,1);
            foreach($resDataList as $v){
                $result[$v['area_code']] = $v['city_name'];
            }

        }

        return ajaxDataArr(1, $result, '');
    }
    /**
     * 根据城市id获得下级城市 id=>名称数组
     * @param int $area_id 城市id 0:第一级城市id
     * @param int $area_level 需要获得的城市列表等级 1:省;2:市;3:区/县
     * @return array 区域数组 一维数组 array('城市id'=>'城市名称');
     */
    public function getAreaListByPid(Request $request){
        //  $this->InitParams($request);
        $area_id = Common::get($request, 'area_id');
        $area_level = Common::get($request, 'level');
        $result = [];
        if($area_level == 1){// 获得省
            // 获得分类
            $relations = '';// 关系
            $queryParams = [
//            'where' => [
//                ['company_id', $this->company_id],
//                ['pro_unit_id', $pro_unit_id],
//            ],
                'select' => ['area_code','province_name'],
                //'orderBy' => ['area_id'=>'asc'],
            ];// 查询条件参数
            $resDataList = $this->ajaxGetAllList('AreaProvince', '', 0,$queryParams ,'' ,1);
            foreach($resDataList as $v){
                // $result[$v['area_code']] = $v['province_name'];
                $result[] = [
                    'id' => $v['area_code'],
                    'name' => $v['province_name'],
                ];
            }
        }else{// 获得城市或县区
            // 获得分类
            $relations = '';// 关系
            $queryParams = [
                'where' => [
                    ['area_code_parent', $area_id],
                ],
                'select' => ['area_code','city_name'],
                //'orderBy' => ['area_id'=>'asc'],
            ];// 查询条件参数
            $resDataList = $this->ajaxGetAllList('AreaCity', '', 0,$queryParams ,'' ,1);
            foreach($resDataList as $v){
                // $result[$v['area_code']] = $v['city_name'];
                $result[] = [
                    'id' => $v['area_code'],
                    'name' => $v['city_name'],
                ];
            }

        }

        return ajaxDataArr(1, $result, '');
    }
}
