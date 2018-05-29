<?php

namespace api\v1\controller;

use api\common\Api;
use api\common\Token;
use think\Log;

class Index extends Api
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {


        $msg = ['发髻','法发顺丰'];
        Log::record($msg, 'pay');
//        $this->sendSuccess(Token::set(['uid' => '1']));
//        $this->sendSuccess(Token::get('a2d2e5219611b8ad1eb9f085e7e827f5'));
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
