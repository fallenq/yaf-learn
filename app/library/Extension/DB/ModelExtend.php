<?php
namespace Extension\DB;

use Helper\ArrayHelper;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

trait ModelExtend
{

    /**
     * 获取字段名数组
     * @return array
     */
    private static function getTableColumns()
    {
        return defined('static::COLUMN_FIELDS')? static::COLUMN_FIELDS: [];
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
    public static function store($params, $model = null, ...$options)
    {
        if (empty($params)) {
            return ['code' => 500, 'message' => '参数不能为空'];
        }
        $isAutoInc = false;
        $primeValue = '';
        $isUpdate = 0;
        $isReturnModel = ArrayHelper::getValue($options, 'return_model');
        if (empty($model)) {
            $model = new static();
            $model->setCustomOptions($options);
            $isAutoInc = $model->getIncrementing();
            $primeName = $model->getKeyName();
            $primeValue = ArrayHelper::getValue($params, $primeName);
            if (!$isAutoInc && empty($primeValue)) {
                return ['code' => 500, 'message' => '缺少主键'];
            }
            if (!empty($primeValue)) {
                if ($model->isSoftDelete()) {
                    // 软删除的model取全部状态
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
            $params = static::column_filter($model, $params, static::getTableColumns());
            if (!empty($isUpdate)) {
                if ($model->save()) {
                    return ['code' => 200, 'is_new'=>0, 'primeKeyId'=>$primeValue, 'message' => '', 'model' => !empty($isReturnModel)? $model: ''];
                }
            } else {
                $primeKeyId = '';
                if (!$isAutoInc) {
                    $model->$primeName = $primeValue;
                } else if(!empty($primeValue)) {
                    $model->$primeName = $primeValue;
                }
                if ($model->save()) {
                    $primeKeyId = $model->getAttribute($primeName);
                }
                if (!empty($primeKeyId)) {
                    return ['code' => 200, 'is_new'=>1, 'primeKeyId'=>$primeKeyId, 'message' => '', 'model' => !empty($isReturnModel)? $model: ''];
                }
            }
        }
        return ['code' => 500, 'message' => '数据保存失败'];
    }
}