<?php
// 用户访问统计
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitetVisitCount extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'sitet_visit_count';

}
