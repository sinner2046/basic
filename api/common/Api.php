<?php
namespace api\common;

use think\Loader;
use think\Request;

class Api
{
    use Send;

    protected $request;
    /**
     * 当前请求类型
     * @var string
     */
    protected $method;
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
    /**
     * 允许访问的请求类型
     * @var string
     */
    public $restMethodList = 'get|post|put|delete';

    /**
     * Api constructor.
     * @param Request|null $request
     */
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
        if ($ext == '' || !in_array($ext, explode('|', $this->restTypeList))) {
            // 资源类型非法 则用默认资源类型访问
            $this->type = $this->restDefaultType;
        } else {
            $this->type = $ext;
        }

        // 请求方式检测
        $this->method = strtolower($this->request->method());
        if(!in_array($this->method, explode('|', $this->restMethodList))) {
            $this->sendError('Method Not Allowed', 405, 405);
        }
    }

    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @return array|string|true
     */
    protected function validate($data, $validate, $message = [])
    {
        if (is_array($validate)) {
            $v = Loader::validate();
            $v->rule($validate);
        } else {
            // 支持场景
            if (strpos($validate, '.')) {
                list($validate, $scene) = explode('.', $validate);
            }

            $v = Loader::validate($validate);

            !empty($scene) && $v->scene($scene);
        }

        // 设置错误信息
        if (is_array($message)) {
            $v->message($message);
        }

        if (!$v->check($data)) {
            $this->sendError($v->getError(), 400, 400);
        }

        return true;
    }
}