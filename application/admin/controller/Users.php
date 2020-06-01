<?php

namespace app\admin\controller;

use think\Db;
use think\Env;
use think\Request;
use app\common\Filter;
use app\admin\model\UsersModel;

class Users extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 查看用户列表
     *
     * @return void
     */
    public function list()
    {
        $get = Request::instance()->get();
        $filters = Filter::getInstance()->setClass(get_called_class())->getFilters($get);
        $current_page = $get['page'] ?? 1;
        $res = Db::name('users')->alias('u')
            ->field('u.id, openid, u.unionid, nickname, avatar_url, gender, phone, signature, i_teacher, u.added_at, b_v.vip as b_vip, b_v.balance as b_balance, b_v.ended_at as b_ended_at, c_v.vip as c_vip, c_v.balance as c_balance')
            ->join('book_book_vips b_v', 'b_v.userid = u.id', 'left')
            ->join('book_class_vips c_v', 'c_v.userid = u.id', 'left')
            ->where($filters)
            ->order('added_at desc')
            ->paginate(null, false, [
                'page' => $current_page,
                'path' => Env::get('app.client_url')
            ]);

        $data = [
            'list'   => $res->items(),
            'render' => $res->render()
        ];

        exit(ajax_return_ok($data));
    }

    /**
     * 查看用户详情
     *
     * @return void
     */
    public function info($id)
    {
        $data = UsersModel::get($id);
        $data->bookVips;
        $data->classVips;

        exit(ajax_return_ok($data));
    }

    /**
     * 修改借阅vip相关
     *
     * @return void
     */
    public function updateBookVip()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'id'       => 'require',
            'vip'      => 'require|in:0,1,2,3',
            'ended_at' => 'require|date',
            'balance'  => 'require|number'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $users = UsersModel::get($post['id']);
        $res = $users->bookVips->allowField(['vip', 'ended_at', 'balance'])->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 修改课程vip相关
     *
     * @return void
     */
    public function updateClassVip()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'id'      => 'require',
            'vip'     => 'require|in:0,1',
            'balance' => 'require|number'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $users = UsersModel::get($post['id']);
        $res = $users->classVips->allowField(['vip', 'balance'])->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 修改用户是否为教师
     *
     * @return void
     */
    public function updateTeacher()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'id'        => 'require',
            'i_teacher' => 'require|in:1,0'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $users = UsersModel::get($post['id']);
        $res = $users->allowField(['i_teacher'])->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }
}
