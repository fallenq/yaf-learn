<?php
/**
 * Redis tool
 */
namespace Tool;

use Helper\ArrayHelper;
use Helper\CommonHelper;

class RedisTool
{

    const SELECT        = 'select';
    const PING          = 'ping';
    const SET           = 'set';

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
            $password = ArrayHelper::getValue($config, 'password', '', 1);
            if (!empty($host) && !empty($port)) {
                $this->connection = new \Redis();
                $connected = $this->connection->connect($host, $port);
                if ($connected && !empty($password)) {
                    $this->connection->auth($password);
                }
            }
        }
    }

    public function execute($command, ...$options)
    {
        if (empty($this->connection)) {
            return '';
        }
        if (empty($command)) {
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

    public function set($key, $value, $expire = 0)
    {
        if (empty($key)) {
            return '';
        }
        if (!empty($expire)) {
            return $this->connection->setex($key, $expire, $value);
        } else {
            return $this->connection->set($key, $value);
        }
    }

}