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

// 通用公共接口,不需要任何参数
// any(
// 手机站访问接口,其它参数 企业id-company_id; 生产单元id unit_id;
 Route::post('m/', 'TinyWeb\TinyWebController@index');// 首页生产单元信息
 Route::post('m/unit', 'TinyWeb\TinyWebController@unit');// 生产记录信息
 Route::post('m/input', 'TinyWeb\TinyWebController@input');// 投入品信息
Route::post('m/report_list', 'TinyWeb\TinyWebController@reportList');// 检测报告记录-列表
 Route::post('m/input_info', 'TinyWeb\TinyWebController@inputInfo');// 投入品信息详情
 Route::post('m/company', 'TinyWeb\TinyWebController@company');// 企业信息
 Route::post('m/company/intro', 'TinyWeb\TinyWebController@companyIntro');// 企业信息-介绍
 Route::post('m/report', 'TinyWeb\TinyWebController@report');// 反馈
 Route::post('m/search_label', 'TinyWeb\TinyWebController@searchLabel');// 防伪标签查询
 Route::post('m/incRedHeart', 'TinyWeb\TinyWebController@incRedHeart');// ajax保存点赞数据
Route::post('m/incRecordRedHeart', 'TinyWeb\TinyWebController@incRecordRedHeart');// ajax保存记录点赞数据

 Route::post('m/create_label', 'TinyWeb\TinyWebController@create_label');// 生成防伪标签

// 农场主后台接口
// 通用接口
Route::post('comp/index', 'Comp\CommonController@index');// 首页-农场主后台
Route::post('comp/admin', 'Comp\CommonController@admin');// 首页-大后台
Route::post('comp/all', 'Comp\CommonController@all');// 获得所有列表接口
Route::post('comp/list', 'Comp\CommonController@list');// 获得列表接口
Route::post('comp/info', 'Comp\CommonController@getInfo');// 获得id详情接口
Route::post('comp/add', 'Comp\CommonController@add');// 新加接口
Route::post('comp/addBath', 'Comp\CommonController@addBath');// 批量新加接口-data只能返回成功true:失败:false
Route::post('comp/addBathById', 'Comp\CommonController@addBathByPrimaryKey');// 批量新加接口-data返回成功的id数组
Route::post('comp/saveDecIncByQuery', 'Comp\CommonController@saveDecIncByQuery');// 自增自减接口,通过条件-data操作的行数
Route::post('comp/saveDecIncByArr', 'Comp\CommonController@saveDecIncByArr');// 批量自增自减接口,通过数组[二维]-data操作的行数数组
Route::post('comp/save', 'Comp\CommonController@save');// 修改接口
Route::post('comp/saveById', 'Comp\CommonController@saveById');// 通过id修改接口
Route::post('comp/saveBathById', 'Comp\CommonController@saveBathById');// 通过主健批量修改接口
Route::post('comp/del', 'Comp\CommonController@del');// 根据条件删除接口
Route::post('comp/sync', 'Comp\CommonController@sync');// 同步修改关系接口
Route::post('comp/detach', 'Comp\CommonController@detach');// 移除关系接口

// 大后台

Route::post('proUnit/countLabels', 'CompanyProUnitController@countLabels');// 统计生产单元下的标签

Route::post('proUnit/countUnits', 'CompanyProUnitController@countUnits');// 统计生产单元下的日志、投入品、检测报告

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', function () {
    return config('public.apiUrl');
    return App\Models\Company::paginate();
});


Route::get('test', 'TestController@index');// 测试
Route::post('file/upload', function(\Illuminate\Http\Request $request) {
    if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
        $photo = $request->file('photo');
        $extension = $photo->extension();
        //$store_result = $photo->store('photo');
        $store_result = $photo->storeAs('photo', 'test.jpg');
        $output = [
            'extension' => $extension,
            'store_result' => $store_result
        ];
        print_r($output);exit();
    }
    exit('未获取到上传文件或上传过程出错');
});