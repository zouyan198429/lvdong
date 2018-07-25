<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::any('ajax_login', 'IndexController@ajax_login');// 登陆
//系统基本设置
Route::any('sys/ajax_save', 'SysController@ajax_save');// 保存
// 获得城市
Route::any('area', 'AreaController@getAreaByPid');

//会员列表
Route::any('member/ajax_alist', 'MemberController@ajax_alist');
Route::any('member/ajax_save', 'MemberController@ajax_save');// 新加/修改
Route::any('member/ajax_del', 'MemberController@ajax_del');// 删除
//相册
Route::any('photo/ajax_alist', 'PhotoController@ajax_alist');// ajax获得列表数据

// 单页面
Route::any('pages/ajax_alist', 'PagesController@ajax_alist');// ajax获得列表数据
Route::any('pages/ajax_save', 'PagesController@ajax_save');// 新加/修改
Route::any('pages/ajax_del', 'PagesController@ajax_del');// 删除
// 生产投入品分类
Route::any('inputcls/ajax_alist', 'InputClsController@ajax_alist');// ajax获得列表数据
Route::any('inputcls/ajax_save', 'InputClsController@ajax_save');// 新加/修改
Route::any('inputcls/ajax_del', 'InputClsController@ajax_del');// 删除

// 生产单元分类
Route::any('unitcls/ajax_alist', 'UnitClsController@ajax_alist');// ajax获得列表数据
Route::any('unitcls/ajax_save', 'UnitClsController@ajax_save');// 新加/修改
Route::any('unitcls/ajax_del', 'UnitClsController@ajax_del');// 删除

// 管理员
Route::any('admin/ajax_alist', 'AdminController@ajax_alist');// ajax获得列表数据
Route::any('admin/ajax_save', 'AdminController@ajax_save');// 新加/修改
Route::any('admin/ajax_del', 'AdminController@ajax_del');// 删除

// 新闻
Route::any('news/ajax_alist', 'NewsController@ajax_alist');// ajax获得列表数据
Route::any('news/ajax_save', 'NewsController@ajax_save');// 新加/修改
Route::any('news/ajax_del', 'NewsController@ajax_del');// 删除
// 检测报告
Route::any('report/ajax_alist', 'ReportController@ajax_alist');// ajax获得列表数据

// 投入品
Route::any('inputs/ajax_alist', 'InputsController@ajax_alist');// ajax获得列表数据

// 生产日志
Route::any('handles/ajax_alist', 'HandlesController@ajax_alist');// ajax获得列表数据

// 企业资质列表
Route::any('honor/ajax_alist', 'HonorController@ajax_alist');// ajax获得列表数据
Route::any('honor/ajax_save', 'HonorController@ajax_save');// 新加/修改
Route::any('honor/ajax_del', 'HonorController@ajax_del');// 删除
Route::any('honor/ajax_status', 'HonorController@ajax_status');//审核通过/未通过

// 公司类型
Route::any('companyType/ajax_alist', 'CompanyTypeController@ajax_alist');// ajax获得列表数据
Route::any('companyType/ajax_save', 'CompanyTypeController@ajax_save');// 新加/修改
Route::any('companyType/ajax_del', 'CompanyTypeController@ajax_del');// 删除


// 公司等级
Route::any('companyRank/ajax_alist', 'CompanyRankController@ajax_alist');// ajax获得列表数据
Route::any('companyRank/ajax_save', 'CompanyRankController@ajax_save');// 新加/修改
Route::any('companyRank/ajax_del', 'CompanyRankController@ajax_del');// 删除
//生产单元
Route::any('productunit/ajax_alist', 'ProductUnitController@ajax_alist');// ajax获得列表数据
Route::any('productunit/ajax_del', 'ProductUnitController@ajax_del');// 删除
Route::any('productunit/ajax_status', 'ProductUnitController@ajax_status');//审核通过/未通过
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//Route::post('file/upload', function(\Illuminate\Http\Request $request) {
//    if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
//        $photo = $request->file('photo');
//        $extension = $photo->extension();
//        //$store_result = $photo->store('photo');
//        $store_result = $photo->storeAs('photo', 'test.jpg');
//        $output = [
//            'extension' => $extension,
//            'store_result' => $store_result
//        ];
//        print_r($output);exit();
//    }
//    exit('未获取到上传文件或上传过程出错');
//});