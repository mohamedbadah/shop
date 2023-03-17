<?php
namespace App\services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter{
    protected $apiKey;
    
    private $baseUrl="https://free.currconv.com/api/v7";
    public function __construct($apiKey)
    { 
        $this->apiKey=$apiKey;       
    }
    public function converter(string $from,string $to,$amout=1){
        $q="{$from}_{$to}";
     $response=Http::baseUrl($this->baseUrl)->get("/convert",[
        "q"=>$q,
        "compact"=>"y",
        "apiKey"=>$this->apiKey,
     ]);

     $result= $response->json();
     return $result[$q]["val"];
    }
}
?>