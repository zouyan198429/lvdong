<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@index');// 首页
Route::get('test', 'IndexController@test');// 首页
Route::get('login', 'IndexController@login');// 登陆
Route::get('logout', 'IndexController@logout');// 注销
Route::get('qrcode', 'IndexController@qrcode');// 生成二维码

Route::get('sys/', 'SysController@index');// 系统基本设置

Route::get('member/', 'MemberController@index');// 会员管理
Route::get('member/edit/{id}', 'MemberController@edit');// 修改

Route::get('honor/', 'HonorController@index');// 企业资质列表

Route::get('productunit/', 'ProductUnitController@index');// 生产单元

Route::get('photo/', 'PhotoController@index');// 企业相册

Route::get('handles/', 'HandlesController@index');// 生产日志

Route::get('inputs/', 'InputsController@index');// 投入品

Route::get('report/', 'ReportController@index');// 检测报告

Route::get('news/', 'NewsController@index');// 新闻
Route::get('news/edit/{id}', 'NewsController@edit');// 新闻-修改

Route::get('admin/', 'AdminController@index');// 管理员
Route::get('admin/edit/{id}', 'AdminController@edit');// 管理员-修改

Route::get('unitcls/', 'UnitClsController@index');// 生产单元分类
Route::get('unitcls/edit/{id}', 'UnitClsController@edit');// 修改

Route::get('inputcls/', 'InputClsController@index');// 生产投入品分类
Route::get('inputcls/edit/{id}', 'InputClsController@edit');// 修改

Route::get('order/', 'OrderController@index');// 付款记录

Route::get('pages/', 'PagesController@index');// 单页面
Route::get('pages/edit/{id}', 'PagesController@edit');// 单页面-编辑

// 公司类型
Route::get('companyType/', 'CompanyTypeController@index');
Route::get('companyType/edit/{id}', 'CompanyTypeController@edit');// 编辑

// 公司等级
Route::get('companyRank/', 'CompanyRankController@index');
Route::get('companyRank/edit/{id}', 'CompanyRankController@edit');// 编辑

