<?php
//防伪标签
namespace App\Models;

class CompanyProSecurityLabel extends BaseModel
{
    // 状态
    protected $status_arr = [
        '0' => '未使用',
        '1' => '已使用',
    ];

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'company_pro_security_label';

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

    /**
     * 获取防伪标签对应的生产单元
     */
    public function proUnit()
    {
        // return $this->belongsTo('App\Models\CompanyProUnit');
        return $this->belongsTo('App\Models\CompanyProUnit', 'pro_unit_id', 'id');
    }

}
