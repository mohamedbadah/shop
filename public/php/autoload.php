<?php
// spl_autoload_register(function($classname){
//   include __DIR__."/{$classname}.php";
// });
class AutoLoader{
    public function register($classname){
        include __DIR__."/{$classname}.php";
    }
}
$a=new AutoLoader();
spl_autoload_register([$a,'register']);
?>