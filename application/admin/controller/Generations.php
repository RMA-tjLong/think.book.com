<?php

namespace app\admin\controller;

use think\Request;
use think\Env;
use think\Db;
use app\admin\model\GenerationsModel;

class Generations extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 查看年龄段列表
     *
     * @return void
     */
    public function list()
    {
        $res = Db::name('generations')
            ->order('added_at desc')
            ->select();

        exit(ajax_return_ok(['list' => $res]));
    }

    /**
     * 删除年龄段
     *
     * @return void
     */
    public function drop()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'ids' => 'require',
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $ids = $post['ids'];

        if (!is_array($ids)) $ids = [$ids];
        if (GenerationsModel::destroy($ids)) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 添加年龄段
     *
     * @return void
     */
    public function store()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'name' => 'require'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $generations = new GenerationsModel($post);
        $res = $generations->allowField(true)->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 更新年龄段
     *
     * @return void
     */
    public function update()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'id'      => 'require',
            'name'    => 'require'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $generations = GenerationsModel::get($post['id']);
        $res = $generations->allowField(['name'])->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }
}
