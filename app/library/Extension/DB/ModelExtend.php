<?php
namespace Extension\DB;

use Helper\ArrayHelper;

trait ModelExtend
{

    /**
     * 获取表主键名（默认'id'，需要时重构）
     */
    private static function getPrimeKeyName()
    {
        return 'id';
    }

    /**
     * 获取主键是否自定义（默认非自增，需要时重构）
     */
    private static function getPrimeCustom()
    {
        return 0;
    }

    /**
     * 获取参数主键内容
     */
    private static function getPrimeKeyValue($params)
    {
        return ArrayHelper::getValue($params, self::getPrimeKeyName());
    }

    /**
     * 过滤保存参数
     * @param &$model
     * @param $params
     * @param $columns
     */
    private static function column_filter(&$model, $params, $columns)
    {
        $primeCustom = self::getPrimeCustom();
        foreach ($params as $key => $param) {
            if (!empty($key)) {
                if ($param === null) {
                    $param = '';
                }
                if ($key == self::getPrimeKeyName()) {
                    if (!empty($primeCustom)) {
                        continue;
                    }
                }
                if (in_array($key, $columns)) {
                    $model->$key = $param;
                }
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
        $isCreate = 0;
        $isPrimeCustom = self::getPrimeCustom();
        $primeName = self::getPrimeKeyName();
        $primeValue = self::getPrimeKeyValue($params);
        if (empty($record)) {
            if (!empty($primeValue)) {
                $record = self::where($primeName, $primeValue)->first();
                if (empty($record)) {
                    $record = new self();
                    $isCreate = 1;
                }
            } else if ($isPrimeCustom == 0) {
                $record = new self();
                $isCreate = 1;
            } else {
                return ['code' => 500, 'message' => '缺少主键'];
            }
        }
        if (!empty($record)) {
            $record = self::column_filter($record, $params, self::getTableColumns());
            if ($isCreate) {
                $record->save();
            } else {
                // 修改
//                $record->update();
            }
        }
        return ['code' => 500, 'message' => '数据保存失败'];
    }
}