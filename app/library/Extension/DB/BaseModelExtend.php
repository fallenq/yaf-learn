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
    public function setModelConnection($connectionName = '')
    {
        if (!empty($connectionName)) {
            $this->setConnection($connectionName);
        }
    }

    /**
     * Set name of table in model
     * @param $model
     * @param string $tableName
     */
    public function setTableName($tableName = '')
    {
        if (!empty($tableName)) {
            $this->setTable($tableName);
        }
    }

    private function setCustomOptions(...$options)
    {
        $this->setTableName(ArrayHelper::getValue($options, 'table'));
        $this->setModelConnection(ArrayHelper::getValue($options, 'connect'));
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
        $model->setCustomOptions($options);
        if ($withTrashed == 1) {
            $model = $model->withTrashed();
        } else if($withTrashed == -1) {
            $model = $model->onlyTrashed();
        }
        return $model->where($model->getKeyName(), $primeValue)->first();
    }
    
}