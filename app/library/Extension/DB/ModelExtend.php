<?php
namespace Extension\DB;

use Helper\ArrayHelper;

trait ModelExtend
{
    /**
     * 主键名称
     * @var string
     */
//    protected $primaryKey = 'id';
    /**
     * 是否自增主键
     * @var bool
     */
//    protected $incrementing = true;

    /**
     * 过滤保存参数
     * @param &$model
     * @param $params
     * @param $columns
     */
    private static function column_filter(&$model, $params, $columns)
    {
        foreach ($params as $key => $param) {
            if (!empty($key)) {
                if ($param === null) {
                    $param = '';
                }
                if ($key == $model->getKeyName()) {
                    unset($params[$key]);
                }
                if (in_array($key, $columns)) {
                    $model->$key = $param;
                } else {
                    unset($params[$key]);
                }
            }
        }
        return $params;
    }

    /**
     * 保存
     * @param $params
     */
    public static function store($params, $primeValue = '', $model = null)
    {
        $isAutoInc = false;
        $isUpdate = 0;
        if (empty($model)) {
            $model = new self();
            $isAutoInc = $model->getIncrementing();
            $primeName = $model->getKeyName();
            if (!$isAutoInc && empty($primeValue)) {
                return ['code' => 500, 'message' => '缺少主键'];
            }
            if (!empty($primeValue)) {
                if (method_exists($model,'getDeletedAtColumn')) {
                    $record = $model->withTrashed()->where($primeName, $primeValue)->first();
                } else {
                    $record = $model->where($primeName, $primeValue)->first();
                }
                if (!empty($record)) {
                    $model = $record;
                    $isUpdate = 1;
                }
            }
        } else if(!($model instanceof self)) {
            return ['code' => 500, 'message' => '对象类型不符'];
        }
        if (!empty($model)) {
            $params = self::column_filter($model, $params, self::getTableColumns());
            if (!empty($isUpdate)) {
                if ($model->save()) {
                    return ['code' => 200, 'is_new'=>0, 'primeKeyId'=>$primeValue, 'message' => ''];
                }
            } else {
                if ($isAutoInc) {
                    $primeKeyId = $model->insertGetId($params);
                } else {
                    $model->$primeName = $primeValue;
                    if ($model->save()) {
                        $primeKeyId = $primeValue;
                    }
                }
                if (!empty($primeKeyId)) {
                    return ['code' => 200, 'is_new'=>1, 'primeKeyId'=>$primeKeyId, 'message' => ''];
                }
            }
        }
        return ['code' => 500, 'message' => '数据保存失败'];
    }
}