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
     * 获取公司的省 一维
     */
    public function province()
    {
        return $this->hasOne('App\Models\AreaProvince', 'area_code', 'province_id');
    }

    /**
     * 获取公司的市 一维
     */
    public function city()
    {
        return $this->hasOne('App\Models\AreaCity', 'area_code', 'city_id');
    }

    /**
     * 获取公司的县/区 一维
     */
    public function area()
    {
        return $this->hasOne('App\Models\AreaCity', 'area_code', 'area_id');
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
        }else{
            $this->attributes['company_createtime'] = $value;
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
        }else{
            $this->attributes['company_vipbegin'] = $value;
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
        }else{
            $this->attributes['company_vipend'] = $value;
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
        }else{
            $this->attributes['company_lastlogintime'] = $value;
        }
    }

}
