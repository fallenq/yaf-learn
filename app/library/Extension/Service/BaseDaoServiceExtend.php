<?php
namespace Extension\Service;

trait BaseDaoServiceExtend
{

    /**
     * Get record by prime key
     * @param $primeValue
     * @param int $withTrashed
     * @param array ...$options
     */
    public static function primeRecord($primeValue, $withTrashed = 0, ...$options)
    {
        return call_user_func_array([self::$daoModelClass, 'primeRecord'], [$primeValue, $withTrashed, $options]);
    }

    /**
     * Get store method name
     * @return string
     */
    public static function getStoreMethod()
    {
        return defined('static::STORE_METHOD') ? static::STORE_METHOD : 'store';
    }

    /**
     * Execute model store
     * @param $params
     * @param null $model
     * @param array ...$options
     */
    public static function store($params, $model = null, ...$options)
    {
        return call_user_func_array([self::$daoModelClass, self::getStoreMethod()], [$params, $model, $options]);
    }
}