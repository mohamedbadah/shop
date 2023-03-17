<?php
namespace App\Repository\Cart;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface CartRepository{
    public function getItem();
    public function add(Product $product,$quantity=1);
    public function delete($id);
    public function update($id,$quantity);
    public function empty();
    public function total():float;
}

?>