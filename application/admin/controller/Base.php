<?php

namespace app\admin\controller;

use app\common\Base as CommonBase;
use app\common\JWTToken;
use think\Request;

class Base extends CommonBase
{
    protected $uid;
    protected $no_need_token = [];

    public function _initialize()
    {
        parent::_initialize();

        // 判断是否需要验证json web token
        if (!in_array(Request::instance()->action(), $this->no_need_token)) {
            $this->checkToken();
        }
    }

    /**
     * 检查token是否合法
     *
     * @return JSON|INT 合法则返回用户id;不合法则返回错误提示
     */
    private function checkToken()
    {
        $token = Request::instance()->params('_token');

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
