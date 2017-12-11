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
    const SELECT = 'select';
    const PING = 'ping';
    const EXPIRE = 'expire';
    const SET = 'set';
    const SETNX = 'setnx';
    const GETSET = 'getset';
    const MOVE = 'move';
    const GET = 'get';
    const DEL = 'del';
    const INCR = 'incr';
    const DECR = 'decr';

    private $connection = null;
    private $config = null;
    private $dbIndex = 0;
    private $_reset = 0;

    function __construct($dbName = '', $dbIndex = 0, ...$options)
    {
        $this->_initConfig($dbName, $dbIndex, $options);
    }

    private function setConfig($dbName, ...$options)
    {
        $this->config = CommonHelper::config('redis', $dbName, []);
    }

    public function _initConfig($dbName, $dbIndex = 0, ...$options)
    {
        $this->setConfig($dbName, $options);
        if (!empty($dbIndex)) {
            $this->dbIndex = $dbIndex;
        } else {
            $this->dbIndex = 0;
        }
        $this->_reset = 1;
    }

    public function _init(...$options)
    {
        $this->close();
        if ($this->setConnection($options) && !empty($this->dbIndex)) {
            $this->select($this->dbIndex);
        }
        $this->_reset = 0;
    }

    public function setConnection(...$options)
    {
        if (!empty($this->config)) {
            $host = ArrayHelper::getValue($this->config, 'host', '127.0.0.1', 1);
            $port = intval(ArrayHelper::getValue($this->config, 'port', '6379'));
            $timeout = 0;
            if (ArrayHelper::keyExists($this->config, 'timeout')) {
                $timeout = intval(ArrayHelper::getValue($this->config, 'timeout', 0));
                $timeout = !empty($timeout) ? $timeout : static::DEFAULT_TIMEOUT;
            }
            $password = ArrayHelper::getValue($this->config, 'password', '', 1);
            if (!empty($host) && !empty($port)) {
                $this->connection = new \Redis();
                $connected = $this->connection->connect($host, $port, $timeout);
                if ($connected && !empty($password)) {
                    $this->connection->auth($password);
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
        if (in_array($command, [static::PING])) {
            return true;
        }
        if ($options[0] !== '') {
            return true;
        }
        return false;
    }

    public function execute($command, ...$options)
    {
        if (!empty($this->_reset)) {
            $this->_init();
        }
        if (empty($this->connection)) {
            return false;
        }
        if (!method_exists($this, $command)) {
            return false;
        }
        if (empty($this->validateCommand($command, $options))) {
            return false;
        }
        return call_user_func_array([$this, $command], $options);
    }

    public function select($dbIndex)
    {
        return $this->connection->select($dbIndex);
    }

    public function ping()
    {
        if ($this->connection->ping() == '+PONG') {
            return true;
        }
        return false;
    }

    public function close()
    {
        if (empty($this->connection)) {
            return false;
        }
        if ($this->connection->close()) {
            $this->connection = null;
            return true;
        }
        return false;
    }

    public function expire($key, $expire = 0)
    {
        if (empty($expire)) {
            return $this->connection->persist();
        }
        return $this->connection->expire($key, $expire);
    }

    public function set($key, $value, $expire = 0)
    {
        if (!empty($expire)) {
            return $this->connection->setex($key, $expire, $value);
        } else {
            return $this->connection->set($key, $value);
        }
    }

    public function setnx($key, $value, $expire = 0)
    {
        if ($this->connection->setnx($key, $value)) {
            if (!empty($expire)) {
                $this->expire($key, $expire);
            }
            return true;
        }
        return false;
    }

    public function getset($key, $value)
    {
        return $this->connection->getset($key, $value);
    }

    public function move($key, $dbId)
    {
        return $this->connection->move($key, $dbId);
    }

    public function get($key)
    {
        return $this->connection->get($key);
    }

    public function del(...$keys)
    {
        return $this->connection->del($keys);
    }

    public function incr($key, $disc = 0)
    {
        $disc = $disc <= 1 ? 1 : $disc;
        return $this->connection->incrby($key, $disc);
    }

    public function decr($key, $disc = 0)
    {
        $disc = $disc <= 1 ? 1 : $disc;
        return $this->connection->decrby($key, $disc);
    }

}