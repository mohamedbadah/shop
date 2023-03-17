<?php
namespace A\B;

use Info;
use B\Human;
define("AJAYAl",true);
const LARAVEL="LARAVEL A";
function hello(){
    return "hello A";
}
class Person implements Human{
    use Info;
   const MALE="m";
   const FEMALE="f";
   public $name="mohamed";
   protected $gender;
   private $age;
   public static $country;
   public function __construct()
   {
    return __CLASS__;
   }
   
   public static function setCountry($country){
    self::$country=$country;
   }
   public function name($name){
    $this->name=$name;
    return $this->name;
   }
   public function age(){
    return $this->age;
   }

}

?>