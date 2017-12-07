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

    public static function getRedisConnection(...$options)
    {
        $dbName = ArrayHelper::getValue($options, 'db', '', 1);
        $dbIndex = ArrayHelper::getValue($options, 'index', 0);
        $dbName = !empty($dbName) ? $dbName : self::getRedisDbName();
        $dbIndex = !empty($dbIndex) ? $dbIndex : self::getRedisDbIndex();
        return new RedisTool($dbName, $dbIndex);
    }

}