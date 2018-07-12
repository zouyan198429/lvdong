<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends LoginController
{
    /**
     * 付款记录
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request)
    {
        $this->InitParams($request);
        return view('order.index');
    }

}
