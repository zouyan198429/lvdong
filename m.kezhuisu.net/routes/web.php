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

Route::get('/{pro_unit_id}', 'IndexController@index');// 首页

Route::get('antifake/{pro_unit_id}/{label_num}', 'IndexController@security_label');// 首页

Route::get('handles/{pro_unit_id}', 'HandlesController@index');// 生产记录

Route::get('inputs/{pro_unit_id}', 'InputsController@index');// 投入品
Route::get('inputs/info/{pro_unit_id}/{id}', 'InputsController@info');// 投入品-详情

Route::get('company/{pro_unit_id}', 'CompanyController@index');// 企业信息
Route::get('company/intro/{pro_unit_id}', 'CompanyController@intro');// 企业信息-公司介绍

Route::get('comment/{pro_unit_id}', 'CommentController@index');// 反馈
Route::post('comment/{pro_unit_id}/save', 'CommentController@save');// 反馈-保存
Route::get('comment/star/{pro_unit_id}', 'CommentController@star');// 反馈-星级

