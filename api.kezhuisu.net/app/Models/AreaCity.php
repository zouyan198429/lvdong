<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaCity extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'area_city';

    /**
     * 主键
     *
     * @var string
     */
    protected $primaryKey = 'area_id';

    /**
     * 获取市的省
     */
    public function areaProvince()
    {
        return $this->belongsTo('App\Models\AreaProvince', 'area_code_parent', 'area_code');
    }

    /**
     * 获取任一城市[包括市县乡]的省
     */
    public function cityProvince()
    {
        return $this->belongsTo('App\Models\AreaProvince', 'province_no', 'area_id');
    }

}
