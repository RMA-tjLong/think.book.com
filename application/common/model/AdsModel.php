<?php

namespace app\common\model;

class AdsModel extends BaseModel
{
    protected $table = 'bk_ads';

    public function admins()
    {
        return $this->hasOne('AdminsModel', 'id', 'admin_id')->field('username');
    }
}
