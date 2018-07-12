<?php
// 站点新闻
namespace App\Models;


class SiteNews extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'site_news';

    /**
     * 获取指定新闻所有图片资源
     */
//    public function resources()
//    {
//        return $this->morphToMany(
//            'App\Models\Resource'//资源对象
//            ,'module' // 关系名称-注意：这个值必须是表中 ***_type 的星号部分，暂时还没有指定***_type 这个字段
//            ,'resource_module'// 关系表名称
//            // ,'module_id'// 关系表中的与新闻表主键对应的字段
//            // ,'resource_id'// 关系表中的与资源对象主键对应的字段
//            // ,'id'// 主表新闻主键字段名
//            // ,'id'// 资源对象主键字段名
//            // ,$inverse 参数 flase[默认]，module_type 可以在 AppServiceProvider 中指定段名; true： 必须用App\Models\Resource
//        )->withTimestamps();// ->withPivot('notice', 'id')
//    }

}
