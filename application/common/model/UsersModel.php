<?php

namespace app\common\model;

class UsersModel extends BaseModel
{
    protected $table = 'bk_users';

    public function bookVips()
    {
        return $this->hasOne('BookVipsModel', 'userid', 'id')->field('vip, balance, ended_at');
    }

    public function classVips()
    {
        return $this->hasOne('ClassVipsModel', 'userid', 'id')->field('vip, balance');
    }
}
