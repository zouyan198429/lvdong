<?php
// 作废--公司生产投入品图片
namespace App\Models;


class CompanyProInputPic extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'company_pro_input_pic';

    /**
     * 获取生产投入品图片所属的投入品 - 一维
     * 投入品对生产投入品图片，1：n的反向
     */
    public function proInput()
    {
        return $this->belongsTo('App\Models\CompanyProInput', 'pro_input_id', 'id');
    }

}
