<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::group('api', function() {
    Route::bind('index');
    Route::group('v1', function() {
        Route::post('auth/login', 'Index/index');
    });
});

Route::group('admin', function() {
    Route::bind('admin');
    Route::group('api', function() {
        Route::group('v1', function() {
            // 登录验证
            Route::post('auth/login', 'Auth/login');
            // 获取用户列表
            Route::get('users/list', 'Users/list');
            // 查看用户详情
            Route::get('users/info', 'Users/info');
            // 更新用户借阅vip
            Route::post('users/change-book-vip', 'Users/updateBookVip');
            // 更改用户借阅vip到期时间
            Route::post('users/change-book-vip-ended', 'Users/updateBookVipEnded');
            // 更新用户课时vip
            Route::post('users/change-class-vip', 'Users/updateClassVip');
            // 更新借阅余额
            Route::post('users/change-book-balance', 'Users/updateBookBalance');
            // 更新课时余额
            Route::post('users/change-class-balance', 'Users/updateClassBalance');
            // 添加教师标签
            Route::post('users/set-teacher', 'Users/updateTeacher');
        });
    });
});