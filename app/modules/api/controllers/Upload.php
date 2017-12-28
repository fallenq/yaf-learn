<?php

use Yaf\Dispatcher;
use Yaf\Controller_Abstract;

class UploadController extends Controller_Abstract
{
    public $actions = array(
        "form" => "modules/api/actions/upload/FormAction.php",
    );
}