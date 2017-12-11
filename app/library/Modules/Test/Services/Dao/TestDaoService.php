<?php
namespace Modules\Test\Services\Dao;

use Extension\Service\BaseDaoServiceExtend;
use Modules\Test\Models\SparrowTest;

class TestDaoService
{
    use BaseDaoServiceExtend;

//    const STORE_METHOD = 'restore';
//    const PRIME_METHOD = 'primeRecord';

    private static $daoModelClass = SparrowTest::class;

}