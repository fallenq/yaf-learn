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
     */
    public static function getValue($params, $columnName, $defaultValue = '')
    {
        if(empty($params) || !isset($columnName)){
            return $defaultValue;
        }
        if($columnName === ''){
            return $defaultValue;
        }
        if(StringHelper::countSub($columnName, '.')){
            $columns = explode('.', $columnName);
            $keyName = array_shift($columns);
            if(isset($params[$keyName])){
                return self::getValue($params[$keyName], implode('.', $columns), $defaultValue);
            }else{
                return $defaultValue;
            }
        }
        return isset($params[$columnName])? $params[$columnName]: $defaultValue;
    }
}