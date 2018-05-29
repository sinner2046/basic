<?php
namespace api\v1\controller;



class Test extends Base
{

    public function test()
    {
        $result = $this->validate(
            [
                'name'  => 'thinkphp',
                'email' => 'thinkphp',
            ],
            [
                'name'  => 'require|max:25',
                'email'   => 'email',
            ]);

    }
}