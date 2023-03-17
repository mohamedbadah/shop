<?php
namespace A;

use A\B\Person;
use FacadePerson;
use ServiceContainer;

// include __DIR__."/A/B/Person.php";
// include __DIR__."/B/Person.php";
include __DIR__."/autoload.php";
$person=new \A\B\Person;
$person->name="mohammeds";
$person->setAge(24);
ServiceContainer::bind('Person',$person);
echo FacadePerson::name("ahmed");
echo FacadePerson::age();
exit;
use function \A\B\hello;
$person=new \A\B\Person;
$person2=new \B\Person;
$person->name="mohammed";
$person2->name="Ahmed";
// Person::$country="palestine";
$person::$country="palestine";
var_dump($person);
echo "<br/>";
var_dump($person2);
echo "<br/>";
echo $person2::$country."<br>";
echo $person2::MALE;
echo "<br>";
echo "------------------------------------------"."<br>";
$person2->setAge(20);
echo $person2->getAge();
echo "<br>";
echo "------------------------------------------"."<br>";
echo hello();
echo "<br>";
echo "------------------------------------------"."<br>";
echo "istanceOf"."<br>";
if($person2 instanceof \B\Human){
   echo "YES";
}
?>