<?php
use Yaf\Action_Abstract;
use Helper\CommonHelper;
use Helper\TimeHelper;
use Helper\ArrayHelper;
use Modules\Test\Models\SparrowTest;
use Modules\Test\Services\Dao\TestDaoService;
use Modules\Test\Services\Func\TestFuncService;
use Tool\RedisTool;

class IndexAction extends Action_Abstract
{
    public function execute () {
//        dd(User::where([])->get());
        $stime = date('Y-m-d H:i:s');

//        $redis = new RedisTool('test', 1);
//        dd($redis->execute(\Tool\RedisTool::SET, 'hello', 'world', 20));
//        var_dump(SparrowTest::store(['name'=>"dd"], $user, 0));

//        dd(TestFuncService::getInstance());
//        dd(getConfig('common', 'test'));
//        dd(TestDaoService::store([]));
//        dd(TestDaoService::store(['name'=>"dd"]));
        dd(ArrayHelper::compareDifference(['b'=>2, 'c'=>3, 'd'=>4], ['a'=>1, 'b'=>2, 'c'=>3]));
//        echo TimeHelper::formatTimestamp(null, 1, "-10 days");

//        var_dump(ArrayHelper::getValue(['t1'=>['v1'=>['c1']]], 't1.v1', 0));
        dd(ArrayHelper::getValue(['t1'=>['v1'=>['c1']]], 't1.v1', 0));
        exit('hello');
//        assert($name == $this->getRequest()->getParam("name"));
//        assert($id   == $this->getRequest()->getParam("id"));
    }
}