<?php
namespace api\exception\controller;

use api\common\Send;

class Error
{
    use Send;

    public function index()
    {	

        $this->sendError('No routing path can be found for the request.', 404, 404);

    }
}