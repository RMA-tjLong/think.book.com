<?php

namespace app\admin\controller;

use think\Request;
use think\Env;

class Uploads extends Base
{
    public function _initialize()
    {
        $this->no_need_token = ['image', 'video'];
        parent::_initialize();
    }

    /**
     * 上传图片
     *
     * @return void
     */
    public function image()
    {
        if (!Request::instance()->isPost()) exit;

        $res = [];
        $files = Request::instance()->file('images');

        foreach ($files as $f) {
            if ($f->getInfo('name') != '') {
                $info = $f->validate([
                    'size' => Env::get('uploads.image_size'),
                    'ext'  => Env::get('uploads.image_ext')
                ])->move(UPLOAD_IMAGE_PATH);

                if ($info) {
                    $res[] = [
                        'url'  => UPLOAD_IMAGE_URL . $info->getSaveName(),
                        'name' => $f->getInfo('name')
                    ];
                } else {
                    exit(ajax_return_error('upload_error'));
                }
            }
        }

        exit(ajax_return_ok($res));
    }
}
