<?php
namespace Extension\DB;

use Helper\ArrayHelper;

trait ModelExtend
{
    private static $primeCustom = 0;
    private static $primeKeyName = '';
    private static $tableColumns = [];

    /**
     * 获取表主键名
     */
    private static function getPrimeKeyName()
    {
        return self::$primeKeyName;
    }

    /**
     * 获取参数主键内容
     */
    private static function getPrimeKeyValue($params)
    {
        return ArrayHelper::getValue($params, self::getPrimeKeyName());
    }

    /**
     * 获取字段名数组
     * @return array
     */
    private static function getTableColumns()
    {
        return self::$tableColumns;
    }

    /**
     * 过滤保存参数
     * @param &$model
     * @param $params
     * @param $columns
     */
    private static function column_filter(&$model, $params, $columns)
    {
        foreach ($params as $key => $param) {
            if ($param === null) {
                $param = '';
            }
            if ($key == self::getPrimeKeyName()) {
                if(!empty(self::$primeCustom)){
                    continue;
                }
            }
            if (in_array($key, $columns)) {
                $model->$key = $param;
            }
        }
        return $model;
    }

    /**
     * 保存
     * @param $params
     */
    public static function store($params, $record = null)
    {
        $primeName = self::getPrimeKeyName();
        $primeValue = self::getPrimeKeyValue($params);
        if (empty($record)) {
            $record = self::where($primeName, $primeValue)->first();
        }
        if (!empty($record)) {
            $record = self::column_filter($record, $params, self::getTableColumns());
//            if ($record->save() > 0) {
//
//            }
        }
        return ['code' => 500, 'message' => '数据保存失败'];
    }
}