<?php
namespace api\v1\controller;

use api\common\Api;
use api\v1\model\User as UserModel;

class Base extends Api
{
    protected $uid;
    protected $uinfo;

    public function __construct()
    {
        parent::__construct();
        $this->checkToken();
    }

    /**
     * 检测token
     */
    protected function checkToken()
    {
        $token = $this->request->header('token');
        $this->validate(
            ['token' => $token],
            ['token' => 'require|length:32'],
            ['token' => 'token格式不正确']
        );

        $uinfo = UserModel::checkToken($token);

        if (!is_array($uinfo)) $this->sendError($uinfo, 401, 401);

        $this->uid = $uinfo['id'];
        unset($uinfo['id']);
        $this->uinfo = $uinfo;
    }
}