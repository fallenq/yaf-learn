<?php
/**
 */
namespace Models\user;

use Extension\DB\BaseModelExtend;
use Extension\DB\ModelExtend;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends \EloquentModel
{
    use SoftDeletes, BaseModelExtend, ModelExtend;

    /**
     * 获取表主键名
     */
//    private static function getPrimeKeyName()
//    {
//        return 'id';
//    }

    /**
     * 获取字段名数组
     * @return array
     */
    private static function getTableColumns()
    {
        return [
            self::getPrimeKeyName(), 'status'
        ];
    }

    /**
     * 获取主键是否自定义（默认非自增，需要时重构）
     */
//    private static function getPrimeCustom()
//    {
//        return 0;
//    }
}