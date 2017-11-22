<?php

use Extension\DB\BaseModelExtend;
use Extension\DB\ModelExtend;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseEloquentModel extends \EloquentModel
{
    use SoftDeletes, BaseModelExtend, ModelExtend;

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