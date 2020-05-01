<?php

namespace app\admin\model;

use app\common\model\BaseModel;

class VipsModel extends BaseModel
{
    protected $table = 'book_vips';
    // vip等级，0 = 无vip；1 = vip
    public static $vip_type = [0, 1];
}
