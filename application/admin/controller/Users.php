<?php

namespace app\admin\controller;

use think\Db;
use think\Env;
use think\Request;
use app\common\model\UsersModel;

class Users extends Base
{
    use \app\common\traits\Filter;

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
        $current_page = $get['page'] ?? 1;
        $res = Db::name('users')
            ->alias('users')
            ->field('users.*, book_vips.vip as b_vip, book_vips.balance as b_balance, book_vips.ended_at as b_ended_at, class_vips.vip as c_vip, class_vips.balance as c_balance')
            ->join('book_vips book_vips', 'book_vips.userid = users.id', 'left')
            ->join('class_vips class_vips', 'class_vips.userid = users.id', 'left')
            ->where($this->getFilters($get))
            ->order('users.added_at desc')
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
     * 获取筛选数组
     *
     * @return void
     */
    protected function getFilters($params = [])
    {
        $this->fields = ['wd', 's1', 's2', 's3', 's4', 's5', 's6', 's7', 's8'];
        $filters = [];
        $this->setConditions($params);

        if ($this->conditions['wd']) $filters['users.phone'] = ['like', '%' . $this->conditions['wd'] . '%'];
        if ($this->conditions['s1']) $filters['users.phone'] = $this->conditions['s1'];
        if ($this->conditions['s2']) $filters['users.nickname'] = ['like', '%' . $this->conditions['s2'] . '%'];
        if ($this->conditions['s3']) $filters['users.added_at'] = $this->setBetweenFilter($this->conditions['s3']);
        if ($this->conditions['s4'] !== '') $filters['book_vips.vip'] = $this->conditions['s4'];
        if ($this->conditions['s5']) $filters['book_vips.balance'] = $this->setBetweenFilter($this->conditions['s5']);
        if ($this->conditions['s6']) $filters['book_vips.ended_at'] = $this->setBetweenFilter($this->conditions['s6']);
        if ($this->conditions['s7'] !== '') $filters['class_vips.vip'] = $this->conditions['s7'];
        if ($this->conditions['s8']) $filters['class_vips.balance'] = $this->setBetweenFilter($this->conditions['s8']);

        return $filters;
    }

    /**
     * 查看用户详情
     *
     * @return void
     */
    public function info($id = '')
    {
        $data = Db::name('users')
            ->alias('users')
            ->field('users.*, book_vips.vip as b_vip, book_vips.balance as b_balance, book_vips.ended_at as b_ended_at, class_vips.vip as c_vip, class_vips.balance as c_balance')
            ->join('book_vips book_vips', 'book_vips.userid = users.id', 'left')
            ->join('class_vips class_vips', 'class_vips.userid = users.id', 'left')
            ->find($id);

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
