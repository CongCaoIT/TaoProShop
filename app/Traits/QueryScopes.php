<?php

namespace App\Traits;

trait QueryScopes
{
    public function scopeKeyword($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where('name', 'LIKE', '%' . $keyword . '%');
        }
        return $query;
    }

    public function scopePublish($query, $publish)
    {
        if ($publish !== null && $publish != -1) {
            $query->where('publish', '=', $publish);
        }
        return $query;
    }

    public function scopeCustomWhere($query, $where = [])
    {
        if (isset($where) && count($where)) {
            foreach ($where as $key => $val) {
                $query->where($val[0], $val[1], $val[2]);
            }
        }
        return $query;
    }

    public function scopeCustomWhereRaw($query, $rawQuery)
    {
        if (is_array($rawQuery) && !empty($rawQuery)) {
            foreach ($rawQuery as $key => $val) {
                $query->whereRaw($val[0], $val[1]);
            }
        }
        return $query;
    }

    public function scopeRelationCount($query, $relation)
    {
        if (isset($relation) && !empty($relation)) {
            foreach ($relation as $item) {
                $query->withCount($item);
            }
        }
        return $query;
    }

    public function scopeRelation($query, $relation)
    {
        if (isset($relation) && !empty($relation)) {
            foreach ($relation as $item) {
                $query->with($item);
            }
        }
        return $query;
    }

    public function scopeCustomJoin($query, $join)
    {
        if (isset($join) && is_array($join) && count($join)) {
            foreach ($join as $key => $value) {
                $query->join($value[0], $value[1], $value[2], $value[3]);
            }
        }
        return $query;
    }

    public function scopeCustomGroupBy($query, $groupBy)
    {
        if (!empty($groupBy)) {
            $query->groupBy($groupBy);
        }
        return $query;
    }

    public function scopeCustomOrderBy($query, $orderBy)
    {
        if (isset($orderBy) && !empty($orderBy)) {
            $query->orderBy($orderBy[0], $orderBy[1]);
        }
        return $query;
    }
}
