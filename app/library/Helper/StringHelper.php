<?php
/**
 * 字符串工具
 */
namespace Helper;

class StringHelper
{

    /**
     * 获取字符串出现位置
     * @param $source
     * @param $sub
     * @param int $method 0-首次出现 1-(不区分)首次出现 2-最后出现 3-(不区分)最后出现
     */
    public static function locatePos($source, $sub, $method = 0)
    {
        $methods = ['strpos', 'stripos', 'strrpos', 'strripos'];
        if (!isset($source) || !isset($sub) || !in_array($method, array_keys($methods))) {
            return false;
        }
        return call_user_func_array($methods[$method], [$source, $sub]);
    }

    /**
     * 统计子字符串的出现次数
     * @param $source
     * @param $sub
     */
    public static function countSub($source, $sub)
    {
        if (!isset($source) || !isset($sub)) {
            return 0;
        }
        return substr_count($source, $sub);
    }
}