<?php
/**
 *  通用工具
 */
 namespace Helper;

 class CommonTool
 {
     /**
      * 测试方法
      */
     public static function test($method, ...$params)
     {
        dd($method, $params);
     }
 }