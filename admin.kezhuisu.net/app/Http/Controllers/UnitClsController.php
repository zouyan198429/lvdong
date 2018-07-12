<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnitClsController extends LoginController
{
    /**
     * 生产单元分类
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);
        return view('unitcls.index');
    }

}
