<?php

namespace app\admin\model;

use app\common\model\BaseModel;

class ClassVipsModel extends BaseModel
{
    protected $table = 'book_class_vips';
    // 0：非vip；1：vip
    public static $vip_type = [0, 1];
}
