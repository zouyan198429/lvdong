<?php
// 资源表
// TODO 本来想写一个通用方法的，暂时不用就就写了。后面再来考虑。
namespace App\Models;


class Resource extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'resource';

    /**
     * 获取使用该资源的新闻信息[二维对象]
     */
//    public function siteNews()
//    {
//        return $this->morphedByMany(
//            'App\Models\SiteNews'// 站点新闻模型
//            ,'module'// 关系名称-注意：这个值必须是表中 ***_type 的星号部分，暂时还没有指定***_type 这个字段
//            ,'resource_module'// 关系表名称
//            // ,'resource_id'// 关系表中的与资源对象主键对应的字段
//            // ,'module_id' // 关系表中的与新闻表主键对应的字段
//            // ,'id'// 资源对象主键字段名
//            // ,'id'// 主表新闻主键字段名
//        )->withTimestamps();// ->withPivot('notice', 'id')
//    }

    /**
     * 获取使用该资源的模块信息[二维对象] TODO 通用方法，需要用with 渴求式加载来减少请求次数 ，所以这个方法不能有参数
     * $modelNameSpace
     */
//    public function getModelsObj($modelNameSpace = null)
//    {
//        return $this->morphedByMany(
//            'App\Models\SiteNews'// 站点新闻模型
//            ,'module'// 关系名称-注意：这个值必须是表中 ***_type 的星号部分，暂时还没有指定***_type 这个字段
//            ,'resource_module'// 关系表名称
//        // ,'resource_id'// 关系表中的与资源对象主键对应的字段
//        // ,'module_id' // 关系表中的与新闻表主键对应的字段
//        // ,'id'// 资源对象主键字段名
//        // ,'id'// 主表新闻主键字段名
//        )->withTimestamps();// ->withPivot('notice', 'id')
//    }


}
