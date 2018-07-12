<?php
// 用户反馈
namespace App\Models;


class CompanyProComment extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'company_pro_comment';

    // 状态0待审核1审核通过2审核未通过
    protected $status_arr = [
        '0' => '待审核',
        '1' => '审核通过',
        '2' => '审核未通过',
    ];

    // 表里没有的字段
    protected $appends = ['status_text'];

    /**
     * 获取用户的状态文字
     *
     * @return string
     */
    public function getstatusTextAttribute()
    {
        return $this->status_arr[$this->status] ?? '';
    }

}
