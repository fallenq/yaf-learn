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
        if (empty($fileInfo)) {
            if (count($fileInfo) == 1) {
                $singleInfo = array_shift($fileInfo);
                $singleUrl = $this->singleUpload($upload, $singleInfo);
                var_dump($singleUrl);
            } else {
                $this->multiUpload($upload, $fileInfo);
            }
        } else {
            var_dump('error');
        }
        return false;
    }

    private function singleUpload($upload, $fileInfo)
    {
        return $upload->store(ArrayHelper::getValue($fileInfo, 'tmp_name'), ArrayHelper::getValue($fileInfo, 'name'));
    }

    private function multiUpload($upload, $fileInfo)
    {
        $outUrls = [];
        foreach ($fileInfo as $item) {
            if ($outUrl = $this->singleUpload($upload, $item)) {
                $outUrls[] = $outUrl;
            }
        }
        var_dump($outUrls);
    }
}