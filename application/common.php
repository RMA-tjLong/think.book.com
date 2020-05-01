<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

use think\Config;

if (!function_exists('ajax_return_error')) {
    function ajax_return_error($code = '', $msg = '')
    {
        $res = [
            'status' => false,
            'msg'    => $msg ? : Config::get('error.' . strtoUpper($code)),
            'data'   => []
        ];

        return json_encode($res);
    }
}

if (!function_exists('ajax_return_ok')) {
    function ajax_return_ok($data = [], $msg = '')
    {
        $res = [
            'status' => true,
            'msg'    => $msg,
            'data'   => $data
        ];

        return json_encode($res);
    }
}