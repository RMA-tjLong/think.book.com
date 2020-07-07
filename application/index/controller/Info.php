<?php

namespace app\index\controller;

use think\Db;

class Info extends Base
{
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