<?php
use Yaf\Dispatcher;
use Yaf\Action_Abstract;
use Tool\UploadTool;
use Helper\ArrayHelper;

class FormAction extends Action_Abstract
{
    public function execute () {
        $upload = new UploadTool();
        $fileInfo = $upload->processTempFileInfo();
        $uploadFileUrl = $upload->store(ArrayHelper::getValue($fileInfo, 'file.tmp_name'), ArrayHelper::getValue($fileInfo, 'file.name'));
        var_dump($uploadFileUrl);
        return false;
    }
}