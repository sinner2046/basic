<?php
namespace api\common;

use think\Response;
use think\exception\HttpResponseException;

trait Send
{
    /**
     * 默认返回资源类型
     * @var string
     */
    protected $restDefaultType = 'json';

    /**
     * 设置响应类型
     * @param null $type
     * @return $this
     */
    public function setType($type = null)
    {
        $this->type = (string)(!empty($type)) ? $type : $this->restDefaultType;
        return $this;
    }

    /**
     * 失败响应
     *  @param string $message
     * @param int $error
     * @param int $code
     * @param array $data
     * @param array $headers
     * @param array $options
     * @return Response|\think\response\Json|\think\response\Jsonp|\think\response\Xml
     */
    public function sendError($message = 'error', $error = 500, $code = 500, $data = [], $headers = [], $options = [])
    {
        $responseData['error'] = (int)$error;
        $responseData['message'] = (string)$message;
        if (!empty($data)) $responseData['data'] = $data;
        $responseData = array_merge($responseData, $options);
        return $this->response($responseData, $code, $headers);
    }

    /**
     * 成功响应
     * @param array $data
     * @param string $message
     * @param int $code
     * @param array $headers
     * @param array $options
     * @return Response|\think\response\Json|\think\response\Jsonp|Redirect|\think\response\Xml
     */
    public function sendSuccess($data = [], $message = 'success', $code = 200, $headers = [], $options = [])
    {
        $responseData['error'] = 0;
        $responseData['message'] = (string)$message;
        if (!empty($data)) $responseData['data'] = $data;
        $responseData = array_merge($responseData, $options);
        return $this->response($responseData, $code, $headers);
    }

    /**
     * 响应
     * @param $responseData
     * @param $code
     * @param $headers
     * @return Response|\think\response\Json|\think\response\Jsonp|Redirect|\think\response\View|\think\response\Xml
     */
    public function response($responseData, $code, $headers)
    {
        if (!isset($this->type) || empty($this->type)) $this->setType();
        $response = Response::create($responseData, $this->type, $code, $headers);
        throw new HttpResponseException($response);
    }
}