<?php

namespace App\Models;

class SiteUnitTags extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'site_unit_tags';

    /**
     * 标签所属的公司生产单元记录[通过中间表company_pro_record_tags 多对多]
     */
    public function tagsProUnitRecord()
    {
        // return $this->belongsToMany('App\Models\test\Role')->withPivot('notice', 'id')->withTimestamps();
        // return $this->belongsToMany('App\Models\test\Role', 'user_roles');// 重写-关联关系连接表的表名
        // 自定义该表中字段的列名;第三个参数是你定义关联关系模型的外键名称，第四个参数你要连接到的模型的外键名称
        return $this->belongsToMany(
            'App\Models\CompanyProRecord'
            , 'company_pro_record_tags'
            , 'site_tag_id'
            , 'record_id'
        )->withPivot('company_id', 'id')->withTimestamps();
    }
}
