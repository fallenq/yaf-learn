<?php
/**
 * Redis tool
 */
namespace Tool;

use Helper\ArrayHelper;
use Helper\CommonHelper;

class RedisTool
{

    const DEFAULT_TIMEOUT   = 3;
    const SELECT        = 'select';
    const PING          = 'ping';
    const SET           = 'set';
    const DEL           = 'del';
    const SETNX         = 'setnx';

    private $connection = null;

    function __construct($dbName = '', $dbId = 0, ...$options)
    {
        $this->setConnection($dbName, $options);
        if (!empty($dbId)) {
            $this->execute(static::SELECT, $dbId);
        }
    }

    public function setConnection($dbName, ...$options)
    {
        $config = CommonHelper::config('redis', $dbName, []);
        if (!empty($config)) {
            $host = ArrayHelper::getValue($config, 'host', '127.0.0.1', 1);
            $port = intval(ArrayHelper::getValue($config, 'port', '6379'));
            $timeout = 0;
            if (ArrayHelper::keyExists($config, 'timeout')) {
                $timeout = intval(ArrayHelper::getValue($config, 'timeout', 0));
                $timeout = !empty($timeout)? $timeout: static::DEFAULT_TIMEOUT;
            }
            $password = ArrayHelper::getValue($config, 'password', '', 1);
            if (!empty($host) && !empty($port)) {
                $this->connection = new \Redis();
                $connected = $this->connection->connect($host, $port, $timeout);
                if ($connected && !empty($password)) {
                    $this->connection->auth($password);
                }
            }
        }
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
        if (empty($this->connection)) {
            return '';
        }
        if (empty($this->validateCommand($command, $options))) {
            return '';
        }
        return call_user_func_array([$this, $command], $options);
    }

    public function select($dbId)
    {
        return $this->connection->select($dbId);
    }

//    public function getConnection()
//    {
//        return $this->connection;
//    }

    public function ping()
    {
        if ($this->connection->ping() == '+PONG') {
            return true;
        }
        return false;
    }

    public function close()
    {
        return $this->connection->close();
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
                return $this->expire($key, $expire);
            }
        }
        return false;
    }

    public function get($key)
    {
        return $this->connection->get($key);
    }

    public function del(...$keys)
    {
        return $this->connection->del($keys);
    }

}