<?php

namespace app\index\controller;

use app\common\Base as CommonBase;
use app\common\Signature;
use think\Request;

class Base extends CommonBase
{
    protected $uid;
    protected $no_need_signature = [];

    public function _initialize()
    {
        // 判断是否需要验证signature
        if (!in_array(Request::instance()->action(), $this->no_need_signature)) {
            $this->checkSignature();
        }
    }

    /**
     * 检查signature是否合法
     *
     * @return JSON 合法则继续操作;不合法则返回错误提示
     */
    private function checkSignature()
    {
        $signature = Request::instance()->header('signature');
        $signature_time = Request::instance()->header('signature_time');
        $uid = Request::instance()->param('uid');

        if (!$signature) exit(ajax_return_error('signature_missed'));

        if (Signature::checkSignature($uid, $signature, $signature_time)) {
            $this->uid = $uid;
        } else {
            exit(ajax_return_error('signature_missed'));
        }
    }
}
