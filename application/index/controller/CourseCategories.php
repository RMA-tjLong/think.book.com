<?php

namespace app\index\controller;

use think\Db;

class CourseCategories extends Base
{
    public function _initialize()
    {
        $this->no_need_signature = ['list'];
        parent::_initialize();
    }

    /**
     * 查看课程分类列表
     *
     * @return void
     */
    public function list()
    {
        $res = Db::name('course_categories')
            ->order('added_at desc')
            ->select();

        exit(ajax_return_ok(['list' => $res]));
    }
}
