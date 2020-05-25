<?php

namespace app\admin\model;

use app\common\model\BaseModel;

class BookVipsModel extends BaseModel
{
    protected $table = 'book_book_vips';
    // 0：无vip；1：月卡vip；2：季卡vip；3：年卡vip
    public static $vip_type = [0, 1, 2, 3];
}
