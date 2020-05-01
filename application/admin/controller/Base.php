<?php

namespace app\admin\controller;

use app\common\Base as CommonBase;
use app\common\JWTToken;
use think\Request;

class Base extends CommonBase
{
    protected $uid;

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 检查token是否合法
     *
     * @return JSON|INT 合法则返回用户id;不合法则返回错误提示
     */
    public function checkToken()
    {
        $token = Request::instance()->header('token');

        if (!$token) exit(ajax_return_error('token_missed'));

        $jwt = JWTToken::getInstance();
        $jwt->setToken($token);

        if ($jwt->validate() && $jwt->verify()) {
            $this->uid = $jwt->jsonDecode()->getClaim('uid');
        } else {
            exit(ajax_return_error('token_missed'));
        }
    }
}
