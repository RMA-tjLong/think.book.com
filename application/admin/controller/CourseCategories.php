<?php

namespace app\admin\controller;

use think\Request;
use think\Db;
use app\common\model\CourseCategoriesModel;

class CourseCategories extends Base
{
    public function _initialize()
    {
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

    /**
     * 删除课程分类
     *
     * @return void
     */
    public function drop()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'ids' => 'require',
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $ids = $post['ids'];

        if (!is_array($ids)) $ids = [$ids];
        if (CourseCategoriesModel::destroy($ids)) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 添加课程分类
     *
     * @return void
     */
    public function store()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'name' => 'require'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $course_categories = new CourseCategoriesModel($post);
        $res = $course_categories->allowField(true)->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 更新课程列表
     *
     * @return void
     */
    public function update()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'id'      => 'require',
            'name'    => 'require'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $course_categories = CourseCategoriesModel::get($post['id']);
        $res = $course_categories->allowField(['name'])->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }
}
