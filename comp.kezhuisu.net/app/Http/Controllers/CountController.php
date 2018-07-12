<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CountController extends LoginController
{

    /**
     * 数据统计
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);
        return view('count.index');
    }

}
