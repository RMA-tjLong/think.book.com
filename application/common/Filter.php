<?php

namespace app\common;

class Filter
{
    private static $_instance;
    private $_name;
    private $_conditions = [];
    private $_filters = [];

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getFilters($params = [])
    {
        if (!$params) return [];

        $method = 'get' . $this->_name . 'Filters';

        if (method_exists($this, $method)) {
            call_user_func([$this, $method], $params);
            return $this->_filters;
        }

        return [];
    }

    public function setClass($class = '')
    {
        $this->_name = basename(str_replace('\\', '/', $class));
        return $this;
    }

    private function setBetweenFilter($filter_str, $i_time = true)
    {
        $filter_arr = explode('_', $filter_str);

        if (!$filter_arr[0] && $filter_arr[1]) {
            return ['<=' . ($i_time ? ' time' : ''), $filter_arr[1]];
        }

        if ($filter_arr[0] && !$filter_arr[1]) {
            return ['>=' . ($i_time ? ' time' : ''), $filter_arr[0]];
        }

        if ($filter_arr[0] && $filter_arr[1]) {
            return ['between' . ($i_time ? ' time' : ''), [$filter_arr[0], $filter_arr[1]]];
        }
    }

    private function getUsersFilters($params = [])
    {
        $fields = ['wd', 's1', 's2', 's3', 's4', 's5', 's6', 's7', 's8', 's9', 's10'];

        foreach ($fields as $field) {
            $this->_conditions[$field] = $params[$field] ?? '';
        }

        if ($this->_conditions['wd']) {
            $this->_filters['phone|openid|u.unionid'] = ['like', '%' . $this->_conditions['wd'] . '%'];
        }

        if ($this->_conditions['s1']) {
            $this->_filters['openid'] = $this->_conditions['s1'];
        }

        if ($this->_conditions['s2']) {
            $this->_filters['u.unionid'] = $this->_conditions['s2'];
        }

        if ($this->_conditions['s3']) {
            $this->_filters['phone'] = $this->_conditions['s3'];
        }

        if ($this->_conditions['s4']) {
            $this->_filters['nickname'] = ['like', '%' . $this->_conditions['s4'] . '%'];
        }

        if ($this->_conditions['s5']) {
            $this->_filters['u.added_at'] = $this->setBetweenFilter($this->_conditions['s5']);
        }

        if ($this->_conditions['s6']) {
            $this->_filters['b_v.vip'] = $this->_conditions['s6'];
        }

        if ($this->_conditions['s7']) {
            $this->_filters['b_v.balance'] = $this->setBetweenFilter($this->_conditions['s7'], false);
        }

        if ($this->_conditions['s8']) {
            $this->_filters['b_v.ended_at'] = $this->setBetweenFilter($this->_conditions['s8']);
        }

        if ($this->_conditions['s9']) {
            $this->_filters['c_v.vip'] = $this->_conditions['s9'];
        }

        if ($this->_conditions['s10']) {
            $this->_filters['c_v.balance'] = $this->setBetweenFilter($this->_conditions['s10'], false);
        }
    }

    private function getVideosFilters($params = [])
    {
        $fields = ['wd', 's1', 's2', 's3', 's4'];
        
        foreach ($fields as $field) {
            $this->_conditions[$field] = $params[$field] ?? '';
        }

        if ($this->_conditions['wd']) {
            $this->_filters['name'] = ['like', '%' . $this->_conditions['wd'] . '%'];
        }

        if ($this->_conditions['s1']) {
            $this->_filters['name'] = $this->_conditions['s1'];
        }

        if ($this->_conditions['s2']) {
            $this->_filters['status'] = $this->_conditions['s2'];
        }

        if ($this->_conditions['s3']) {
            $this->_filters['added_at'] = $this->setBetweenFilter($this->_conditions['s3']);
        }
    }
}
