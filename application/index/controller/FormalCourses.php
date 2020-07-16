<?php

namespace app\index\controller;

use think\Env;
use think\Request;
use app\common\model\FormalCoursesModel;
use think\Db;

class FormalCourses extends Base
{
    use \app\common\traits\Filter;

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 查看试听课程列表
     *
     * @return void
     */
    public function list()
    {
        $get = Request::instance()->get();
        $current_page = $get['page'] ?? 1;
        $res = Db::name('formal_courses')
            ->alias('formal_courses')
            ->field('formal_courses.*, admins.username, course_categories.name as cat_name')
            ->join('admins', 'admins.id = formal_courses.adminid')
            ->join('course_categories', 'course_categories.id = formal_courses.catid', 'left')
            ->where($this->getFilters($get))
            ->order('added_at desc')
            ->paginate(null, false, [
                'page' => $current_page,
                'path' => Env::get('app.client_url')
            ]);

        $data = [
            'list'   => $res->items(),
            'render' => $res->render()
        ];

        exit(ajax_return_ok($data));
    }

    /**
     * 获取筛选数组
     *
     * @return void
     */
    protected function getFilters($params = [])
    {
        $this->fields = ['wd', 's1', 's2', 's3', 's4'];
        $filters = [];
        $this->setConditions($params);

        if ($this->conditions['wd']) $filters['formal_courses.name'] = ['like', '%' . $this->conditions['wd'] . '%'];
        if ($this->conditions['s1']) $filters['formal_courses.name'] = $this->conditions['s1'];
        if ($this->conditions['s2']) $filters['formal_courses.status'] = $this->conditions['s2'];
        if ($this->conditions['s3']) $filters['formal_courses.added_at'] = $this->setBetweenFilter($this->conditions['s3']);
        if ($this->conditions['s4']) $filters['formal_courses.catid'] = $this->conditions['s4'];

        return $filters;
    }

    /**
     * 查看试听课程详情
     *
     * @return void
     */
    public function info($id = '')
    {
        $data = Db::name('formal_courses')
            ->alias('formal_courses')
            ->field('formal_courses.*, admins.username, course_categories.name as cat_name')
            ->join('admins', 'admins.id = formal_courses.adminid')
            ->join('course_categories', 'course_categories.id = formal_courses.catid', 'left')
            ->order('added_at desc')
            ->find($id);

        exit(ajax_return_ok($data));
    }
}
