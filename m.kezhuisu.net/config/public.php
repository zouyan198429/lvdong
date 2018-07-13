<?php

return [
        'apiUrl' => 'http://api.kezhuisu.net/api/',//'http://api.kezhuisu.com/api/'
        'apiPath' => [
            'indexPage' => 'm/',//首页接口地址
            'inputInfoPage'=> 'm/input_info',//投入品-详情
            'handlesPage'=> 'm/unit',//生产记录
            'inputsPage'=> 'm/input',//投入品记录
            'companyPage'=> 'm/company',//企业信息
            'companyIntroPage'=> 'm/company/intro',//企业信息-介绍
            'commentsPage'=> 'm/report',//反馈
            // 公共接口
            'getAllApi' => 'comp/all',//企业帐号记录列表
            'getlistApi' => 'comp/list',//企业帐号记录列表-可分页
            'getinfoApi' => 'comp/info',//根据id获得详情
            'addnewApi' => 'comp/add',//添加记录列表
            'saveApi' => 'comp/save',//修改记录列表
            'saveSyncByIdApi' => 'comp/sync',//同步修改关系
            'saveByIdApi' => 'comp/saveById',//通过id修改接口
            'delApi' => 'comp/del',//删除记录
            'detachApi' => 'comp/detach',//移除关系
        ],
        'apiSuccesCode' => 1,
        'apiErrorCode' => 0,
    ];