<?php
// 站点微店模板
namespace App\Models;


class SiteTinyWebTemplate extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'site_tinyweb_template';

    /**
     * 获取站点微店模板的公司生产单元微站设置[模板id] - 二维
     */
    public function companyProConfigs()
    {
        return $this->hasMany('App\Models\CompanyProConfig', 'site_template_id', 'id');
    }

}
