<?php

namespace app\admin\controller;

use think\Env;
use think\Request;
use app\admin\model\ActivitiesModel;
use think\Db;

class Activities extends Base
{
    use \app\common\traits\Filter;

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 查看视频列表
     *
     * @return void
     */
    public function list($kind = 1)
    {
        $get = Request::instance()->get();
        $current_page = $get['page'] ?? 1;
        $res = Db::name('activities')
            ->alias('activities')
            ->field('activities.*, admins.username')
            ->join('admins admins', 'admins.id = activities.adminid')
            ->where($this->getFilters($get))
            ->where('activities.kind', $kind)
            ->order('activities.added_at desc')
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

        if ($this->conditions['wd']) $filters['activities.title'] = ['like', '%' . $this->conditions['wd'] . '%'];
        if ($this->conditions['s1']) $filters['activities.title'] = $this->conditions['s1'];
        if ($this->conditions['s2']) $filters['activities.status'] = $this->conditions['s2'];
        if ($this->conditions['s3']) $filters['activities.added_at'] = $this->setBetweenFilter($this->conditions['s3']);

        return $filters;
    }

    /**
     * 查看活动详情
     *
     * @return void
     */
    public function info($id = '')
    {
        $data = Db::name('activities')
            ->alias('activities')
            ->field('activities.*, admins.username')
            ->join('admins admins', 'admins.id = activities.adminid')
            ->find($id);

        exit(ajax_return_ok($data));
    }

    /**
     * 删除活动
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

        $urls = Db::name('activities')
            ->where(['id' => ['in', $ids]])
            ->column('url');
        $urls = array_filter($urls);

        foreach ($urls as $url) @unlink(ROOT_PATH . 'public' . $url);
        if (ActivitiesModel::destroy($ids)) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 软删除活动
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

        $res = ActivitiesModel::where(['id' => ['in', $ids]])->update(['status' => 0]);
        
        if ($res) exit(ajax_return_ok());
        exit(ajax_return_error('sql_error'));
    }

    /**
     * 添加活动
     *
     * @return void
     */
    public function store()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'title'  => 'require',
            'kind'   => 'in:1,2',
            'status' => 'in:1,2'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $activities = new ActivitiesModel($post);
        $post['adminid'] = $this->uid;
        $res = $activities->allowField(true)->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }

    /**
     * 更新活动
     *
     * @return void
     */
    public function update()
    {
        if (!Request::instance()->isPost()) exit;

        $post = Request::instance()->post();
        $result = $this->validate($post, [
            'id'     => 'require',
            'kind'   => 'in:1,2',
            'title'  => 'require',
            'status' => 'require|in:1,2'
        ]);

        if (true !== $result) exit(ajax_return_error('validate_error'));

        $activities = ActivitiesModel::get($post['id']);
        $res = $activities->allowField(['title', 'content', 'url', 'kind', 'status'])->save($post);

        if ($res) exit(ajax_return_ok());

        exit(ajax_return_error('sql_error'));
    }
}
