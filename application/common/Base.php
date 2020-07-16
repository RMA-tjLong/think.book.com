<?php

namespace app\common;

use think\Controller;
use think\Env;

class Base extends Controller
{
    public function _initialize()
    {
        header('content-type:application:json;charset=utf8');
        header('Access-Control-Allow-Origin:' . Env::get('app.allow_origin', '*'));
        header('Access-Control-Allow-Methods:*');
        header('Access-Control-Allow-Headers:Origin,X-Requested-With,Content-Type,Accept,token');
    }
}
