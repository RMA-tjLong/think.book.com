<?php

namespace app\index\controller;

use think\Request;
use think\Env;
use think\Db;

class Books extends Base
{
    use \app\common\traits\Filter;

    public function _initialize()
    {
        $this->no_need_signature = ['list', 'info'];
        parent::_initialize();
    }

    /**
     * 查看书单列表
     *
     * @return void
     */
    public function list()
    {
        $get = Request::instance()->get();
        $current_page = $get['page'] ?? 1;
        $res = Db::name('books')
            ->alias('books')
            ->field('books.id, books.name, number, num, barcode, isbn, author, publishing, cover, price, collection, room, shelf, status, uploaded_at, books.added_at, books.updated_at, admins.username, generations.name as generations_name, tasks.name as tasks_name')
            ->join('admins admins', 'admins.id = books.adminid')
            ->join('generations generations', 'generations.id = books.generationid', 'left')
            ->join('tasks tasks', 'tasks.id = books.taskid', 'left')
            ->where($this->getFilters($get))
            ->where(['status' => 2])
            ->order('books.added_at desc')
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
        $this->fields = ['wd', 's1', 's2', 's3', 's4', 's5'];
        $filters = [];
        $this->setConditions($params);

        if ($this->conditions['wd']) $filters['books.name'] = ['like', '%' . $this->conditions['wd'] . '%'];
        if ($this->conditions['s1']) $filters['books.name'] = $this->conditions['s1'];
        if ($this->conditions['s2']) $filters['books.generationid'] = $this->conditions['s2'];
        if ($this->conditions['s3']) $filters['books.barcode'] = $this->conditions['s3'];
        if ($this->conditions['s4']) $filters['books.taskid'] = $this->conditions['s4'];
        if ($this->conditions['s5']) $filters['books.uploaded_at'] = $this->setBetweenFilter($this->conditions['s5']);

        return $filters;
    }

    /**
     * 查看书单详情
     *
     * @return void
     */
    public function info($id = '')
    {
        $data = Db::name('books')
            ->alias('books')
            ->field('books.id, books.name, number, num, barcode, isbn, author, publishing, cover, price, collection, room, shelf, status, description, content, uploaded_at, books.added_at, books.updated_at, generationid, admins.username, generations.name as generations_name, tasks.name as tasks_name')
            ->join('admins admins', 'admins.id = books.adminid')
            ->join('generations generations', 'generations.id = books.generationid', 'left')
            ->join('tasks tasks', 'tasks.id = books.taskid', 'left')
            ->find($id);

        exit(ajax_return_ok($data));
    }
}
