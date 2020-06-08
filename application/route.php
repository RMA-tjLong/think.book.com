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

Route::group('api', function () {
    Route::bind('index');
    Route::group('v1', function () {
        Route::post('auth/login', 'Index/index');
    });
});

Route::group('admin', function () {
    Route::bind('admin');
    Route::group('api', function () {
        Route::group('v1', function () {
            // 登录验证
            Route::post('auth/login', 'Auth/login');

            Route::group('users', function () {
                Route::get([
                    'list' => 'Users/list',   // 获取用户列表
                    'info' => 'Users/info'    // 查看用户详情
                ]);

                Route::post([
                    'change-book-vip'  => 'Users/updateBookVip',    // 更新用户借阅vip相关
                    'change-class-vip' => 'Users/updateClassVip',   // 更新用户课时vip相关
                    'change-teacher'   => 'Users/updateTeacher'     // 添加教师标签
                ]);
            });

            Route::group('ads', function () {
                Route::get([
                    'list' => 'Ads/list',   // 获取广告列表
                    'info' => 'Ads/info'    // 查看广告详情
                ]);

                Route::post([
                    'drop'   => 'Ads/drop',    // 删除某条广告
                    'store'  => 'Ads/store',   // 添加某条广告
                    'change' => 'Ads/update'   // 更新某条广告
                ]);
            });

            Route::group('videos', function () {
                Route::get([
                    'list' => 'Videos/list',   // 获取视频列表
                    'info' => 'Videos/info'    // 查看视频详情
                ]);

                Route::post([
                    'drop'   => 'Videos/drop',     // 删除某条视频
                    'delete' => 'Videos/delete',   // 软删除某条视频
                    'store'  => 'Videos/store',    // 添加某条视频
                    'change' => 'Videos/update'    // 更新某条视频
                ]);
            });

            Route::group('trial-courses', function () {
                Route::get([
                    'list' => 'TrialCourses/list',   // 获取试听课程列表
                    'info' => 'TrialCourses/info'    // 查看试听课程详情
                ]);

                Route::post([
                    'drop'   => 'TrialCourses/drop',     // 删除某条试听课程
                    'delete' => 'TrialCourses/delete',   // 软删除某条试听课程
                    'store'  => 'TrialCourses/store',    // 添加某条试听课程
                    'change' => 'TrialCourses/update'    // 更新某条试听课程
                ]);
            });

            Route::group('formal-courses', function () {
                Route::get([
                    'list' => 'FormalCourses/list',   // 获取正式课程列表
                    'info' => 'FormalCourses/info'    // 查看正式课程详情
                ]);

                Route::post([
                    'drop'   => 'FormalCourses/drop',     // 删除某条正式课程
                    'delete' => 'FormalCourses/delete',   // 软删除某条正式课程
                    'store'  => 'FormalCourses/store',    // 添加某条正式课程
                    'change' => 'FormalCourses/update'    // 更新某条正式课程
                ]);
            });

            Route::group('info', function() {
                Route::get([
                    'info' => 'Info/info'  // 获取企业信息
                ]);

                Route::post([
                    'change' => 'Info/update'  // 更新企业信息
                ]);
            });

            Route::group('uploads', function () {
                Route::post([
                    'image' => 'Uploads/image',   // 上传图片
                    'video' => 'Uploads/video'    // 上传视频
                ]);
            });
        });
    });
});
