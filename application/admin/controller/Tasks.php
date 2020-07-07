<?php

namespace app\admin\controller;

use app\common\model\BooksModel;
use think\Request;
use think\Env;
use think\Db;
use app\common\model\TasksModel;

class Tasks extends Base
{
    use \app\common\traits\Filter;

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 查看书单上传批次列表
     *
     * @return void
     */
    public function list()
    {
        $get = Request::instance()->get();
        $current_page = $get['page'] ?? 1;
        $res = Db::name('tasks')
            ->where($this->getFilters($get))
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
     * 获取筛选数组
     *
     * @return void
     */
    protected function getFilters($params = [])
    {
        $this->fields = ['wd', 's1', 's2'];
        $filters = [];
        $this->setConditions($params);

        if ($this->conditions['wd']) $filters['name'] = ['like', '%' . $this->conditions['wd'] . '%'];
        if ($this->conditions['s1']) $filters['name'] = $this->conditions['s1'];
        if ($this->conditions['s2']) $filters['added_at'] = $this->setBetweenFilter($this->conditions['s2']);

        return $filters;
    }

    /**
     * 删除书单上传批次
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

        Db::startTrans();
        try {
            BooksModel::destroy(['taskid' => ['in', $ids]]);
            TasksModel::destroy($ids);
            Db::commit();
        } catch (\Exception $e) {
            exit(ajax_return_error('sql_error'));
            Db::rollback();
        }

        exit(ajax_return_ok());
    }

    /**
     * 更新书单上传批次
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

        $tasks = TasksModel::get($post['id']);
        $res = $tasks->allowField(['name'])->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }
}
