<?php

namespace app\admin\controller;

use think\Db;
use think\Env;
use think\Request;
use app\admin\model\VideosModel;

class Videos extends Base
{
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
        $filters = Filter::getInstance()->setClass(get_called_class())->getFilters($get);
        $current_page = $get['page'] ?? 1;
        $res = Db::name('videos')
            ->field('id, name, content, url, status, added_at')
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
     * 查看视频详情
     *
     * @return void
     */
    public function info($id)
    {
        $data = VideosModel::get($id);
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

        $list = Db::name('videos')->where(['id' => ['in', $ids]])->select();
        $urls = [];

        foreach ($list as $li) $urls[] = $li['url'];
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

        $res = Db::name('videos')->where(['id' => ['in', $ids]])->update(['status' => 0]);
        
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
        $res = $videos->allowField(true)->save();

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
