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
            'msg'    => $msg ?: Config::get('error.' . strtoUpper($code)),
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

if (!function_exists('get_hash_str')) {
    function get_hash_str($str = '', $salt = '')
    {
        return hash('md5', $str . $salt);
    }
}

if (!function_exists('get_random_str')) {
    function get_random_str($len)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';

        for ($i = 0; $i < $len; $i++) {
            $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        return $str;
    }
}
