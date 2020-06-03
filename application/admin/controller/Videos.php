<?php

namespace app\admin\controller;

use think\Env;
use think\Request;
use app\admin\model\VideosModel;
use think\Db;

class Videos extends Base
{
    use \app\common\traits\Filter;

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 查看视频列表
     *
     * @return void
     */
    public function list()
    {
        $get = Request::instance()->get();
        $current_page = $get['page'] ?? 1;
        $res = Db::name('videos')
            ->alias('videos')
            ->field('videos.*, admins.username')
            ->join('admins admins', 'admins.id = videos.adminid')
            ->where($this->getFilters($get))
            ->order('videos.added_at desc')
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
     * 查看视频详情
     *
     * @return void
     */
    public function info($id = '')
    {
        $data = Db::name('videos')
            ->alias('videos')
            ->field('videos.*, admins.username')
            ->join('admins admins', 'admins.id = videos.adminid')
            ->find($id);

        exit(ajax_return_ok($data));
    }

    /**
     * 删除视频
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
        if (VideosModel::destroy($ids)) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 软删除视频
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

        $res = VideosModel::where(['id' => ['in', $ids]])->update(['status' => 0]);
        
        if ($res) exit(ajax_return_ok());
        exit(ajax_return_error('sql_error'));
    }

    /**
     * 添加视频
     *
     * @return void
     */
    public function store()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'url' => 'require',
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $videos = new VideosModel($post);
        $post['adminid'] = $this->uid;
        $res = $videos->allowField(true)->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 更新视频
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

        $videos = VideosModel::get($post['id']);
        $res = $videos->allowField(['url', 'name', 'content', 'status'])->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }
}
