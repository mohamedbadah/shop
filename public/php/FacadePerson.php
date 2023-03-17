<?php
class FacadePerson{
  // protected static $contaner='Person';
  //  public static function __callStatic($name, $arguments)
  // {
  //   $person=ServiceContainer::make(self::$contaner);
  //   return $person->$name(...$arguments);
  // }
  protected static $contaner='Person';
  public static function __callStatic($name, $arguments)
  {
    $person=ServiceContainer::make(self::$contaner);
    return $person->$name(...$arguments);
  }
}
?>