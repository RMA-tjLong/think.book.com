<?php

namespace app\index\controller;

use think\Db;
use think\Request;
use think\Env;

class Videos extends Base
{
    public function _initialize()
    {
        $this->no_need_signature = ['list', 'info'];
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
}
