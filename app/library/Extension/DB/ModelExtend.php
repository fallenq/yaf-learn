<?php
namespace Extension\DB;

use Helper\ArrayHelper;
use Illuminate\Support\Arr;

trait ModelExtend
{

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
                    continue;
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
    public static function store($params, $options = [], $model = null)
    {
        $isAutoInc = false;
        $primeValue = '';
        $isUpdate = 0;
        $isReturnModel = ArrayHelper::getValue($options, 'return_model');
        if (empty($model)) {
            $model = new self();
            $isAutoInc = $model->getIncrementing();
            $primeName = $model->getKeyName();
            $primeValue = ArrayHelper::getValue($params, $primeName);
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
                    return ['code' => 200, 'is_new'=>0, 'primeKeyId'=>$primeValue, 'message' => '', 'model' => !empty($isReturnModel)? $model: ''];
                }
            } else {
                $primeKeyId = '';
                if (!$isAutoInc) {
                    $model->$primeName = $primeValue;
                }
                if ($model->save()) {
                    $primeKeyId = $model->$primeName;
                }
                if (!empty($primeKeyId)) {
                    return ['code' => 200, 'is_new'=>1, 'primeKeyId'=>$primeKeyId, 'message' => '', 'model' => !empty($isReturnModel)? $model: ''];
                }
            }
        }
        return ['code' => 500, 'message' => '数据保存失败'];
    }
}