<?php
namespace Extension\DB;

trait BaseModelExtend
{
    /**
     * Get record by prime key
     * @param $primeValue
     * @param int $withTrashed
     * @param array ...$options
     */
    public static function primeRecord($primeValue, $withTrashed = 0, ...$options)
    {
        if (empty($primeValue)) {
            return '';
        }
        $model = new self();
        if (!empty($withTrashed)) {
            $model = $model->withTrashed();
        }
        return $model->where($model->getKeyName(), $primeValue)->first();
    }
    
}