<?php
// 公司生产单元微站设置
namespace App\Models;


class CompanyProConfig extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'company_pro_config';

    /**
     * 获取公司生产单元微站设置的公司生产单元
     */
    public function companyProUnitByConfig()
    {
        return $this->belongsTo('App\Models\CompanyProUnit', 'pro_unit_id', 'id')->withDefault();
    }

    /**
     * 获取公司生产单元微站设置[模板id]所属的站点微店模板 - 一维
     * 站点微店模板对微站设置[模板id]，1：n的反向
     */
    public function siteTinyWebTemplate()
    {
        return $this->belongsTo('App\Models\SiteTinyWebTemplate', 'site_template_id', 'id');
    }

}
