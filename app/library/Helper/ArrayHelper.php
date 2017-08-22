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

    /**
     * compare two array，get the difference of value
     * @param $source
     * @param $compare
     */
    public static function compareValue($source, $compare, $method = 0)
    {
        $methods = ['array_diff', 'array_diff_key'];
        if(!is_array($source) || !is_array($compare)){
            return [];
        }
        if(!array_keys($methods, $method)){
            return [];
        }
        return [
            'addition'     =>    call_user_func_array($methods[$method], [$source, $compare]),
            'redundant'    =>    call_user_func_array($methods[$method], [$compare, $source]),
        ];
    }
    
}