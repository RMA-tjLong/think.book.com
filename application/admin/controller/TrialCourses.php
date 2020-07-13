<?php

namespace app\admin\controller;

use think\Env;
use think\Request;
use app\common\model\TrialCoursesModel;
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
            ->field('trial_courses.*, admins.username, course_categories.name as cat_name')
            ->join('admins', 'admins.id = trial_courses.adminid')
            ->join('course_categories', 'trial_courses.catid = course_categories.id', 'left')
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

        if ($this->conditions['wd']) $filters['trial_courses.name'] = ['like', '%' . $this->conditions['wd'] . '%'];
        if ($this->conditions['s1']) $filters['trial_courses.name'] = $this->conditions['s1'];
        if ($this->conditions['s2']) $filters['trial_courses.status'] = $this->conditions['s2'];
        if ($this->conditions['s3']) $filters['trial_courses.added_at'] = $this->setBetweenFilter($this->conditions['s3']);
        if ($this->conditions['s4']) $filters['trial_courses.catid'] = $this->conditions['s4'];

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

    /**
     * 删除试听课程
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
        if (TrialCoursesModel::destroy($ids)) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 软删除试听课
     *
     * @return void
     */
    public function delete()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'ids' => 'require',
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $ids = $post['ids'];

        if (!is_array($ids)) $ids = [$ids];

        $res = TrialCoursesModel::where(['id' => ['in', $ids]])->update(['status' => 0]);

        if ($res) exit(ajax_return_ok());
        exit(ajax_return_error('sql_error'));
    }

    /**
     * 添加试听课程
     *
     * @return void
     */
    public function store()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'name'   => 'require',
            'status' => 'in:1,2',
            'catid'  => 'require'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $ads = new TrialCoursesModel($post);
        $post['adminid'] = $this->uid;
        $res = $ads->allowField(true)->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 更新试听课程
     *
     * @return void
     */
    public function update()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'id'     => 'require',
            'name'   => 'require',
            'status' => 'require|in:1,2',
            'catid'  => 'require'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $ads = TrialCoursesModel::get($post['id']);
        $res = $ads->allowField(['name', 'content', 'status', 'catid'])->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }
}
