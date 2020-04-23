<?php
namespace app\controller;

use app\BaseController;

class Index extends BaseController
{
    public function index()
    {   
        apiException('我是异常1');
        $list = [1,2];
        return showSuccess($list);
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
