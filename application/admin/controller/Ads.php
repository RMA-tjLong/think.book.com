<?php

namespace app\admin\controller;

use app\admin\model\AdsModel;
use think\Request;
use think\Db;
use think\Env;

class Ads extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $this->checkToken();
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
            ->field('id, name, content, url, added_at')
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
    public function info($id)
    {
        $data = AdsModel::get($id);
        exit(ajax_return_ok($data));
    }

    /**
     * 删除广告
     *
     * @return void
     */
    public function del()
    {}

    /**
     * 添加广告
     *
     * @return void
     */
    public function store()
    {}

    /**
     * 更新广告
     *
     * @return void
     */
    public function update()
    {}
}