<?php

namespace app\admin\controller;

use think\Request;
use app\admin\model\InfoModel;
use think\Db;

class Info extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 查看企业信息
     *
     * @return void
     */
    public function info($col = '')
    {
        $data = Db::name('info')->find(1);

        exit(ajax_return_ok($data));
    }

    /**
     * 更新企业信息
     *
     * @return void
     */
    public function update()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'name'    => 'require',
            'lat'     => 'require',
            'lng'     => 'require',
            'address' => 'require',
            'phone'   => 'require'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $info = InfoModel::get(1);
        $res = $info->allowField(['name', 'lat', 'lng', 'address', 'phone', 'company_culture', 'curriculum_structure'])->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }
}