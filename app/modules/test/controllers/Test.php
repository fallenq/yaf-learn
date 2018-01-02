<?php 

use Yaf\Dispatcher;
use Yaf\Controller_Abstract;

class TestController extends Controller_Abstract
{

    public $actions = array(
        "index" => "modules/test/actions/index/IndexAction.php",
        "order" => "modules/test/actions/test/Order.php",
    );
	
//	public function testHelloAction()
//	{
//		Dispatcher::getInstance()->disableView();
//		echo 'Hello!world';
//	}
}
