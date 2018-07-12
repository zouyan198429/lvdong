<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyExtend extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'company_extend';

    /**
     * 获取拥有该扩展的企业 一维
     */
    public function belongCompany()
    {
        //return $this->belongsTo('App\Models\Company')->withDefault();
        return $this->belongsTo('App\Models\Company', 'company_id', 'id')->withDefault();
    }

}
