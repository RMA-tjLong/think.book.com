<?php

namespace app\admin\model;

use app\common\model\BaseModel;

class VideosModel extends BaseModel
{
    protected $table = 'book_videos';

    public function getStatusAttr($value)
    {
        $status = [0 => '已删除', 1 => '已下架', 2 => '上架中'];
        return $status[$value];
    }
}
