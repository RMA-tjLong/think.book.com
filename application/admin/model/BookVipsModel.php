<?php

namespace app\admin\model;

use app\common\model\BaseModel;

class BookVipsModel extends BaseModel
{
    protected $table = 'book_book_vips';

    public function getVipAttr($value)
    {
        $vip = [0 => '非vip', 1 => '月卡', 2 => '季卡', 3 => '年卡'];
        return $vip[$value];
    }
}
