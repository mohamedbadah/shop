<?php
namespace B;
use \A\B\Person as PersonA;
function hello(){
    return "hello B";
}
class Person extends PersonA{
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
//    public function setAge($age){
//     $this->age=$age;
//    }
//    public function getAge(){
//     return $this->age;
//    }
   public static function setCountry($country){
    // self::$country=$country;
    // parent::setCountry($country);
    static::setCountry($country);
   }
   
}

?>