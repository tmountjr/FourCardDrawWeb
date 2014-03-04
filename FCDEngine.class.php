<?php

class FCDEngine
{
    private static $key = 'fcd';
    private $data = array();

    public function __construct() {}
    
    public function __set($property, $value)
    {
        $this->data[$property] = $value;
    }
    
    public function __get($property)
    {
        if (isset($this->data[$property])) {
            return $this->data[$property];
        }
    }
    
    public function __destruct()
    {
        $_SESSION[self::$key]['object'] = serialize($this);
    }
    
    public static function Init($key = '')
    {
        @session_start;
        if ($key !== '') {
            self::$key = $key;
        }
        
        if (isset($_SESSION[self::$key]['object']) === true) {
            return unserialize($_SESSION[self::$key]['object']);
        }
        
        return new FCDEngine;
    }
    
    public static function Reset($key = '')
    {
        @session_start;
        if ($key !== '') {
            self::$key = $key;
        }
        
        unset($_SESSION[self::$key]['object']);
    }

}