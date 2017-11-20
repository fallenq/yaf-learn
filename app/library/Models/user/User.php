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
}