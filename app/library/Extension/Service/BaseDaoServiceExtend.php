<?php
namespace Extension\Service;

use Helper\ArrayHelper;

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
     * Get store method name
     * @return string
     */
    public static function getStoreMethod()
    {
        return defined('static::STORE_METHOD') ? static::STORE_METHOD : 'store';
    }

    /**
     * Get the name of model
     * @return string
     */
    public static function getDaoClass(...$options)
    {
        $daoClass = ArrayHelper::getValue($options, 'daoClass');
        if (empty($daoClass)) {
            $daoClass = defined('static::DEFAULT_DAO_CLASS') ? static::DEFAULT_DAO_CLASS : '';
        }
        return $daoClass;
    }

    /**
     * Get record by prime key
     * @param $primeValue
     * @param int $withTrashed
     * @param array ...$options
     */
    public static function primeRecord($primeValue, $withTrashed = 0, ...$options)
    {
        $daoClass = self::getDaoClass($options);
        if (empty($daoClass)) {
            return '';
        }
        return call_user_func_array([$daoClass, self::getPrimeMethod()], [$primeValue, $withTrashed, $options]);
    }

    /**
     * Execute model store
     * @param $params
     * @param null $model
     * @param array ...$options
     */
    public static function store($params, $model = null, ...$options)
    {
        $daoClass = self::getDaoClass($options);
        if (empty($daoClass)) {
            return ['code' => 500, 'message' => '类别不能为空'];
        }
        return call_user_func_array([$daoClass, self::getStoreMethod()], [$params, $model, $options]);
    }
}