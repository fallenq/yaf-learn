<?php
/**
 * 数组工具
 */
namespace Helper;

class ArrayHelper
{
    /**
     * Get the value of params
     * @param $params
     * @param $columnName
     * @param string $defaultValue
     * @param int $isTrim
     */
    public static function getValue($params, $columnName, $defaultValue = '', $isTrim = 0)
    {
        if (empty($params) || !isset($columnName)) {
            return $defaultValue;
        }
        if ($columnName === '') {
            return $defaultValue;
        }
        if (StringHelper::countSub($columnName, '.')) {
            $columns = explode('.', $columnName);
            $keyName = array_shift($columns);
            if (isset($params[$keyName])) {
                return self::getValue($params[$keyName], implode('.', $columns), $defaultValue);
            } else {
                return $defaultValue;
            }
        }
        if (isset($params[$columnName])) {
            $value = $params[$columnName];
            if (!empty($isTrim)) {
                $value = trim($value);
            }
            return $value;
        }
        return $defaultValue;
    }

    /**
     * Validate whether the column is in params
     * @param $params
     * @param $columnName
     */
    public static function keyExists($params, $columnName)
    {
        if (empty($params) || !isset($columnName)) {
            return false;
        }
        if ($columnName === '') {
            return false;
        }
        if (StringHelper::countSub($columnName, '.')) {
            $columns = explode('.', $columnName);
            $keyName = array_shift($columns);
            if (isset($params[$keyName])) {
                return self::keyExists($params[$keyName], implode('.', $columns));
            } else {
                return false;
            }
        }
        return isset($params[$columnName])? true: false;
    }

    /**
     * Compare two array，get the difference of value
     * @param $source
     * @param $compare
     */
    public static function compareDifference($source, $compare, $method = 0)
    {
        $methods = ['array_diff', 'array_diff_key'];
        if (!is_array($source) || !is_array($compare)) {
            return [];
        }
        if (!array_keys($methods, $method)) {
            return [];
        }
        return [
            'addition' => call_user_func_array($methods[$method], [$compare, $source]),
            'redundant' => call_user_func_array($methods[$method], [$source, $compare]),
        ];
    }
}