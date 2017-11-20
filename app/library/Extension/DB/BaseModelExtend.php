<?php
namespace Extension\DB;

trait BaseModelExtend
{
    /**
     * 获取记录通过主键，包含被删除的
     * @param $primeKey
     */
    public static function withTrashedRecordById($primeKey)
    {
//        return self::where(self::$primeKeyName, $primeKey)->
    }
}