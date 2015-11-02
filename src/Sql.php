<?php
namespace PhpLogger;

/**
 * @link    https://github.com/ddniel16/php-logger
 * @author  ddniel16 <ddniel16@gmail.com>
 * @license MIT
 */
class Sql
{

    protected $_mysqli;

    protected $_user;
    protected $_pass;
    protected $_port;
    protected $_host;
    protected $_name;

    public function connect()
    {

        $this->_mysqli = new \mysqli(
            $this->getHost(),
            $this->getUser(),
            $this->getPassword(),
            $this->getDbName()
        );

    }

    public function save($log, $priorityMsg)
    {

        $this->connect();
        $log = $this->_mysqli->real_escape_string($log);
        $priorityMsg = $this->_mysqli->real_escape_string($priorityMsg);

        $fields = '(`priority`, `log`)';
        $values = '("' . $priorityMsg . '", "' . $log . '")';

        $query = 'INSERT INTO `PhpLogger` ' . $fields .' VALUES ' . $values;

        $this->_mysqli->query($query);

    }

    public function setUser($user)
    {
        $this->_user = $user;
        return $this;
    }

    public function getUser()
    {
        $user = $this->_user;
        return $user;
    }

    public function setPassword($pass)
    {
        $this->_pass = $pass;
        return $this;
    }

    public function getPassword()
    {
        $pass = $this->_pass;
        return $pass;
    }

    public function setHost($host = 'localhots')
    {
        $this->_host = $host;
        return $this;
    }

    public function getHost()
    {
        $host = $this->_host;
        return $host;
    }

    public function setPort($port = 3306)
    {
        $this->_port = $port;
        return $this;
    }

    public function getPort()
    {
        $port = $this->_port;
        return $port;
    }

    public function setDbName($name)
    {
        $this->_name = $name;
        return $this;
    }
    
    public function getDbName()
    {
        $name = $this->_name;
        return $name;
    }

}