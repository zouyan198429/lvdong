<?php
// 公司
namespace App\Models;

class Company extends BaseModel
{

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'company';

    // 一对多
    /**
     * 获取公司的相册 - 二维
     */
    public function photos()
    {
        return $this->hasMany('App\Models\CompanyPhoto', 'company_id', 'id');
    }

    /**
     * 获取公司的公司荣誉 - 二维
     */
    public function honors()
    {
        return $this->hasMany('App\Models\CompanyHonor', 'company_id', 'id');
    }

    /**
     * 获取公司的订单 - 二维
     */
    public function orders()
    {
        return $this->hasMany('App\Models\CompanyOrder', 'company_id', 'id');
    }

    /**
     * 获取公司的备注 - 二维
     */
    public function remarks()
    {
        return $this->hasMany('App\Models\CompanyRemark', 'company_id', 'id');
    }

    /**
     * 获取公司的公司生产单元 - 二维
     */
    public function proUnits()
    {
        return $this->hasMany('App\Models\CompanyProUnit', 'company_id', 'id');
    }

    /**
     * 获取公司的帐号管理 - 二维
     */
    public function accounts()
    {
        return $this->hasMany('App\Models\CompanyAccounts', 'company_id', 'id');
    }

    // 一对多 的反向

    /**
     * 获取公司所属的分类 - 一维
     */
    public function companyType()
    {
        return $this->belongsTo('App\Models\CompanyType', 'company_type_id', 'id');
    }

    /**
     * 获取公司所属的公司等级 - 一维
     */
    public function CompanyRank()
    {
        return $this->belongsTo('App\Models\CompanyRank', 'company_rank_id', 'id');
    }

    /**
     * 获取公司的扩展信息 一维
     */
    public function companyExtend()
    {
        // return $this->hasOne('App\Models\CompanyExtend');
        return $this->hasOne('App\Models\CompanyExtend', 'company_id', 'id');
    }

    /**
     * 设置成立时间
     *
     * @param  string  $value
     * @return string
     */
    public function setCompanyCreatetimeAttribute($value)
    {
        if(empty($value)){
            $this->attributes['company_createtime'] = null;
        }
    }
    /**
     * 设置成立时间
     *
     * @param  string  $value
     * @return string
     */
    public function setCompanyVipbeginAttribute($value)
    {
        if(empty($value)){
            $this->attributes['company_vipbegin'] = null;
        }
    }

    /**
     * 设置成立时间
     *
     * @param  string  $value
     * @return string
     */
    public function setCompanyVipendAttribute($value)
    {
        if(empty($value)){
            $this->attributes['company_vipend'] = null;
        }
    }

    /**
     * 设置成立时间
     *
     * @param  string  $value
     * @return string
     */
    public function setCompanyLastlogintimeAttribute($value)
    {
        if(empty($value)){
            $this->attributes['company_lastlogintime'] = null;
        }
    }

}
