<?php
namespace Modules\Test\Services\Dao;

use Extension\Service\BaseDaoServiceExtend;
use Modules\Test\Models\SparrowTest;

class TestDaoService
{
    use BaseDaoServiceExtend;

//    const STORE_METHOD = 'restore';

    private static $daoModelClass = SparrowTest::class;

}