<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 上传图片目录路径
define('UPLOAD_IMAGE_PATH', __DIR__ . '/static/uploads/image/');
// 上传图片url
define('UPLOAD_IMAGE_URL', '/static/uploads/image/');
// 上传视频目录路径
define('UPLOAD_VIDEO_PATH', __DIR__ . '/static/uploads/video/');
// 上传视频url
define('UPLOAD_VIDEO_URL', '/static/uploads/video/');
// 上传 excel 目录路径
define('UPLOAD_EXCEL_PATH', __DIR__ . '/static/uploads/excel/');
// 上传 excel url
define('UPLOAD_EXCEL_URL', '/static/uploads/excel/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
