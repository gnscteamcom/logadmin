<?php

namespace App\Repositories;

class BaseRepository
{
    public function filterWheres(/*request对象或数组*/$request, /*需要查询的键值组成的数组*/array $where_keys) {
        $wheres = [];
        foreach ($where_keys as $key) {
            $val = $request[$key] ?? null;
            if(isset($val)) {
                $wheres[] = [$key, '=', $val];
            }
        }

        return $wheres;
    }
}
