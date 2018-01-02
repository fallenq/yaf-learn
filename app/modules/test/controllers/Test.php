<?php 

use Yaf\Dispatcher;
use Yaf\Controller_Abstract;

class TestController extends Controller_Abstract
{

    public $actions = array(
        "index" => "modules/test/actions/index/IndexAction.php",
        "testOrder" => "modules/test/actions/test/TestOrder.php",
    );
	
//	public function testHelloAction()
//	{
//		Dispatcher::getInstance()->disableView();
//		echo 'Hello!world';
//	}
}
