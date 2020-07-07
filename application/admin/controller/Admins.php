<?php

namespace app\admin\controller;

use think\Env;
use think\Request;
use app\common\model\AdminsModel;

class Admins extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 检查用户名是否存在
     *
     * @return void
     */
    public function checkUsername()
    {
        if (!Request::instance()->isPost()) exit;
        $username = Request::instance()->post('username');
        if (!$username || AdminsModel::where(['username' => $username])->find()) exit(ajax_return_error('username_exists'));

        exit(ajax_return_ok());
    }

    /**
     * 添加管理员
     *
     * @return void
     */
    public function store()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'username' => 'require',
            'password' => 'require'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));
        
        $post['salt'] = get_random_str(6);
        $post['password'] = get_hash_str($post['password'] . Env::get('app.salt'), $post['salt']);
        $admins = new AdminsModel($post);
        $res = $admins->allowField(true)->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }
}
