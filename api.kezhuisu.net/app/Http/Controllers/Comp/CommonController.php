<?php

namespace App\Http\Controllers\Comp;

use App\Exceptions\ExportException;
use App\Services\Common;
use Illuminate\Http\Request;
use App\Http\Controllers\CompController;
use Illuminate\Support\Facades\DB;

class CommonController extends CompController
{
    /**
     * 获得所有列表接口
     *
     * @param int $company_id 公司id
     * @param string $Model_name model名称
     * @param string $queryParams 条件数组/json字符
     * @param string $relations 关系数组/json字符
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function all(Request $request)
    {
        $this->InitParams($request);

        return Common::requestAllDataByModel($request);
    }

    /**
     * 获得列表接口
     *
     * @param int $company_id 公司id
     * @param string $Model_name model名称
     * @param string $queryParams 条件数组/json字符
     * @param string $relations 关系数组/json字符
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function list(Request $request)
    {
        $this->InitParams($request);

        return Common::requestListDataByModel($request);
    }

    /**
     * 根据id获得详情
     *
     * @param string $Model_name model名称
     * @param int $id
     * @param string $relations 关系数组/json字符
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function getInfo(Request $request)
    {
        $this->InitParams($request);
        return Common::requestInfoByID($request);
    }

    /**
     * 新加接口
     *
     * @param int $company_id 公司id
     * @param string $Model_name model名称
     * @param string $dataParams 字段数组/json字符
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function add(Request $request)
    {
        $this->InitParams($request);
        return Common::requestCreate($request);
    }

    /**
     * 修改接口
     *
     * @param int $company_id 公司id
     * @param string $Model_name model名称
     * @param string $dataParams 字段数组/json字符
     * @param string $queryParams 条件数组/json字符
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function save(Request $request)
    {
        $this->InitParams($request);
        return Common::requestUpdate($request);
    }


    /**
     * 批量修改设置
     *
     * @param string $Model_name model名称
     * @param string $primaryKey 主键字段,默认为id
     * @param string $dataParams 主键及要修改的字段值 二维数组 数组/json字符
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function saveBathById(Request $request)
    {
        $this->InitParams($request);
        return Common::batchSaveByPrimaryKey($request);
    }

    /**
     * 通过id修改接口
     *
     * @param int $company_id 公司id
     * @param string $Model_name model名称
     * @param string $dataParams 字段数组/json字符
     * @param string $queryParams 条件数组/json字符
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function saveById(Request $request)
    {
        $this->InitParams($request);
        return Common::requestSave($request);
    }

    /**
     * 根据条件删除接口
     *
     * @param int $company_id 公司id
     * @param string $Model_name model名称
     * @param string $queryParams 条件数组/json字符
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function del(Request $request)
    {
        $this->InitParams($request);

        return Common::requestDel($request);
    }

    /**
     * 同步修改关系接口
     *
     * @param string $Model_name model名称
     * @param int $id
     * @param string/array $synces 同步关系数组/json字符
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function sync(Request $request)
    {
        $this->InitParams($request);

        return Common::requestSync($request);
    }

    /**
     * 移除关系接口
     *
     * @param string $Model_name model名称
     * @param int $id
     * @param string/array $detaches 移除关系数组/json字符 空：移除所有，id数组：移除指定的
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function detach(Request $request)
    {
        $this->InitParams($request);

        return Common::requestDetach($request);
    }
}
