<?php
/**
 * 时间工具
 */
namespace Helper;

class TimeHelper
{
    /**
     * 格式化时间戳
     * @param null $timestamp
     * @param array ...$options
     */
    public static function formatTimestamp($timestamp = null, ...$options)
    {
        $timestamp = !empty($timestamp)? $timestamp: time();
        $method = ArrayHelper::getValue($options, 0);
        switch ($method) {
            case 1:
                $stampOption = ArrayHelper::getValue($options, 1, '');
                return self::formatTimestamp(strtotime($stampOption, $timestamp));
            default:
                return date('Y-m-d H:i:s', $timestamp);
        }
    }
}