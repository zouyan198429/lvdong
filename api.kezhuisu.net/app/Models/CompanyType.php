<?php
// 公司类型
namespace App\Models;


class CompanyType extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'company_type';

    /**
     * 获取公司类型的公司 - 二维
     */
    public function companys()
    {
        return $this->hasMany('App\Models\Company', 'company_type_id', 'id');
    }

}
