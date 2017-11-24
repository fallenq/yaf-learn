<?php
namespace Extension\DB;

use Helper\ArrayHelper;

trait BaseModelExtend
{

    /**
     * Set name of connection in model
     * @param $model
     * @param string $connectionName
     */
    private function setModelConnection($connectionName = '')
    {
        if (empty($connectionName)) {
            return $this;
        }
        return $this->setConnection($connectionName);
    }

    /**
     * Set name of table in model
     * @param $model
     * @param string $tableName
     */
    private function setTableName($tableName = '')
    {
        if (empty($tableName)) {
            return $this;
        }
        return $this->setTable($tableName);
    }

    /**
     * Get record by prime key
     * @param $primeValue
     * @param int $withTrashed
     * @param array ...$options
     */
    public static function primeRecord($primeValue, $withTrashed = 0, ...$options)
    {
        if (empty($primeValue)) {
            return '';
        }
        $model = new self();
        $model = $model->setTableName(ArrayHelper::getValue($options, 'table'));
        $model = $model->setModelConnection(ArrayHelper::getValue($options, 'connect'));
        if (!empty($withTrashed)) {
            $model = $model->withTrashed();
        }
        return $model->where($model->getKeyName(), $primeValue)->first();
    }
    
}