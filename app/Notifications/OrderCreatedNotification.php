<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $order;
    public function __construct(Order $order)
    {
        $this->order=$order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
        $channels=['database'];
        if($notifiable->notification_preferences['order_created']['sms'] ?? false){
            $channels[]="vonage";
        }
        if($notifiable->notification_preferences['order_created']['mail'] ?? false){
            $channels[]="mail";
        }
        if($notifiable->notification_preferences['order_created']['broadcast'] ?? false){
            $channels[]="broadcast";
        }
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $addr=$this->order->billingAddress;
        // dd($addr);
        return (new MailMessage)
                    ->subject("New Order # {$this->order->number}")
                    ->from("notification@gmail.com","mohamed")
                    ->line('The introduction to the notification.')
                    ->greeting("Hi {$notifiable->name}")
                    ->line("View Order(#{$this->order->number}) created by {$addr->name} from {$addr->country_name}")
                    ->action('Notification Action', url('/dashboard/index'))
                    ->line('Thank you for using our application!');
    }
    public function toDatabase($notifiable){
        $addr=$this->order->billingAddress;
        return[
            'body'=>"View Order(#{$this->order->number}) created by {$addr->name} from {$addr->country_name}",
            'icon'=>"fas fa-envelope mr-2",
            "url"=>url("/dashboard/index"),
            "order_id"=>$this->order->id
        ];
    }
    public function toBroadcast($notifiable){
        $addr=$this->order->billingAddress;
        return new BroadcastMessage([
            'body'=>"View Order(#{$this->order->number}) created by {$addr->name} from {$addr->country_name}",
            'icon'=>"fas fa-envelope mr-2",
            "url"=>url("/dashboard/index"),
            "order_id"=>$this->order->id
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
