<?php

namespace app\admin\controller;

use think\Db;
use think\Env;
use app\admin\model\UsersModel;
use app\admin\model\BookVipsModel;
use app\admin\model\ClassVipsModel;
use app\common\Filter;
use think\Request;

class Users extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $this->checkToken();
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
            ->where($filters);
        $list = $res->limit(($current_page - 1) * Env::get('app.list_rows'), Env::get('app.list_rows'))
            ->order('added_at desc')
            ->select();
        $count = count($list);
        $page = ceil($count / Env::get('app.list_rows'));

        $data = [
            'list'         => $list,
            'count'        => $count,
            'current_page' => $current_page,
            'page'         => $page
        ];

        exit(ajax_return_ok($data));
    }

    /**
     * 查看用户详情
     *
     * @return void
     */
    public function info($id = '')
    {
        if (!$id) exit;

        $data = UsersModel::get($id);
        $data->book_vips;
        $data->class_vips;

        exit(ajax_return_ok($data));
    }

    /**
     * 修改借阅vip等级
     *
     * @return void
     */
    public function updateBookVip()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'id'  => 'require',
            'vip' => 'require|in:' . implode(',', BookVipsModel::$vip_type)
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $users = UsersModel::get($post['id']);
        $res = $users->book_vips->allowField(['vip'])->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 修改借阅vip到期时间
     *
     * @return void
     */
    public function updateBookVipEnded()
    {}
    
    /**
     * 修改课程vip等级
     *
     * @return void
     */
    public function updateClassVip()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'id'  => 'require',
            'vip' => 'require|in:' . implode(',', ClassVipsModel::$vip_type)
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $users = UsersModel::get($post['id']);
        $res = $users->class_vips->allowField(['vip'])->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 添加余额
     *
     * @return void
     */
    public function addBalance()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'id'          => 'require',
            'add_balance' => 'require|number'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $users = UsersModel::get($post['id']);
        $users->vips->balance += $post['add_balance'];
        $res = $users->vips->save();

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }
}
