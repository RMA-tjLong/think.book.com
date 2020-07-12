<?php

namespace app\index\controller;

use think\Db;

class Info extends Base
{
    public function _initialize()
    {
        $this->no_need_signature = ['info'];
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
}
