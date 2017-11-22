<?php
namespace Models\test;

use Extension\DB\BaseModelExtend;
use Extension\DB\ModelExtend;
use Illuminate\Database\Eloquent\SoftDeletes;

class SparrowTest extends \EloquentModel
{
    use SoftDeletes, BaseModelExtend, ModelExtend;

    protected $table = 'sparrow_test';

    /**
     * 获取字段名数组
     * @return array
     */
    private static function getTableColumns()
    {
        return [
            'name', 'type', 'created_at', 'update_at'
        ];
    }

    /**
     * Get the name of the "deleted at" column.
     *
     * @return string
     */
    public function getDeletedAtColumn()
    {
        return defined('static::DELETED_AT') ? static::DELETED_AT : 'delete_at';
    }
}