<?php
// 站点生产投入品
namespace App\Models;


class SiteProInput extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'site_pro_input';

    /**
     * 获取站点生产投入品的企业生产投入品 - 二维
     */
    public function proInputs()
    {
        return $this->hasMany('App\Models\CompanyProInput', 'site_input_id', 'id');
    }

}
