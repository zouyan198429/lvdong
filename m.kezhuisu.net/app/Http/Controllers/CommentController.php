<?php

namespace App\Http\Controllers;

use App\Services\HttpRequest;
use Illuminate\Http\Request;

class CommentController extends BasePublicController
{
    /**
     * 反馈
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function index(Request $request, $pro_unit_id)
    {
        if (empty($pro_unit_id) || (! is_numeric($pro_unit_id))){
            return '参数[pro_unit_id]有误!!';
        }
        $url = config('public.apiUrl') . config('public.apiPath.commentsPage');
        $requestData = [
            'pro_unit_id' => $pro_unit_id,
        ];
        $data = HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
        if (is_string($data)) {
            return $data;
        }

        $data['pro_unit_id'] = $pro_unit_id;
        foreach($data['pro_comments'] as $k => $v){
            $data['pro_comments'][$k]['comment_mobile'] = substr_replace($v['comment_mobile'], '****', 3, 4);
        }
        return view('comment.index', $data);
    }
    /**
     * 反馈
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function save(Request $request, $pro_unit_id)
    {
        $comment_mobile = $request->post('comment_mobile');
        $comment_content = $request->post('comment_content');
        $company_id = $request->post('company_id');
        if($comment_mobile != '' && $comment_content != ''){
            $comment_content =  replace_enter_char($comment_content,1);
            // 保存记录
            $saveData = [
                'company_id' => $company_id,
                'pro_unit_id' => $pro_unit_id,
                'comment_mobile' => $comment_mobile,
                'comment_content' => $comment_content,
            ];
            // 新加
            $resultDatas = $this->createApi('CompanyProComment',$saveData,$company_id,0);
            $id = $resultDatas['id'] ?? 0;
        }

        return ajaxDataArr(1, $resultDatas, '');
        // return redirect('comment/' . $pro_unit_id);

    }

    /**
     * 反馈-星级
     *
     * @param int $id
     * @return Response
     * @author zouyan(305463219@qq.com)
     */
    public function star(Request $request, $pro_unit_id)
    {
        if (empty($pro_unit_id) || (! is_numeric($pro_unit_id))){
            return '参数[pro_unit_id]有误!!';
        }
        $url = config('public.apiUrl') . config('public.apiPath.companyIntroPage');
        $requestData = [
            'pro_unit_id' => $pro_unit_id,
        ];
        $data = HttpRequest::HttpRequestApi($url, $requestData, [], 'POST');
        if (is_string($data)) {
            return $data;
        }

        $data['pro_unit_id'] = $pro_unit_id;
        return view('comment.star', $data);
    }

}
