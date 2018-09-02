<?php
// 公司生产单元
namespace App\Models;


class CompanyProUnit extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'company_pro_unit';

    // 状态0待审核1审核通过2审核未通过
    protected $status_arr = [
        '0' => '待审核',
        '1' => '审核通过',
        '2' => '审核未通过',
        '3' => '过期',
        '4' => '已结束',
    ];

    // 表里没有的字段
    protected $appends = ['status_text'];

    /**
     * 获取用户的状态文字
     *
     * @return string
     */
    public function getStatusTextAttribute()
    {
        return $this->status_arr[$this->status] ?? '';
    }


    // 一对多

    /**
     * 获取生产单元的公司生产单元维护人 - 二维
     */
    public function unitAccounts()
    {
        return $this->hasMany('App\Models\CompanyProUnitAccounts', 'pro_unit_id', 'id');
    }

    /**
     * 获取生产单元的用户反馈 - 二维
     */
    public function proComments()
    {
        return $this->hasMany('App\Models\CompanyProComment', 'pro_unit_id', 'id');
    }

    /**
     * 获取生产单元的公司农事记录 - 二维
     */
    public function proRecords()
    {
        return $this->hasMany('App\Models\CompanyProRecord', 'pro_unit_id', 'id');
    }

    /**
     * 获取生产单元的公司生产投入品 - 二维
     */
    public function proInputs()
    {
        return $this->hasMany('App\Models\CompanyProInput', 'pro_unit_id', 'id');
    }

    /**
     * 获取生产单元的检测报告 - 二维
     */
    public function proReports()
    {
        return $this->hasMany('App\Models\CompanyProReport', 'pro_unit_id', 'id');
    }

    /**
     * 获取生产单元的微站菜单 - 二维
     */
    public function proMenus()
    {
        return $this->hasMany('App\Models\CompanyProMenu', 'pro_unit_id', 'id');
    }

    /**
     * 获取生产单元的防伪标签
     */
    public function securityLabel()
    {
        // return $this->hasMany('App\Models\CompanyProSecurityLabel');
        return $this->hasMany('App\Models\CompanyProSecurityLabel', 'pro_unit_id', 'id');
    }
    /**
     * 获取企业生产单元所属的站点生产单元 - 一维
     * 1：n的反向
     */
    public function siteProUnit()
    {
        return $this->belongsTo('App\Models\SiteProUnit', 'site_pro_unit_id', 'id');
    }

    // 一对一

    /**
     * 获取公司生产单元关联到公司生产单元微站设置
     */
    public function companyProConfig()
    {
        return $this->hasOne('App\Models\CompanyProConfig', 'pro_unit_id', 'id');
    }

    /**
     * 获取第一级生产单元分类 一维
     */
    public function firstSiteUnit()
    {
        return $this->hasOne('App\Models\SiteProUnit', 'id', 'site_pro_unit_id');
    }

    /**
     * 获取第二级生产单元分类 一维
     */
    public function secondSiteUnit()
    {
        return $this->hasOne('App\Models\SiteProUnit', 'id', 'site_pro_unit_id_two');
    }

    // 多对多
    /**
     * 公司生产单元的管理帐号[通过中间表company_pro_unit_accounts 多对多]
     */
    public function proUnitAccounts()
    {
        // return $this->belongsToMany('App\Models\test\Role')->withPivot('notice', 'id')->withTimestamps();
        // return $this->belongsToMany('App\Models\test\Role', 'user_roles');// 重写-关联关系连接表的表名
        // 自定义该表中字段的列名;第三个参数是你定义关联关系模型的外键名称，第四个参数你要连接到的模型的外键名称
        return $this->belongsToMany(
            'App\Models\CompanyAccounts'
            , 'company_pro_unit_accounts'
            , 'pro_unit_id'
            , 'account_id'
        )->withTimestamps();
    }

}
