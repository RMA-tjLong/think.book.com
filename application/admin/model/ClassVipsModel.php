<?php

namespace app\admin\model;

use app\common\model\BaseModel;

class ClassVipsModel extends BaseModel
{
    protected $table = 'bk_class_vips';

    public function getVipAttr($value)
    {
        $vip = [0 => '非vip', 1 => 'vip'];
        return $vip[$value];
    }
}
