<?php
namespace Models\test;

use Extension\DB\BaseModelExtend;
use Extension\DB\ModelExtend;
use Illuminate\Database\Eloquent\SoftDeletes;

class SparrowTest extends \EloquentModel
{
    use SoftDeletes, BaseModelExtend, ModelExtend;

    protected $table = 'sparrow_test';

//    protected $primaryKey = 'id';

//    protected $incrementing = false;

    const UPDATED_AT = 'update_at';
    const DELETED_AT = 'delete_at';

    /**
     * 获取字段名数组
     * @return array
     */
    private static function getTableColumns()
    {
        return [
            'name', 'type'
        ];
    }

}