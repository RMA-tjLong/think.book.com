<?php

namespace app\admin\model;

use app\common\model\BaseModel;

class BooksModel extends BaseModel
{
    protected $table = 'bk_books';

    public function admins()
    {
        return $this->hasOne('AdminsModel', 'id', 'admin_id')->field('username');
    }
}
