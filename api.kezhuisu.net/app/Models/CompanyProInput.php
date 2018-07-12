<?php
// 公司生产投入品
namespace App\Models;


class CompanyProInput extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'company_pro_input';

    /**
     * 获取生产投入品的生产投入品图片 - 二维
     */
    public function inputPics()
    {
        return $this->hasMany('App\Models\CompanyProInputPic', 'pro_input_id', 'id');
    }

    /**
     * 获取公司生产投入品所属的站点生产投入品 - 一维
     * 站点生产投入品对公司生产投入品，1：n的反向
     */
    public function siteProInput()
    {
        return $this->belongsTo('App\Models\SiteProInput', 'site_input_id', 'id');
    }

}
