<?php

namespace app\admin\controller;

use app\common\model\AdminsModel;
use app\common\JWTToken;
use think\Request;
use think\Env;

class Auth extends Base
{
    public function _initialize()
    {
        $this->no_need_token = ['login'];
        parent::_initialize();
    }

    /**
     * 登录验证并返回JWT生成的token
     *
     * @return JSON
     */
    public function login()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $res = AdminsModel::where([
            'username' => $post['username'] ?? ''
        ])->find();

        if ($res && $res['password'] == get_hash_str($post['password'] . Env::get('app.salt'), $res['salt'])) {
            $token = JWTToken::getInstance()->setUid($res['id'])->encode()->getToken();
            exit(ajax_return_ok(['token' => $token]));
        }

        exit(ajax_return_error('auth_error'));
    }
}
