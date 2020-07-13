<?php

namespace app\index\controller;

use think\Env;
use think\Request;
use think\Db;

class TrialCourses extends Base
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
        $res = Db::name('trial_courses')
            ->alias('trial_courses')
            ->field('trial_courses.*, admins.username', 'course_categories.name as cat_name')
            ->join('admins', 'admins.id = trial_courses.adminid')
            ->join('course_categories', 'course_categories.id = trial_courses.catid', 'left')
            ->where($this->getFilters($get))
            ->where(['status' => 2])
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
        $this->fields = ['wd', 's1', 's2', 's3'];
        $filters = [];
        $this->setConditions($params);

        if ($this->conditions['wd']) $filters['trial_courses.name'] = ['like', '%' . $this->conditions['wd'] . '%'];
        if ($this->conditions['s1']) $filters['trial_courses.name'] = $this->conditions['s1'];
        if ($this->conditions['s2']) $filters['trial_courses.added_at'] = $this->setBetweenFilter($this->conditions['s2']);
        if ($this->conditions['s3']) $filters['trial_courses.catid'] = $this->conditions['s3'];

        return $filters;
    }

    /**
     * 查看试听课程详情
     *
     * @return void
     */
    public function info($id = '')
    {
        $data = Db::name('trial_courses')
            ->alias('trial_courses')
            ->field('trial_courses.*, admins.username, course_categories.name as cat_name')
            ->join('admins', 'admins.id = trial_courses.adminid')
            ->join('course_categories', 'course_categories.id = trial_courses.catid', 'left')
            ->order('added_at desc')
            ->find($id);

        exit(ajax_return_ok($data));
    }

    public function recordApply()
    {
        
    }
}
