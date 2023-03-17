<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Nav extends Component
{
    public $items;
    public $active;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($context=0)
    {
        $this->items=$this->prepareItems(config("nav"));
        // $this->items=config("nav");
        $this->active=Route::currentRouteName();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.nav');
    }
    private function prepareItems($items){
        foreach($items as $key=>$item){
            $user=Auth::user();
            if(isset($item["ability"]) && !$user->can($item["ability"])){
                unset($items[$key]);
            }
        }
        return $items;

    }
}
