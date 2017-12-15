<?php
/**
 * ResponseModel
 */
namespace Tool\Response;

use Helper\ArrayHelper;

class ResponseModel {

    private $code   = 0;
    private $msg    = '';
    private $data   = [];
    private $url    = '';

    public static function getInstance() {
        return new self();
    }

    public function getCode() {
        return $this->code;
    }

    public function setCode($code) {
        $this->code = $code;
    }

    public function getMsg() {
        return $this->msg;
    }

    public function setMsg($msg) {
        $this->msg = $msg;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data = []) {
        $this->data = $data;
    }

    public function getDataValue($column, $defaultValue = '') {
        return ArrayHelper::getValue($this->data, $column, $defaultValue);
    }

    public function setDataValue($column, $value) {
        return ArrayHelper::setValue($this->data, $column, $value);
    }

    public function _init()
    {
        $this->setCode(0);
        $this->setMsg('');
        $this->setData();
        $this->setUrl('');
    }

    public function _error($msg = '', $clear = 0)
    {
        if ($clear) {
            $this->_init();
        }
        $this->setCode(ResponseConfig::ERROR);
        $this->setMsg(!empty($msg)? $msg: ResponseConfig::COMMON_ERROR_MSG);
    }

    public function _success($msg = '', $clear = 0)
    {
        if ($clear) {
            $this->_init();
        }
        $this->setCode(ResponseConfig::SUCCESS);
        $this->setMsg($msg);
    }

    public function transform()
    {
        $output = [
            'code'  =>  $this->code,
            'msg'   =>  $this->msg,
            'data'  =>  $this->data,
            'url'   =>  $this->url
        ];
        return $output;
    }

}