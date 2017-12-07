<?php
/**
 *  通用工具
 */
 namespace Helper;

class CommonHelper
{
    /**
     * Get value of global config
     * @param array $modules
     * @param string $column
     * @param string $defaultValue
     * @return array|string
     */
    public static function config($modules = [], $column = '', $defaultValue = '')
    {
        if (empty($modules)) {
            return $defaultValue;
        }
        if (!is_array($modules)) {
            $modules = [$modules];
        }
        $configs = getConfig($modules);
        if (!empty($configs) && !empty($column)) {
            return ArrayHelper::getValue($configs, $column, $defaultValue);
        }
        return $configs;
    }
}