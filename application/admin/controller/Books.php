<?php

namespace app\admin\controller;

use think\Request;
use think\Env;
use think\Db;

class Books extends Base
{
    use \app\common\traits\Filter;

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 导入书单
     *
     * @return void
     */
    public function import()
    {
        if (!Request::instance()->isPost()) exit;

        $excel = Request::instance()->post('excel');
        if (!$excel || !file_exists(ROOT_PATH . 'public' . $excel)) exit(ajax_return_error('file_not_exists'));
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
            ->field('books.*, admins.username')
            ->join('admins admins', 'admins.id = books.adminid')
            ->where($this->getFilters($get))
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
        $this->fields = ['wd', 's1', 's2', 's3'];
        $filters = [];
        $this->setConditions($params);

        if ($this->conditions['wd']) $filters['videos.name'] = ['like', '%' . $this->conditions['wd'] . '%'];
        if ($this->conditions['s1']) $filters['videos.name'] = $this->conditions['s1'];
        if ($this->conditions['s2']) $filters['videos.status'] = $this->conditions['s2'];
        if ($this->conditions['s3']) $filters['videos.added_at'] = $this->setBetweenFilter($this->conditions['s3']);

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
            ->field('books.*, admins.username')
            ->join('admins admins', 'admins.id = books.adminid')
            ->find($id);

        exit(ajax_return_ok($data));
    }

    /**
     * 删除书单
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

        $urls = Db::name('videos')
            ->where(['id' => ['in', $ids]])
            ->column('url');
        $urls = array_filter($urls);

        foreach ($urls as $url) @unlink(ROOT_PATH . 'public' . $url);
        if (BooksModel::destroy($ids)) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 软删除书单
     *
     * @return void
     */
    public function delete()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'ids' => 'require',
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $ids = $post['ids'];

        if (!is_array($ids)) $ids = [$ids];

        $res = BooksModel::where(['id' => ['in', $ids]])->update(['status' => 0]);

        if ($res) exit(ajax_return_ok());
        exit(ajax_return_error('sql_error'));
    }

    /**
     * 添加书单
     *
     * @return void
     */
    public function store()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'url'    => 'require',
            'status' => 'in:1,2'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $books = new BooksModel($post);
        $post['adminid'] = $this->uid;
        $res = $books->allowField(true)->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 更新书单
     *
     * @return void
     */
    public function update()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'id'     => 'require',
            'status' => 'require|in:1,2',
            'url'    => 'require'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $books = BooksModel::get($post['id']);
        $res = $books->allowField(['url', 'name', 'content', 'status'])->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }
}
