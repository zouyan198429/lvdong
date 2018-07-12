<?php
// 站点生产单元
namespace App\Models;


class SiteProUnit extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'site_pro_unit';

    /**
     * 获取站点生产单元的企业生产单元 - 二维
     */
    public function companyProUnits()
    {
        return $this->hasMany('App\Models\CompanyProUnit', 'site_pro_unit_id', 'id');
    }

}
