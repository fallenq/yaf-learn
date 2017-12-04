<?php
/**
 * Redis tool
 */
namespace Tool;

use Helper\ArrayHelper;
use Helper\CommonTool;

class RedisTool
{

    private $connection = null;

    function __construct($dbName = '', $dbId = 0, ...$options)
    {
        $this->setConnection($dbName, $options);
        $this->selectDb($dbId);
    }

    public function setConnection($dbName, ...$options)
    {
        $config = CommonTool::config('redis', $dbName, []);
        if (!empty($config)) {
            $host = ArrayHelper::getValue($config, 'host', '127.0.0.1', 1);
            $port = intval(ArrayHelper::getValue($config, 'port', '6379'));
            $password = ArrayHelper::getValue($config, 'password', '', 1);
            if (!empty($host) && !empty($port)) {
                $this->connection = new \Redis();
                $this->connection->connect($host, $port);
                if (!empty($password)) {
                    $this->connection->auth($password);
                }
            }
        }
    }

    public function selectDb($dbId)
    {
        if (!empty($this->connection)) {
            $this->connection->select($dbId);
        }
    }

//    public function getConnection()
//    {
//        return $this->connection;
//    }

}