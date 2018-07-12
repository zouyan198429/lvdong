<?php
// 用户访问唯一统计
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitetVisitUnique extends BaseModel
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'sitet_visit_unique';

}
