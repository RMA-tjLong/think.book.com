<?php

namespace app\admin\controller;

use app\common\JWTToken;
use think\Db;
use think\helper\Hash;
use think\Request;
use think\Env;

class Auth extends Base
{
    /**
     * 登录验证并返回JWT生成的token
     *
     * @return JSON
     */
    public function login()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $res = Db::name('admins')->where([
            'username' => $post['username'] ?? ''
        ])->find();

        if ($res && Hash::check($post['password'], $res['password'], null, ['salt' => Env::get('app.salt')])) {
            $token = JWTToken::getInstance()->setUid($res['id'])->encode()->getToken();
            exit(ajax_return_ok(['token' => $token]));
        }

        exit(ajax_return_error('auth_error'));
    }
}
