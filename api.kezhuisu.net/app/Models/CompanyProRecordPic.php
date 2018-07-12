<?php
// 公司农事记录图片

namespace App\Models;


class CompanyProRecordPic extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'company_pro_record_pic';

    /**
     * 获取公司农事记录图片所属的农事记录 - 一维
     * 农事记录对图片，1：n的反向
     */
    public function proRecord()
    {
        return $this->belongsTo('App\Models\company_pro_record', 'record_id', 'id');
    }

}
