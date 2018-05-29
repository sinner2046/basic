<?php
namespace api\v1\controller;

use api\common\Api;
use api\v1\model\User as UserModel;

class User extends Api
{
    public function login()
    {
        UserModel::login();
        $this->sendSuccess(111);
    }
}