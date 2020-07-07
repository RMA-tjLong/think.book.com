<?php

namespace app\common\model;

class VideosModel extends BaseModel
{
    protected $table = 'bk_videos';

    public function getStatusAttr($value)
    {
        $status = [0 => '已删除', 1 => '已下架', 2 => '上架中'];
        return $status[$value];
    }

    public function admins()
    {
        return $this->hasOne('AdminsModel', 'id', 'admin_id')->field('username');
    }
}
