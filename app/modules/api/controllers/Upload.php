<?php

use Yaf\Dispatcher;
use Yaf\Controller_Abstract;

class UploadController extends Controller_Abstract
{
    public $actions = array(
        "single-form" => "modules/api/actions/upload/SingleFormAction.php",
    );
}