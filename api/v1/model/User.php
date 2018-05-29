<?php
namespace api\v1\model;

use think\Model;

class User extends Model
{
    protected $autoWriteTimestamp = true;

    protected $insert = ['reg_ip'];

    /**
     * token过期时间秒数
     * @var int
     */
    private static $expires = 600;

    /**
     * reg_ip 自动完成
     * @return mixed
     */
    protected function setRegIpAttr()
    {
        return request()->ip();
    }

    /**
     * 生成token
     * @return string
     */
    private static function generateToken() {
        $token = md5(uniqid());

        if (self::where('token', $token)->value('id')) {
            self::generateToken();
        }
        return $token;
    }

    /**
     * 检测用户对应token
     * @param $token
     * @return array|bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function checkToken($token)
    {
        $info = self::where('token', $token)
            ->field('id,nickname,avatar,sex,expires,status')
            ->find();

        if (!$info) return '账户不存在';
        if (time() > $info->expires) return 'token已过期';
        if ($info->status != 1) return '账号已被禁用';

        return [
            'id' => $info->id,
            'nickname' => $info->nickname,
            'avatar' => $info->avatar,
            'sex' => $info->sex
        ];
    }


    public static function login()
    {
        $time = time();
        $data = [
            'token' => self::generateToken(),
            'expires' => $time + self::$expires,
            'last_login_time' => $time,
            'last_login_ip' => request()->ip()
        ];
        self::update($data, ['id' => 1]);
    }

    public static function add()
    {
        $data = [
            'mobile' => '13111111',
            'nickname' => '发',
            'avatar' => '123'
        ];

        self::create($data);
    }
}