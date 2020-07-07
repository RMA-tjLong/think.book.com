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
    Route::group('v1', function () {
        Route::group('user', function () {
            Route::post([
                'register' => 'User/register',   // 注册 TODO
                'login'    => 'User/login'       // 登录 TODO
            ]);
        });

        Route::group('videos', function () {
            Route::get([
                'list' => 'Videos/list',   // 查看小视频列表 TODO
                'info' => 'Videos/info'    // 查看小视频详细信息 TODO
            ]);
        });

        Route::group('books', function () {
            Route::get([
                'list' => 'Books/list',   // 书单列表 TODO
                'info' => 'Books/info',   // 书目信息 TODO
            ]);
        });

        Route::group('info', function () {
            Route::get([
                'info' => 'Info/info'  // 企业信息
            ]);
        });
    });
});

Route::group('admin', function () {
    Route::group('api', function () {
        Route::group('v1', function () {
            // 登录验证
            Route::post('auth/login', 'admin/Auth/login');

            Route::group('users', function () {
                Route::get([
                    'list' => 'admin/Users/list',   // 获取用户列表
                    'info' => 'admin/Users/info'    // 查看用户详情
                ]);

                Route::post([
                    'change-book-vip'  => 'admin/Users/updateBookVip',    // 更新用户借阅vip相关
                    'change-class-vip' => 'admin/Users/updateClassVip',   // 更新用户课时vip相关
                    'change-teacher'   => 'admin/Users/updateTeacher'     // 添加教师标签
                ]);
            });

            Route::group('ads', function () {
                Route::get([
                    'list' => 'admin/Ads/list',   // 获取广告列表
                    'info' => 'admin/Ads/info'    // 查看广告详情
                ]);

                Route::post([
                    'drop'   => 'admin/Ads/drop',    // 删除某条广告
                    'store'  => 'admin/Ads/store',   // 添加某条广告
                    'change' => 'admin/Ads/update'   // 更新某条广告
                ]);
            });

            Route::group('videos', function () {
                Route::get([
                    'list' => 'admin/Videos/list',   // 获取视频列表
                    'info' => 'admin/Videos/info'    // 查看视频详情
                ]);

                Route::post([
                    'drop'   => 'admin/Videos/drop',     // 删除某条视频
                    'delete' => 'admin/Videos/delete',   // 软删除某条视频
                    'store'  => 'admin/Videos/store',    // 添加某条视频
                    'change' => 'admin/Videos/update'    // 更新某条视频
                ]);
            });

            Route::group('trial-courses', function () {
                Route::get([
                    'list' => 'admin/TrialCourses/list',   // 获取试听课程列表
                    'info' => 'admin/TrialCourses/info'    // 查看试听课程详情
                ]);

                Route::post([
                    'drop'   => 'admin/TrialCourses/drop',     // 删除某条试听课程
                    'delete' => 'admin/TrialCourses/delete',   // 软删除某条试听课程
                    'store'  => 'admin/TrialCourses/store',    // 添加某条试听课程
                    'change' => 'admin/TrialCourses/update'    // 更新某条试听课程
                ]);
            });

            Route::group('formal-courses', function () {
                Route::get([
                    'list' => 'admin/FormalCourses/list',   // 获取正式课程列表
                    'info' => 'admin/FormalCourses/info'    // 查看正式课程详情
                ]);

                Route::post([
                    'drop'   => 'admin/FormalCourses/drop',     // 删除某条正式课程
                    'delete' => 'admin/FormalCourses/delete',   // 软删除某条正式课程
                    'store'  => 'admin/FormalCourses/store',    // 添加某条正式课程
                    'change' => 'admin/FormalCourses/update'    // 更新某条正式课程
                ]);
            });

            Route::group('info', function () {
                Route::get([
                    'info' => 'admin/Info/info'  // 获取企业信息
                ]);

                Route::post([
                    'change' => 'admin/Info/update'  // 更新企业信息
                ]);
            });

            Route::group('activities', function () {
                Route::get([
                    'list' => 'admin/Activities/list',   // 获取活动列表
                    'info' => 'admin/Activities/info'    // 查看活动详情
                ]);

                Route::post([
                    'drop'   => 'admin/Activities/drop',     // 删除某条活动
                    'delete' => 'admin/Activities/delete',   // 软删除某条活动
                    'store'  => 'admin/Activities/store',    // 添加某条活动
                    'change' => 'admin/Activities/update'    // 更新某条活动
                ]);
            });

            Route::group('admins', function () {
                Route::post([
                    'check-username' => 'admin/Admins/checkUsername',   // 检查用户名是否存在
                    'store'          => 'admin/Admins/store',           // 添加管理员
                ]);
            });

            Route::group('books', function () {
                Route::get([
                    'list' => 'admin/Books/list',   // 获取书单列表
                    'info' => 'admin/Books/info',   // 查看书单详情
                ]);

                Route::post([
                    'import'                  => 'admin/Books/import',                // 上传书单
                    'drop'                    => 'admin/Books/drop',                  // 删除书单
                    'delete'                  => 'admin/Books/delete',                // 软删除书单
                    'store'                   => 'admin/Books/store',                 // 添加书单
                    'change'                  => 'admin/Books/update',                // 更新书单
                    'upload-all'              => 'admin/Books/uploadAll',             // 全部上架
                    'upload-batch'            => 'admin/Books/uploadBatch',           // 批量上架
                    'change-generation-batch' => 'admin/Books/changeGenerationBatch'  // 批量更新年龄段
                ]);
            });

            Route::group('generations', function () {
                Route::get([
                    'list' => 'admin/Generations/list',   // 获取年龄段列表
                ]);

                Route::post([
                    'drop'   => 'admin/Generations/drop',     // 删除年龄段
                    'store'  => 'admin/Generations/store',    // 添加年龄段
                    'change' => 'admin/Generations/update',   // 更新年龄段
                ]);
            });

            Route::group('tasks', function () {
                Route::get([
                    'list' => 'admin/Tasks/list',   // 获取书单上传批次列表
                ]);

                Route::post([
                    'drop'   => 'admin/Tasks/drop',     // 删除书单上传批次
                    'change' => 'admin/Tasks/update',   // 更新书单上传批次
                ]);
            });

            Route::group('uploads', function () {
                Route::post([
                    'image' => 'admin/Uploads/image',   // 上传图片
                    'video' => 'admin/Uploads/video',   // 上传视频
                    'excel' => 'admin/Uploads/excel'    // 上传excel
                ]);
            });
        });
    });
});
