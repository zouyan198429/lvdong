<?php
// 帐号管理
namespace App\Models;



class CompanyAccounts extends BaseModel
{
    // 状态
    protected $account_status_arr = [
        '0' => '正常',
        '1' => '冻结',
    ];

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'company_accounts';

    /**
     * 在数组中隐藏的属性
     *
     * @var array
     */
    protected $hidden = ['account_password'];

    // 表里没有的字段
    protected $appends = ['account_statu_text'];

    /**
     * 获取用户的状态文字
     *
     * @return string
     */
    public function getAccountStatuTextAttribute()
    {
        return $this->account_status_arr[$this->account_status] ?? '';
    }

    /**
     * 获取用户的全名
     *
     * @return string
     */
//    public function getFullNameAttribute()
//    {
//        return "{$this->first_name} {$this->last_name}";
//    }

    /**
     * 设置帐号的密码md5加密
     *
     * @param  string  $value
     * @return string
     */
    public function setAccountPasswordAttribute($value)
    {
        $this->attributes['account_password'] = md5($value);
    }

    // 一对多

    /**
     * 获取帐号管理的公司生产单元维护人 - 二维
     */
    public function companyProUnitAccounts()
    {
        return $this->hasMany('App\Models\CompanyProUnitAccounts', 'account_id', 'id');
    }

    /**
     * 获取帐号管理的用户反馈信息 - 二维
     */
    public function companyProComments()
    {
        return $this->hasMany('App\Models\CompanyProComment', 'account_id', 'id');
    }

    /**
     * 获取帐号管理的公司农事记录信息 - 二维
     */
    public function companyProRecords()
    {
        return $this->hasMany('App\Models\CompanyProRecord', 'account_id', 'id');
    }


    /**
     * 获取帐号管理的公司生产投入品信息 - 二维
     */
    public function companyProInputs()
    {
        return $this->hasMany('App\Models\CompanyProInput', 'account_id', 'id');
    }


    /**
     * 获取帐号管理的检测报告信息 - 二维
     */
    public function companyProReports()
    {
        return $this->hasMany('App\Models\CompanyProReport', 'account_id', 'id');
    }

    /**
     * 用户管理的生产单元
     */
    public function accountProUnits()
    {
        // 自定义该表中字段的列名;第三个参数是你定义关联关系模型的外键名称，第四个参数你要连接到的模型的外键名称
        return $this->belongsToMany('App\Models\CompanyProUnit', 'company_pro_unit_accounts', 'account_id', 'pro_unit_id')->withPivot('company_id')->withTimestamps();
    }
}
