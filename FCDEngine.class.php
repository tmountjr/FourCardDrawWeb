<?php

class FCDEngine
{
    private static $key = 'fcd';
    private $data = array();
    private $cards = array();

    public function __construct(array $cards)
    {
        $this->cards = $cards;
    }
    
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
        
        $cards = array("A", "A", "A", "A", "A");
        $cards[rand(0, 4)] = "L";
        return new FCDEngine($cards);
    }
    
    public static function Reset($key = '')
    {
        @session_start;
        if ($key !== '') {
            self::$key = $key;
        }
        
        unset($_SESSION[self::$key]['object']);
    }
    
    public static function GetKey()
    {
        return self::$key;
    }
    
    public function GetCards()
    {
        return $this->cards;
    }
    
    public function TurnOverCard($card_index)
    {
        $can_continue = true;
        if ($this->cards[$card_index] === 'L') {
            $can_continue = false;
        }
        return $can_continue;
    }
}