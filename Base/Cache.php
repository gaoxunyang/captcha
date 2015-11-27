<?php
namespace Base;
class Cache
{
    private static $_instance;
    private $_memcache;

    private function __construct()
    {
        $this->_memcache = new \Memcache();
        $this->_memcache->connect('localhost', 11211);
    }

    private function __clone()
    {

    }

    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function set($key, $value, $exptime)
    {
        return $this->_memcache->set($key, $value, 0, $exptime);
    }

    public function get($key)
    {
        return $this->_memcache->get($key);
    }

    public function delete($key)
    {
        return $this->_memcache->delete($key);
    }
}