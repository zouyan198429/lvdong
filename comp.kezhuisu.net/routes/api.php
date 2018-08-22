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
// 文件上传
// Route::any('file/upload', 'IndexController@upload');
Route::any('upload', 'UploadController@index');
// Route::any('upload/test', 'UploadController@test');
Route::any('upload/ajax_del', 'UploadController@ajax_del');// 根据id删除文件
// 获得城市
Route::any('area', 'AreaController@getAreaByPid');
Route::any('areaList', 'AreaController@getAreaListByPid');
// 获得生产单元分类
Route::any('unitCls', 'SiteProUnitController@getClsByPid');
Route::any('unitClsList', 'SiteProUnitController@getClsListByPid');
// 帮助中心
Route::any('sys/ajax_alist', 'SysController@ajax_alist');// ajax获得列表数据
Route::any('sys/ajax_info', 'SysController@ajax_info');// 获得详情信息
Route::any('sys/ajax_alist_site_inputs', 'SysController@ajax_alist_site_inputs');// ajax获得列表数据
// 帐号接口
Route::any('accounts/ajax_getAccount', 'AccountsController@ajax_getAccount');// 可根据 unitId 查询企业所有的帐号情况
Route::any('accounts/ajax_alist', 'AccountsController@ajax_alist');// 子帐号管理-ajax获得列表数据
Route::any('accounts/ajax_save', 'AccountsController@ajax_save');// 新加/修改帐号
Route::any('accounts/ajax_del', 'AccountsController@ajax_del');// 删除帐号
Route::any('accounts/ajax_login', 'AccountsController@ajax_login');// 登陆
Route::any('accounts/ajax_login_out', 'AccountsController@ajax_login_out');//  退出登陆
Route::any('accounts/ajax_login_judge', 'AccountsController@ajax_login_judge');//   判断登陆状态是否还在 - 小程序
Route::any('accounts/ajax_reg', 'AccountsController@ajax_reg');// 注册保存
Route::any('accounts/ajax_set_save', 'AccountsController@ajax_set_save');// 资料设置
Route::any('accounts/ajax_password_save', 'AccountsController@ajax_password_save');// 修改密码
Route::any('accounts/ajax_pro_unit', 'AccountsController@ajax_pro_unit');// 小程序实时获取生产单元
Route::any('accounts/ajax_info', 'AccountsController@ajax_info');// 获得详情信息
//用户反馈
Route::any('comment/{pro_unit_id}/ajax_alist', 'CommentController@ajax_alist');// 用户反馈-ajax获得列表数据
Route::any('comment/{pro_unit_id}/ajax_del', 'CommentController@ajax_del');// 删除
Route::any('comment/{pro_unit_id}/ajax_status', 'CommentController@ajax_status');//审核通过/未通过
// 生产投入品
Route::any('inputs/{pro_unit_id}/ajax_alllist', 'InputsController@ajax_alllist');//
Route::any('inputs/{pro_unit_id}/ajax_alist', 'InputsController@ajax_alist');// 生产投入品管理-ajax获得列表数据
Route::any('inputs/{pro_unit_id}/ajax_del', 'InputsController@ajax_del');// 删除
Route::any('inputs/ajax_save', 'InputsController@ajax_save');// 新加/修改帐号

// 公告
Route::any('new/ajax_alist', 'newController@ajax_alist');// ajax获得列表数据
Route::any('new/ajax_test', 'newController@ajax_test');// 测试
Route::any('new/ajax_info', 'newController@ajax_info');// 获得详情信息
// 家事记录
Route::any('handles/{pro_unit_id}/ajax_alllist', 'HandlesController@ajax_alllist');// ajax获得列表[所有]数据
Route::any('handles/{pro_unit_id}/ajax_alist', 'HandlesController@ajax_alist');// ajax获得列表数据
Route::any('handles/{pro_unit_id}/ajax_save', 'HandlesController@ajax_save');// ajax保存数据
Route::any('handles/{pro_unit_id}/ajax_del', 'HandlesController@ajax_del');// 删除

//企业配置
Route::any('tinyweb/{pro_unit_id}/ajax_apply', 'TinyWebController@ajax_apply');// 应用模板
Route::any('tinyweb/{pro_unit_id}/ajax_save', 'TinyWebController@ajax_save');// 修改其它设置-第三方代码
Route::any('tinyweb/{pro_unit_id}/ajax_is_open', 'TinyWebController@ajax_is_open');// 开通/关闭设置
Route::any('tinyweb/{pro_unit_id}/menu_is_show', 'TinyWebController@menu_is_show');// 菜单是否显示设置
Route::any('tinyweb/{pro_unit_id}/menu_save', 'TinyWebController@menu_save');// 菜单新加或修改

// 生产单元
Route::any('productunit/ajax_alist', 'ProductUnitController@ajax_alist');// 生产单元管理-ajax获得列表数据
Route::any('productunit/ajax_del', 'ProductUnitController@ajax_del');// 删除
Route::any('productunit/ajax_save', 'ProductUnitController@ajax_save');// 新加/修改
Route::any('productunit/ajax_info', 'ProductUnitController@ajax_info');// 获得企业信息

// 检测报告
Route::any('report/ajax_del', 'ReportController@ajax_del');// 删除
Route::any('report/ajax_alist/{pro_unit_id}', 'ReportController@ajax_alist');// ajax获得列表
// 反馈
Route::any('report/{pro_unit_id}/ajax_save', 'ReportController@ajax_save');// ajax保存数据

// 企业信息
Route::any('company/ajax_info', 'CompanyController@ajax_info');// 获得企业信息
Route::any('company/ajax_save', 'CompanyController@ajax_save');// 修改
Route::any('company/ajax_img_save', 'CompanyController@ajax_img_save');// 修改--图片
Route::any('company/ajax_intro_save', 'CompanyController@ajax_intro_save');// 修改介绍
// 企业相册
Route::any('photo/ajax_alist', 'PhotoController@ajax_alist');// ajax获得列表数据
Route::any('photo/ajax_save', 'PhotoController@ajax_save');// 修改-相片保存
Route::any('photo/ajax_del', 'PhotoController@ajax_del');// 删除
// 资质证书
Route::any('honor/ajax_alist', 'HonorController@ajax_alist');// ajax获得列表数据
Route::any('honor/ajax_del', 'HonorController@ajax_del');// 删除

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/*
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
*/