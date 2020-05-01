<?php

namespace app\admin\model;

use app\common\model\BaseModel;

class UsersModel extends BaseModel
{
    protected $table = 'book_users';

    public function vips()
    {
        return $this->hasOne('VipsModel', 'userid', 'id')->field('vip, balance');
    }
}
