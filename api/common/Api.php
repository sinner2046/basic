<?php
namespace api\common;

use think\Request;

class Api
{
    use Send;

    protected $request;
    /**
     * 当前请求资源类型
     * @var string
     */
    protected $type;
    /**
     * 允许返回的资源类的
     * @var string
     */
    protected $restTypeList = 'json|xml';

    public function __construct(Request $request = null)
    {
        $this->request = is_null($request) ? Request::instance() : $request;
        $this->init();
    }

    /**
     * 初始化方法
     * 检测请求类型，数据格式等操作
     */
    public function init()
    {
        $ext = $this->request->ext();
        if ($ext == '') {
            // 自动检测资源类型
            $this->type = $this->request->type();
        } elseif (!in_array($ext, explode('|', $this->restTypeList))) {
            // 资源类型非法 则用默认资源类型访问
            $this->type = $this->restDefaultType;
        } else {
            $this->type = $ext;
        }


     //   dump($this->request->type());
    }
}