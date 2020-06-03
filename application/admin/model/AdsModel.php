<?php

namespace app\admin\model;

use app\common\model\BaseModel;

class AdsModel extends BaseModel
{
    protected $table = 'bk_ads';

    public function admins()
    {
        return $this->hasOne('AdminsModel', 'id', 'admin_id')->field('username');
    }
}
