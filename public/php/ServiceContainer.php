<?php
class ServiceContainer{
    // private static $container=[];
    // public static function bind($name,$instance){
    //     self::$container[$name]=$instance;
    // }
    // public static function make($name){
    //     return self::$container[$name];
    // }
    private static $container=[];
    public static function bind($name,$instance){
        self::$container[$name]=$instance;
    }
    public static function make($name){
        return self::$container[$name];
    }
}
?>