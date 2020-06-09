<?php

namespace app\admin\model;

use app\common\model\BaseModel;

class ActivitiesModel extends BaseModel
{
    protected $table = 'bk_activities';

    public function getStatusAttr($value)
    {
        $status = [0 => '已删除', 1 => '已下架', 2 => '上架中'];
        return $status[$value];
    }

    public function getKindAttr($value)
    {
        $kind = [1 => '精品活动', 2 => '商业活动'];
        return $kind[$value];
    }

    public function admins()
    {
        return $this->hasOne('AdminsModel', 'id', 'admin_id')->field('username');
    }
}
