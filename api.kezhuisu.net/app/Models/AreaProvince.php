<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaProvince extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'area_province';

    /**
     * 主键
     *
     * @var string
     */
    protected $primaryKey = 'area_id';

    /**
     * 获取省的下级城市 [二维]
     */
    public function citys()
    {
        return $this->hasMany('App\Models\AreaCity', 'area_code_parent', 'area_code');
    }

    /**
     * 获取省下的所有城市[包括市县乡] [二维]
     */
    public function allCitys()
    {
        return $this->hasMany('App\Models\AreaCity', 'province_no', 'area_id');
    }

}
