<?php

namespace app\admin\controller;

use think\Env;
use think\Request;
use app\common\model\AdsModel;
use think\Db;

class Ads extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 查看广告列表
     *
     * @return void
     */
    public function list()
    {
        $get = Request::instance()->get();
        $current_page = $get['page'] ?? 1;
        $res = Db::name('ads')
            ->alias('ads')
            ->field('ads.*, admins.username')
            ->join('admins', 'admins.id = ads.adminid')
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
     * 查看广告详情
     *
     * @return void
     */
    public function info($id = '')
    {
        $data = Db::name('ads')
            ->alias('ads')
            ->field('ads.*, admins.username')
            ->join('admins', 'admins.id = ads.adminid')
            ->order('added_at desc')
            ->find($id);

        exit(ajax_return_ok($data));
    }

    /**
     * 删除广告
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

        $urls = Db::name('ads')
            ->where(['id' => ['in', $ids]])
            ->column('url');
        $urls = array_filter($urls);

        foreach ($urls as $url) @unlink(ROOT_PATH . 'public' . $url);
        if (AdsModel::destroy($ids)) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 添加广告
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

        $ads = new AdsModel($post);
        $post['adminid'] = $this->uid;
        $res = $ads->allowField(true)->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 更新广告
     *
     * @return void
     */
    public function update()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'id'  => 'require',
            'url' => 'require'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $ads = AdsModel::get($post['id']);
        $res = $ads->allowField(['url', 'name', 'content'])->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }
}
