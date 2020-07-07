<?php

namespace app\common\model;

class ClassVipsModel extends BaseModel
{
    protected $table = 'bk_class_vips';

    public function getVipAttr($value)
    {
        $vip = [0 => '非vip', 1 => 'vip'];
        return $vip[$value];
    }
}
