<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Currency;
use Illuminate\Http\Request;
use App\services\CurrencyConverter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConverterController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'currency'=>'required|string|size:3'
        ]);
        $currency_code=$request->currency;
        $baseCurrency=config("app.currency");
        $cacheKey="cuurency_".$currency_code;
        $rate=Cache::get($cacheKey,0);
        if(!$rate){
        $converter=new CurrencyConverter(config("services.currency_converter.api_key"));
        $rate=$converter->converter($baseCurrency,$currency_code);
        Cache::put("cuurency_{$currency_code}",$rate,now()->addMinute(60));
        Session::put("currency_code",$currency_code);
        return redirect()->back();
        }
    }
}
