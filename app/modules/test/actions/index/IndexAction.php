<?php
use Yaf\Action_Abstract;
use Helper\TimeHelper;
use Helper\ArrayHelper;
use Models\user\User;

class IndexAction extends Action_Abstract
{
    public function execute () {
//        dd(User::where([])->get());
//        \Helper\CommonTool::test('hello', 'world');
        dd(ArrayHelper::compareDifference(['b'=>2, 'c'=>3, 'd'=>4], ['a'=>1, 'b'=>2, 'c'=>3]));
        echo TimeHelper::formatTimestamp(null, 1, "-10 days");
//        var_dump(ArrayHelper::getValue(['t1'=>['v1'=>['c1']]], 't1.v1', 0));
        dd(ArrayHelper::getValue(['t1'=>['v1'=>['c1']]], 't1.v1', 0));
        exit('hello');
//        assert($name == $this->getRequest()->getParam("name"));
//        assert($id   == $this->getRequest()->getParam("id"));
    }
}