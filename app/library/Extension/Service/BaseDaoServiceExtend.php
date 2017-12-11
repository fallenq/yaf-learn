<?php
namespace Extension\Service;

trait BaseDaoServiceExtend
{
    private $model = null;

    /**
     * Get model of DaoService
     * @return null
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get instance of DaoService
     * @return BaseDaoServiceExtend
     */
    public static function getInstance()
    {
        return new self();
    }

    /**
     * Get prime record method name
     * @return string
     */
    public static function getPrimeMethod()
    {
        return defined('static::PRIME_METHOD') ? static::PRIME_METHOD : 'primeRecord';
    }

    /**
     * Get record by prime key
     * @param $primeValue
     * @param int $withTrashed
     * @param array ...$options
     */
    public static function primeRecord($primeValue, $withTrashed = 0, ...$options)
    {
        return call_user_func_array([self::$daoModelClass, self::getPrimeMethod()], [$primeValue, $withTrashed, $options]);
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