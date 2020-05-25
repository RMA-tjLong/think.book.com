<?php

namespace app\admin\model;

use app\common\model\BaseModel;

class UsersModel extends BaseModel
{
    protected $table = 'book_users';

    public function book_vips()
    {
        return $this->hasOne('BookVipsModel', 'userid', 'id')->field('vip, balance, ended_at');
    }

    public function class_vips()
    {
        return $this->hasOne('ClassVipsModel', 'userid', 'id')->field('vip, balance');
    }
}
