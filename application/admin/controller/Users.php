<?php

namespace app\admin\controller;

use think\Db;
use think\Env;
use app\admin\model\UsersModel;
use app\admin\model\VipsModel;
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
            ->field('u.id, openid, u.unionid, nickname, avatar_url, gender, phone, signature, u.added_at, v.vip, v.balance')
            ->join('book_vips v', 'v.userid = u.id', 'left')
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
        $data->vips;

        exit(ajax_return_ok($data));
    }

    /**
     * 修改vip等级
     *
     * @return void
     */
    public function updateVip()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'id'  => 'require',
            'vip' => 'require|in:' . implode(',', VipsModel::$vip_type)
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $users = UsersModel::get($post['id']);
        $res = $users->vips->allowField(['vip'])->save($post);

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
