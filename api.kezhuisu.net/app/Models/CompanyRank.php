<?php
// 公司等级
namespace App\Models;


class CompanyRank extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'company_rank';

    /**
     * 获取公司类型的公司 - 二维
     */
    public function companys()
    {
        return $this->hasMany('App\Models\Company', 'company_rank_id', 'id');
    }

}
