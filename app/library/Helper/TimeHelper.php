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
     * @param array ...$operateOptions
     */
    public static function formatTimestamp($timestamp = null, ...$operateOptions)
    {
        $timestamp = !empty($timestamp)? $timestamp: time();
        $method = ArrayHelper::getValue($operateOptions, 0);
        switch ($method) {
            case 1:
                $stampOption = ArrayHelper::getValue($operateOptions, 1, '');
                return self::formatTimestamp(strtotime($stampOption, $timestamp));
            default:
                return date('Y-m-d H:i:s', $timestamp);
        }
    }
}