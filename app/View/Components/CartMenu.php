<?php

namespace App\View\Components;

use App\Facade\Cart;
use Illuminate\View\Component;
use App\Repository\Cart\CartRepository;

class CartMenu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $items;
    public $total;
    public function __construct()
    {
      $this->items=Cart::getItem();
      $this->total=Cart::total();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cart-menu');
    }
}
