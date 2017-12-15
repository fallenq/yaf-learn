<?php
/**
 * ResponseTool
 */
namespace Tool\Response;

use Helper\JsonHelper;

class ResponseTool
{
    const SUCCESS_METHOD = 1;
    const ERROR_METHOD = 2;
    const VALIDATE_METHOD = 3;

    private $model = null;

    public static function getInstance()
    {
        return new static();
    }

    public function getModel()
    {
        if (is_null($this->model)) {
            $this->model = ResponseModel::getInstance();
            $this->model->_error();
        }
        return $this->model;
    }

    public function setModel($model)
    {
        if ($model instanceof ResponseModel) {
            $this->model = $model;
        }
    }

    public function emptyModel()
    {
        $this->setModel(null);
    }

    public function validateCode($method, $code)
    {
        if (!in_array($method, [static::SUCCESS_METHOD, static::ERROR_METHOD, static::VALIDATE_METHOD])) {
            return false;
        }
        if (is_null($this->model)) {
            return false;
        }
        if (is_null($code)) {
            if ($method == static::SUCCESS_METHOD) {
                $code = ResponseConfig::SUCCESS;
            } else if($method == static::ERROR_METHOD) {
                $code = ResponseConfig::ERROR;
            } else if($method == static::VALIDATE_METHOD) {
                return false;
            }
        }
        return $code == $this->getModel()->getCode();
    }

    public function isSuccess($code = null)
    {
        return $this->validateCode(static::SUCCESS_METHOD, $code);
    }

    public function isError($code = null)
    {
        return $this->validateCode(static::ERROR_METHOD, $code);
    }

    public function isCode($code) {
        return $this->validateCode(static::VALIDATE_METHOD, $code);
    }

    public function output($jsonp = 0, $callback = '')
    {
        return JsonHelper::convertToJson($this->getModel()->transform(), $jsonp, $callback);
    }
}