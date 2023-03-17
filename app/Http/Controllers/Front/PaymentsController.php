<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Exception;

class PaymentsController extends Controller
{
    public function create(Order $order){
        return view("front.payment.create",["order"=>$order]);
    }
    public function createPaymentIntent(Order $order){
        $amount=$order->items->sum(function($item){
            return $item->price*$item->quantity;
        });
         $stripe = new \Stripe\StripeClient(config("services.stripe.secret_key"));
        $paymentIntent=$stripe->paymentIntents->create([
            'amount' => $amount,
            'currency' => 'usd',
            'automatic_payment_methods' => [
              'enabled' => true,
            ],
          ]);
         
          try{
            $payment=new Payment();
            $payment->forceFill([
                'order_id'=>$order->id,
                "amount"=>$paymentIntent->amount,
                'currency'=>$paymentIntent->currency,
                "status"=>"pending",
                "transaction-id"=>$paymentIntent->id,
                "method"=>"stripe",
                "transaction-data"=>json_encode($paymentIntent)
            ])->save();
            return redirect()->route("home",[
                "status"=>"paymentSuccess"
            ]);

        }catch(Exception $e){
            echo $e->getMessage();
        }
          

          return [
            'clientSecret' => $paymentIntent->client_secret,
          ];
    }
    public function confirm(Request $request,Order $order){
        $stripe = new \Stripe\StripeClient(config("services.stripe.secret_key"));
          $payment_intent=$stripe->paymentIntents->retrieve(
            $request->query("payment_intent"),
            []
          );
        //   dd($payment_intent);
          if($payment_intent->status=="succeeded"){
            try{
                $payment=Payment::where("order_id",$order->id)->first();
                $payment->forceFill([
                    "status"=>"completed",
                    "transaction-data"=>json_encode($payment_intent)
                ])->save();
            }catch(Exception $e){
                echo $e->getMessage();
            }

            return redirect()->route("home",[
              "status"=>"payments success"
          ]);
          }

          return redirect()->route("order.payment.create",[
            'order'=>$order->id,
            'status'=>$payment_intent->status
          ]);

    }
}
