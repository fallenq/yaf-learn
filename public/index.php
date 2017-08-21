<?php

use Yaf\Application;

date_default_timezone_set('Asia/Shanghai');

define('ENV', 'DEV');
define('ROOT_PATH', dirname(__DIR__));
define('CUR_DATE', date('Y-m-d'));
define('APPLICATION_PATH', dirname(__DIR__));

$application = new Application( APPLICATION_PATH . "/conf/application.ini");

$application->bootstrap()->run();
?>
