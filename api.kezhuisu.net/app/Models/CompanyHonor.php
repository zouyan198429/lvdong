<?php
// 公司荣誉

namespace App\Models;


class CompanyHonor extends BaseModel
{
    // 状态 0待审核1审核通过2审核未通过
    protected $status_arr = [
        '0' => '待审核',
        '1' => '审核通过',
        '2' => '审核未通过',
    ];

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'company_honor';

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

}
