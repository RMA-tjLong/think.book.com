<?php

namespace app\common\traits;

trait Filter
{
    protected $conditions = [];

    protected function setBetweenFilter($filter_str)
    {
        $filter_arr = explode('_', $filter_str);

        if (!$filter_arr[0] && $filter_arr[1]) {
            return ['<=', $filter_arr[1]];
        }

        if ($filter_arr[0] && !$filter_arr[1]) {
            return ['>=', $filter_arr[0]];
        }

        if ($filter_arr[0] && $filter_arr[1]) {
            return ['between', [$filter_arr[0], $filter_arr[1]]];
        }
    }
}
