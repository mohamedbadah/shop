<?php
namespace App\Helpers;

use NumberFormatter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class Currency{
    public static function format($amount,$currency=null){
        $formater=new NumberFormatter(config('app.locale'),NumberFormatter::CURRENCY);
        $baseCurrency=config("app.currency");
        if($currency==null){
            $currency=Session::get("currency_code",$baseCurrency);
        }
        if($currency!=$baseCurrency){
            $rate=Cache::get("cuurency_".$currency);
            $amount=$amount*$rate;
        }
        return $formater->formatCurrency($amount,$currency);
    }
}
?>