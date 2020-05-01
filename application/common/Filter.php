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
        $fields = ['wd', 'openid', 'unionid', 'nickname', 'phone', 'added_at', 'vip', 'balance'];

        foreach ($fields as $field) {
            $this->_conditions[$field] = $params[$field] ?? '';
        }

        if ($this->_conditions['wd']) {
            $this->_filters['phone|openid|u.unionid'] = ['like', '%' . $this->_conditions['wd'] . '%'];
        }

        if ($this->_conditions['openid']) {
            $this->_filters['openid'] = $this->_conditions['openid'];
        }

        if ($this->_conditions['unionid']) {
            $this->_filters['u.unionid'] = $this->_conditions['unionid'];
        }

        if ($this->_conditions['phone']) {
            $this->_filters['phone'] = $this->_conditions['phone'];
        }

        if ($this->_conditions['vip']) {
            $this->_filters['v.vip'] = $this->_conditions['phone'];
        }

        if ($this->_conditions['nickname']) {
            $this->_filters['nickname'] = ['like', '%' . $this->_conditions['nickname'] . '%'];
        }

        if ($this->_conditions['balance']) {
            $this->_filters['v.balance'] = $this->setBetweenFilter($this->_conditions['balance'], false);
        }

        if ($this->_conditions['added_at']) {
            $this->_filters['u.added_at'] = $this->setBetweenFilter($this->_conditions['added_at']);
        }
    }
}
