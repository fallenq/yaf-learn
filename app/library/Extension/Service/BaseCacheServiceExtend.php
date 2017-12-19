<?php
namespace Extension\Service;

use Helper\ArrayHelper;
use Tool\RedisTool;

trait BaseCacheServiceExtend
{

    public static function getRedisDbName()
    {
        return defined('static::REDIS_DB') ? static::REDIS_DB : 'default';
    }

    public static function getRedisDbIndex()
    {
        return defined('static::REDIS_INDEX') ? static::REDIS_INDEX : '0';
    }

    public static function getRedisConfig(...$options)
    {
        $dbName = ArrayHelper::getValue($options, 'db', '', 1);
        $dbIndex = ArrayHelper::getValue($options, 'index', 0);
        if (empty($dbName)) {
            $dbName = self::getRedisDbName();
        }
        if (!empty($dbIndex)) {
            $dbIndex = self::getRedisDbIndex();
        }
        return ['dbName' => $dbName, 'dbIndex' => $dbIndex];
    }

    public static function getRedisConnection($connection = null, ...$options)
    {
        list($dbName, $dbIndex) = self::getRedisConfig($options);
        if ($connection instanceof RedisTool) {
            $connection->_initConfig($dbName, $dbIndex);
        } else {
            $connection = new RedisTool($dbName, $dbIndex);
        }
        return $connection;
    }

}