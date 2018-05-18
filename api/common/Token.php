<?php
namespace api\common;

use think\Cache;

class Token
{
    /**
     * 过期时间秒数
     *
     * @var int
     */
    public static $expires = 60;

    /**
     * 生成token
     * @return string
     */
    public static function generate() {
        return md5(uniqid());
    }

    /**
     * 设置token
     * @param $data
     * @return bool|string
     */
    public static function set($data)
    {
        $token = self::generate();

        while (Cache::get($token)) {
            $token = self::generate();
        }

        if (!Cache::set($token, $data, self::$expires)) return false;

        return $token;
    }

    /**
     * @param $token
     * @return mixed
     */
    public static function get($token)
    {
        return Cache::get($token);
    }


}