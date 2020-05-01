<?php

namespace app\common\model;

use think\Model;

class BaseModel extends Model
{
    protected $createTime = 'added_at';
    protected $updateTime = 'updated_at';
    protected $autoWriteTimestamp = 'datetime';
}
