<?php
use Yaf\Action_Abstract;
use Helper\TimeHelper;
use Helper\ArrayHelper;

class IndexAction extends Action_Abstract
{
    public function execute () {
        echo TimeHelper::formatTimestamp(null, 1, "-1 days");
//        var_dump(ArrayHelper::getValue(['t1'=>['v1'=>['c1']]], 't1.v1', 0));
        dd(ArrayHelper::getValue(['t1'=>['v1'=>['c1']]], 't1.v1', 0));
        exit('hello');
//        assert($name == $this->getRequest()->getParam("name"));
//        assert($id   == $this->getRequest()->getParam("id"));
    }
}