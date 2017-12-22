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
        $timestamp = !empty($timestamp) ? $timestamp : time();
        $method = ArrayHelper::getValue($options, 0);
        switch ($method) {
            case 1:
                $stampOption = ArrayHelper::getValue($options, 1, '');
                return self::formatTimestamp(strtotime($stampOption, $timestamp));
            default:
                return date('Y-m-d H:i:s', $timestamp);
        }
    }

    /**
     * Get the last day of the month
     * @param $year
     * @param $month
     * @return int
     */
    public static function getMonthLast($year, $month)
    {
        if (in_array($month, [1, 3, 5, 7, 8, 10, 12])) {
            return 31;
        } else if (in_array($month, [4, 6, 9, 11])) {
            return 30;
        } else if ($month == 2) {
            if ($year % 400 == 0 || ($year % 4 == 0 && $year % 100 > 0)) {
                return 29;
            } else {
                return 28;
            }
        }
        return 0;
    }

}