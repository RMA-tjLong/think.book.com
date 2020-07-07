<?php

namespace app\common\model;

class BooksModel extends BaseModel
{
    protected $table = 'bk_books';

    public function admins()
    {
        return $this->hasOne('AdminsModel', 'id', 'admin_id')->field('username');
    }
}
