<?php
// 公司农事记录
namespace App\Models;


class CompanyProRecord extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'company_pro_record';

    // 是节点0不是1是
    protected $node_arr = [
        '0' => '',
        '1' => '节点',
    ];

    // 表里没有的字段
    protected $appends = ['node_text'];

    /**
     * 获取用户的状态文字
     *
     * @return string
     */
    public function getNodeTextAttribute()
    {
        return $this->node_arr[$this->is_node] ?? '';
    }

    /**
     * 获取公司农事记录的图片 - 二维
     */
    public function recordPics()
    {
        return $this->hasMany('App\Models\CompanyProRecordPic', 'record_id', 'id');
    }

    /**
     * 公司农事记录的图片[通过中间表company_pro_record_pic 多对多]
     */
    /*
    public function proRecordResource()
    {
        // return $this->belongsToMany('App\Models\test\Role')->withPivot('notice', 'id')->withTimestamps();
        // return $this->belongsToMany('App\Models\test\Role', 'user_roles');// 重写-关联关系连接表的表名
        // 自定义该表中字段的列名;第三个参数是你定义关联关系模型的外键名称，第四个参数你要连接到的模型的外键名称
        return $this->belongsToMany(
            'App\Models\Resource'
            , 'company_pro_record_pic'
            , 'record_id'
            , 'resource_id'
        );
    }
    */

}