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

Route::get('/test', 'IndexController@test');// 测试
Route::get('/', 'IndexController@index');// 首页
Route::get('reg', 'IndexController@reg');// 注册
Route::get('login', 'IndexController@login');// 登陆
Route::get('logout', 'IndexController@logout');// 注销
Route::get('404', 'IndexController@err404');// 404错误

Route::get('company/', 'CompanyController@index');// 企业信息
Route::any('company/intro_save', 'CompanyController@intro_save');// 修改介绍

Route::get('sys/pay', 'SysController@pay');// 在线支付
Route::get('sys/help/', 'SysController@helpList');// 帮助中心
Route::get('sys/help/{intro_id}', 'SysController@help');// 帮助中心
Route::get('sys/aboutus', 'SysController@aboutus');// 关于我们
Route::get('sys/policy', 'SysController@policy');// 服务协议
Route::get('sys/legalnotice', 'SysController@legalnotice');// 法律声明

Route::get('productunit/', 'ProductUnitController@index');// 生产单元管理
Route::get('productunit/add/{id}', 'ProductUnitController@add');// 申请生产单元

Route::get('photo/', 'PhotoController@index');// 企业相册

Route::get('report/{pro_unit_id}', 'ReportController@index');// 检测报告

Route::get('new/', 'newController@index');// 公告
Route::get('new/{id}', 'newController@info');// 公告详情

Route::get('handles/{pro_unit_id}', 'HandlesController@index');// 农事记录
Route::get('handles/add/{pro_unit_id}/{id}', 'HandlesController@add');// 农事记录-添加

Route::get('inputs/{pro_unit_id}', 'InputsController@index');// 生产投入品
Route::get('inputs/{pro_unit_id}/add/{id}', 'InputsController@add');// 生产投入品-添加

Route::get('accounts/', 'AccountsController@index');// 子帐号管理
Route::get('accounts/add/{id}', 'AccountsController@add');// 子帐号管理-添加
Route::get('accounts/set', 'AccountsController@set');// 资料设置
Route::get('accounts/mypass', 'AccountsController@mypass');// 修改密码

Route::get('comment/{pro_unit_id}', 'CommentController@index');// 用户反馈

Route::get('tinyweb/{pro_unit_id}', 'TinyWebController@index');// 微站-底部导航

Route::get('count/', 'CountController@index');// 数据统计

