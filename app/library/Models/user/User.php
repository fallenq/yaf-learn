<?php
/**
 */
namespace Models\user;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends \EloquentModel
{
    use SoftDeletes;
}