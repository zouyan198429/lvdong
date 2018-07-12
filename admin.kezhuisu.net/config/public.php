<?php

return [
        'apiUrl' => 'http://api.kezhuisu.com/api/',//'http://api.kezhuisu.com/api/'
        'tinyWebURL' => 'http://m.kezhuisu.com/',
        'apiPath' => [
            'getAllApi' => 'comp/all',//企业帐号记录列表
            'getlistApi' => 'comp/list',//企业帐号记录列表-可分页
            'getinfoApi' => 'comp/info',//根据id获得详情
            'addnewApi' => 'comp/add',//添加记录列表
            'saveApi' => 'comp/save',//修改记录列表
            'saveBathById' => 'comp/saveBathById',//批量修改配置
            'saveSyncByIdApi' => 'comp/sync',//同步修改关系
            'saveByIdApi' => 'comp/saveById',//通过id修改接口
            'delApi' => 'comp/del',//删除记录
            'detachApi' => 'comp/detach',//移除关系
            // 后台特有的
            // 'setSaveApi' => 'admin/save_set',//修改配置
        ],
        'apiSuccesCode' => 1,
        'apiErrorCode' => 0,
    ];