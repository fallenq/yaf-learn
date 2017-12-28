<?php
use Yaf\Dispatcher;
use Yaf\Action_Abstract;
use Tool\UploadTool;
use Helper\ArrayHelper;

class SingleFormAction extends Action_Abstract
{
    public function execute () {
        $upload = new UploadTool();
        $fileInfo = $upload->processTempFileInfo();
        $upload->store(ArrayHelper::getValue($fileInfo, 'file.tmp_name'), ArrayHelper::getValue($fileInfo, 'file.name'));
        return false;
    }
}