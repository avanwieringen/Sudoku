<?php

namespace Avanwieringen\Benchmark;

class Benchmarker {
    
    private static $events = array();
    
    public static function start($eventName) {
        self::$events[$eventName] = array(microtime(true),0);
    }
     
    public static function stop($eventName) {
        if(array_key_exists($eventName, self::$events)) {
            self::$events[$eventName][1] = microtime(true);
            return self::getTime($eventName);
        }
    }
    
    public static function getTime($eventName) {
        return self::$events[$eventName][1] - self::$events[$eventName][0];
    }
}