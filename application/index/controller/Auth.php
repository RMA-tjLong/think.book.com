<?php

namespace app\index\controller;

use app\common\model\UsersModel;
use app\common\Signature;
use think\Request;
use think\Env;
use think\Db;

class Auth extends Base
{
    public function _initialize()
    {
        $this->no_need_signature = ['login', 'register', 'checkphone'];
        parent::_initialize();
    }

    /**
     * 登录
     *
     * @return void
     */
    public function login()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $res = UsersModel::where([
            'phone' => $post['phone'] ?? ''
        ])->find();

        if ($res && $res['password'] == get_hash_str($post['password'] . Env::get('app.salt'))) {
            $update = [];
            if (!$res['nickname']) {
                $update['nickname'] = $post['nickname'];
            }

            if (!$res['avatar_url']) {
                $update['avatar_url'] = $post['avatar_url'];
            }

            if (!$res['gender']) {
                $update['gender'] = $post['gender'];
            }

            if ($update) {
                Db::name('users')->where('id', $res['id'])->update($update);
            }

            $data = Db::name('users')
                ->alias('users')
                ->field('users.*, book_vips.vip as b_vip, book_vips.balance as b_balance, book_vips.ended_at as b_ended_at, class_vips.vip as c_vip, class_vips.balance as c_balance')
                ->join('book_vips book_vips', 'book_vips.userid = users.id', 'left')
                ->join('class_vips class_vips', 'class_vips.userid = users.id', 'left')
                ->find($res['id']);
            
            $signature_time = time();
            exit(ajax_return_ok(array_merge($data, [
                'signature'      => Signature::encryptSignature($res['id'], $signature_time),
                'signature_time' => $signature_time
            ])));
        }

        exit(ajax_return_error('auth_error'));
    }

    /**
     * 检查登录账户（电话号码）是否存在
     *
     * @return void
     */
    public function checkPhone()
    {
        if (!Request::instance()->isPost()) exit;
        $phone = Request::instance()->post('phone');
        if (!$phone || UsersModel::where(['phone' => $phone])->find()) exit(ajax_return_error('phone_exists'));

        exit(ajax_return_ok());
    }

    /**
     * 注册
     *
     * @return void
     */
    public function register()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'password'   => 'require',
            'phone'      => 'require'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));
        
        $post['password'] = get_hash_str($post['password'] . Env::get('app.salt'));
        $users = new UsersModel($post);
        $uid = $users->allowField(true)->save();
        $users->bookVips()->save(['userid' => $uid]);
        $users->classVips()->save(['userid' => $uid]);

        exit(ajax_return_ok());
    }
}