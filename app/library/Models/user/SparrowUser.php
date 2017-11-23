<?php
/**
 */
namespace Models\user;

use Extension\DB\BaseModelExtend;
use Extension\DB\ModelExtend;
use Illuminate\Database\Eloquent\SoftDeletes;

class SparrowUser extends \EloquentModel
{
    use SoftDeletes, BaseModelExtend, ModelExtend;

//    protected $primaryKey = 'id';

//    protected $incrementing = false;

    protected $table = 'sparrow_user';

    /**
     * 获取字段名数组
     * @return array
     */
    private static function getTableColumns()
    {
        return [
            'status'
        ];
    }
}