<?php
namespace Modules\Test\Models;

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

    const COLUMN_FIELDS = ['name', 'type'];

}