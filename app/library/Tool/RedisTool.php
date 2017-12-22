<?php
/**
 * Redis tool
 */
namespace Tool;

use Helper\ArrayHelper;
use Helper\CommonHelper;

class RedisTool
{

    const DEFAULT_TIMEOUT = 3;

    private $_connection = null;
    private $_config = null;
    private $_db = 0;
    private $_reset = 0;

    function __construct($dbName = '', $dbIndex = 0, ...$options)
    {
        $this->_initConfig($dbName, $dbIndex, $options);
    }

    private function setConfig($dbName, ...$options)
    {
        $this->_config = CommonHelper::config('redis', $dbName, []);
    }

    public function _initConfig($dbName, $dbIndex = 0, ...$options)
    {
        $this->setConfig($dbName, $options);
        if (!empty($dbIndex)) {
            $this->_db = $dbIndex;
        } else {
            $this->_db = 0;
        }
        $this->_reset = 1;
    }

    public function _init(...$options)
    {
        $this->close();
        if ($this->setConnection($options) && !empty($this->_db)) {
            $this->select($this->_db);
        }
        $this->_reset = 0;
    }

    public function setConnection(...$options)
    {
        if (!empty($this->_config)) {
            $host = ArrayHelper::getValue($this->_config, 'host', '127.0.0.1', 1);
            $port = intval(ArrayHelper::getValue($this->_config, 'port', '6379'));
            $timeout = 0;
            if (ArrayHelper::keyExists($this->_config, 'timeout')) {
                $timeout = intval(ArrayHelper::getValue($this->_config, 'timeout', 0));
                $timeout = !empty($timeout) ? $timeout : static::DEFAULT_TIMEOUT;
            }
            $password = ArrayHelper::getValue($this->_config, 'password', '', 1);
            if (!empty($host) && !empty($port)) {
                $this->_connection = new \Redis();
                $connected = $this->_connection->connect($host, $port, $timeout);
                if ($connected && !empty($password)) {
                    $this->_connection->auth($password);
                }
                return $connected;
            }
        }
        return false;
    }

    private function validateCommand($command, ...$options)
    {
        if (empty($command)) {
            return false;
        }
        $command = strtolower($command);
        if (in_array($command, ['ping', 'flushall'])) {
            return true;
        }
        if (!empty($options) && !is_null($options[0])) {
            return true;
        }
        return false;
    }

    public function __call($command, ...$options)
    {
        if (!$this->internalValidate($command, $options)) {
            return false;
        }
        return call_user_func_array([$this->_connection, strtolower($command)], $options);
    }

    public function internalValidate($command, ...$options)
    {
        if (!empty($this->_reset)) {
            $this->_init();
        }
        if (empty($this->_connection)) {
            return false;
        }
        if (empty($this->validateCommand($command, $options))) {
            return false;
        }
        return true;
    }

    public function ping()
    {
        if (!$this->internalValidate('ping')) {
            return false;
        }
        if ($this->_connection->ping() == '+PONG') {
            return true;
        }
        return false;
    }

    public function select($dbIndex = 0)
    {
        if (!$this->internalValidate(__METHOD__)) {
            return false;
        }
        return $this->_connection->select($dbIndex);
    }

    public function close()
    {
        if (empty($this->_connection)) {
            return false;
        }
        if ($this->_connection->close()) {
            $this->_connection = null;
            return true;
        }
        return false;
    }

    public function expire($key, $expire = 0)
    {
        if (!$this->internalValidate(__METHOD__, $key, $expire)) {
            return false;
        }
        if (empty($expire)) {
            return $this->_connection->persist();
        }
        return $this->_connection->expire($key, $expire);
    }

    public function set($key, $value, $expire = 0)
    {
        if (!$this->internalValidate(__METHOD__, $key, $value, $expire)) {
            return false;
        }
        if (!empty($expire)) {
            return $this->_connection->setex($key, $expire, $value);
        } else {
            return $this->_connection->set($key, $value);
        }
    }

    public function setnx($key, $value, $expire = 0)
    {
        if (!$this->internalValidate(__METHOD__, $key, $value, $expire)) {
            return false;
        }
        if ($this->_connection->setnx($key, $value)) {
            if (!empty($expire)) {
                $this->expire($key, $expire);
            }
            return true;
        }
        return false;
    }

    public function incr($key, $disc = 0)
    {
        if (!$this->internalValidate(__METHOD__, $key, $disc)) {
            return false;
        }
        $disc = $disc <= 1 ? 1 : $disc;
        return $this->_connection->incrby($key, $disc);
    }

    public function decr($key, $disc = 0)
    {
        if (!$this->internalValidate(__METHOD__, $key, $disc)) {
            return false;
        }
        $disc = $disc <= 1 ? 1 : $disc;
        return $this->_connection->decrby($key, $disc);
    }

}